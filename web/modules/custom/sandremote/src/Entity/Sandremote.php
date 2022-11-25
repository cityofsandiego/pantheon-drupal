<?php

namespace Drupal\sandremote\Entity;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\sandremote\SandremoteInterface;
use Drupal\user\EntityOwnerTrait;

/* For creating a "file" to pass to tika */
use Drupal\file\Entity\File;

/* for Xss::filter */ 
use Drupal\Component\Utility\Xss;
use Recurr\Exception;

/**
 * Defines the sandremote entity class.
 *
 * @ContentEntityType(
 *   id = "sandremote",
 *   label = @Translation("Sandremote"),
 *   label_collection = @Translation("Sandremotes"),
 *   label_singular = @Translation("sandremote"),
 *   label_plural = @Translation("sandremotes"),
 *   label_count = @PluralTranslation(
 *     singular = "@count sandremotes",
 *     plural = "@count sandremotes",
 *   ),
 *   bundle_label = @Translation("Sandremote type"),
 *   handlers = {
 *     "list_builder" = "Drupal\sandremote\SandremoteListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\sandremote\Form\SandremoteForm",
 *       "edit" = "Drupal\sandremote\Form\SandremoteForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "sandremote",
 *   admin_permission = "administer sandremote types",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "bundle",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "owner" = "uid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/sandremote",
 *     "add-form" = "/sandremote/add/{sandremote_type}",
 *     "add-page" = "/sandremote/add",
 *     "canonical" = "/sandremote/{sandremote}",
 *     "edit-form" = "/sandremote/{sandremote}/edit",
 *     "delete-form" = "/sandremote/{sandremote}/delete",
 *   },
 *   bundle_entity_type = "sandremote_type",
 *   field_ui_base_route = "entity.sandremote_type.edit_form",
 * )
 */
class Sandremote extends ContentEntityBase implements SandremoteInterface {

  use EntityChangedTrait;
  use EntityOwnerTrait;

  protected function apachesolr_clean_text($text) {
    // Remove invisible content.
    $text = preg_replace('@<(applet|audio|canvas|command|embed|iframe|map|menu|noembed|noframes|noscript|script|style|svg|video)[^>]*>.*</\1>@siU', ' ', $text);
    // Add spaces before stripping tags to avoid running words together.
    $text =  str_replace(array('<', '>'), array(' <', '> '), $text);
    // Use D9 Xss filter.
    $text =  Xss::filter($text, array());
    // Decode entities and then make safe any < or > characters.
    $text = htmlspecialchars(html_entity_decode($text, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');
    // Remove extra spaces.
    $text = preg_replace('/\s+/s', ' ', $text);
    // Remove white spaces around punctuation marks probably added
    // by the safety operations above. This is not a world wide perfect solution,
    // but a rough attempt for at least US and Western Europe.
    // Pc: Connector punctuation
    // Pd: Dash punctuation
    // Pe: Close punctuation
    // Pf: Final punctuation
    // Pi: Initial punctuation
    // Po: Other punctuation, including ¿?¡!,.:;
    // Ps: Open punctuation
    $text = preg_replace('/\s(\p{Pc}|\p{Pd}|\p{Pe}|\p{Pf}|!|\?|,|\.|:|;)/s', '$1', $text);
    $text = preg_replace('/(\p{Ps}|¿|¡)\s/s', '$1', $text);
    return $text;
  } 
  
  protected function cleanExtractedData(string $string): string {
    // Convert to valid UTF8.
    try {
      $text = iconv("UTF-8", "UTF-8//IGNORE", $string);
    } catch (Exception $exception) {
      \Drupal::logger('sandremote')
        ->error('Error trying to extract text on Sandremote ID: %id, on URL: %url, error: %error', ['%id' => $this->id(), '%url' => $this->field_url->value, '%error' => $exception->getMessage()]);
      $text = $string;
    }
    //$text = Unicode::convertToUtf8($string);
    // Convert to 3 character UTF8 @todo we can remove this if our DB supports 4 byte UTF8. 
    $text = preg_replace('/[\x{10000}-\x{10FFFF}]/u', "\xEF\xBF\xBD", $text);
    // Use clean up routine originally found in D7 apachesolr.
    $text = trim($this->apachesolr_clean_text($text));
    // Many of our documents have table of contents with . . . , pull those out.
    $text = preg_replace('/\. \. \./', ' ', $text);
    $text = preg_replace('/\.\.\./', ' ', $text);
    return $text;
  }

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);
    if (!$this->getOwnerId()) {
      // If no owner has been set explicitly, make the anonymous user the owner.
      $this->setOwnerId(0);
    }
    $this->setDescription();
  }
  
  private function extractText($url) {
    
    $extractor_plugin_id = 'tika_extractor';
    $config_of_search_api_attachments = \Drupal::configFactory()
      ->getEditable('search_api_attachments.admin_config');
    $configuration = $config_of_search_api_attachments->get($extractor_plugin_id . '_configuration');
    /** @var \Drupal\search_api_attachments\Plugin\search_api_attachments\TikaExtractor $extractor_plugin */
    $extractor_plugin = \Drupal::service('plugin.manager.search_api_attachments.text_extractor')
      ->createInstance($extractor_plugin_id, $configuration);
    
    $file = File::create([
      'filename' => $url,
      'uri' => $url,
      'status' => 1,
      'uid' => 1,
    ]);
    
    try {
      $extracted_data = $extractor_plugin->extract($file);
      return $this->cleanExtractedData($extracted_data);
    } catch (\Exception $e) {
      \Drupal::logger('sandremote')
        ->error('Error trying to extract text on Sandremote ID: %id, on URL: %url, error: %error', ['%id' => $this->id(), '%url' => $this->field_url->value, '%error' => $e->getMessage()]);
      return '';
    }
  }
  
  private function changed() {
    return true;
  }

  /**
   * Set the Description to the extracted text.
   * 
   * @return void
   */
  private function setDescription() {
    // Decide the entity has been changed based on custom logic.
    if ($this->changed()) {
      $url = $this->field_url->value;
      $description = $this->description->value;
      // If no URL and no Description, nothing to do just return.
      if (empty($url) && empty($description)) {
        return;
      }
      
      if (empty($url)) {
        // Blank out the description.
        $this->description->value = '';
      }
      else {
        // Extract the text from the URL.
        $this->description->value = $this->extractText($url);
      }  
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['label'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Label'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Status'))
      ->setDefaultValue(TRUE)
      ->setSetting('on_label', 'Enabled')
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'settings' => [
          'display_label' => FALSE,
        ],
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'boolean',
        'label' => 'above',
        'weight' => 0,
        'settings' => [
          'format' => 'enabled-disabled',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'label' => 'above',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Author'))
      ->setSetting('target_type', 'user')
      ->setDefaultValueCallback(static::class . '::getDefaultEntityOwner')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => 15,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'author',
        'weight' => 15,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time that the sandremote was created.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the sandremote was last edited.'));

    return $fields;
  }

}
