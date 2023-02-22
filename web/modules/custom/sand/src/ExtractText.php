<?php

namespace Drupal\sand;

//use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Component\Utility\Xss;
use Drupal\file\Entity\File;
use Recurr\Exception;

use Drupal\Core\Entity\ContentEntityBase;

use Drupal\Core\DependencyInjection\ContainerNotInitializedException;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\sand\Sand;

/**
 * Service description.
 */
class ExtractText {

  //  /**
  //   * The container.
  //   *
  //   * @var \Symfony\Component\DependencyInjection\ContainerInterface
  //   */
  //  protected $container;

  public $entity_type;
  public $entity_id;
  public $source_field;
  public $target_field;

  public function getEntityType() {
    return $this->entity_type;
  }

  public function setEntityType($entity_type) {
    $this->entity_type = $entity_type;
    return $this;
  }

  public function getEntityId() {
    return $this->entity_id;
  }

  public function setEntityId($entity_id) {
    $this->entity_id = $entity_id;
    return $this;
  }

  public function getSourceField() {
    return $this->source_field;
  }

  public function setSourceField($source_field) {
    $this->source_field = $source_field;
    return $this;
  }

  public function getTargetField() {
    return $this->target_field;
  }

  public function setTargetField($target_field) {
    $this->target_field = $target_field;
    return $this;
  }


  //  /**
  //   * Constructs an ExtractText object.
  //   *
  //   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
  //   *   The container.
  //   */
  //  public function __construct(ContainerInterface $container) {
  //    $this->container = $container;
  //  }

  public function extractText(): string {

    $extractor_plugin_id = \Drupal::config("search_api_attachments.admin_config")
      ->get("extraction_method");
    $config_of_search_api_attachments = \Drupal::configFactory()
      ->get('search_api_attachments.admin_config');
    $configuration = $config_of_search_api_attachments->get($extractor_plugin_id . '_configuration');
    /** @var \Drupal\search_api_attachments\Plugin\search_api_attachments\TikaExtractor $extractor_plugin */
    $extractor_plugin = \Drupal::service('plugin.manager.search_api_attachments.text_extractor')
      ->createInstance($extractor_plugin_id, $configuration);

    // Load the entity could be a node or a sand_remote object or something else.
    $entity = \Drupal::entityTypeManager()
      ->getStorage($this->getEntityType())
      ->load($this->getEntityId());
    $url = $this->getUrlValue($entity);
    
    // If the field is empty then return nothing.
    if (empty($url)) {
      return '';
    }

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
      \Drupal::logger('sand_remote')
        ->error('Error trying to extract text on %entity_type ID: %id, on URL: %url, error: %error', [
          '%entity_type' => $this->getEntityType(),
          '%id' => $this->getEntityId(),
          '%url' => $url,
          '%error' => $e->getMessage(),
        ]);
      return '';

    }

  }

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
      \Drupal::logger('sand_remote')
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

  public function setText(): bool {
    $changed = FALSE;
    $entity = \Drupal::entityTypeManager()
      ->getStorage($this->getEntityType())
      ->load($this->getEntityId());

    // Set variable to say we are setting the Text so don't fire our hooks
    // for insert and update.
    
    /** @var \Drupal\Core\TempStore\PrivateTempStore $tempstore */
    $tempstore = \Drupal::service('tempstore.private');
    $store = $tempstore->get('extracting_text');
    $store->set('entity_type_id', $this->getEntityType() . ':' . $this->getEntityId());

    // Source field.
    $url = $this->getUrlValue($entity);
    
    // Target field.
    $target_field = $this->getTargetField();
    $target_value = $entity->$target_field->value;

    // If source and target are empty then just return.
    if (empty($url) && empty($target_value)) {
      return FALSE;
    }
    
    // If the source url is empty then clear out the target field.
    if (empty($url)) {
      $entity->$target_field->value = '';
      $changed = TRUE;
    }

    // Extract the text from the URL.
    $extracted_text = $this->extractText();
    // If the extracted text is different than the current value, update it.
    if ($target_value !== $extracted_text) {
      $entity->$target_field->value = $extracted_text;
      $changed = TRUE;
    }
    
    // If we changed something, save it.
    if ($changed) {
      $entity->save();
    }
    
    // Delete out the variable that says we are processing it.
    $store->delete('entity_type_id');
    
    // Return if we changed the entity or not.
    return $changed;
    
  }

  private function getSourceUrlField(ContentEntityBase $entity, $field_name = 'field_source_name'): string {
    $url_field = '';
    if ($entity->hasField($field_name)) {
      $source_name = $entity->get($field_name)->value;
      $url_field = match ($source_name) {
        'sire', 'onbase' => 'field_a_webc_url',
        'documentum', 'external' => 'field_document_url',
        default => '',
      };
    }
    if (empty($url_field)) {
      \Drupal::logger(__CLASS__)
        ->notice(
          'Could not get a source field for entity: %entity id: %id',
          [ '%entity' => $entity->getEntityType(), '%id' => $entity->id()]
        );
    }
    return $url_field;
  }
  
  private function getUrlValue($entity) {
    // Source field.
    $source_field = $this->getSourceField();
    if ($entity->hasField($source_field)) {
      $source_field_type = $entity->$source_field->getFieldDefinition()->getType();
      if ($source_field_type === 'link') {
        $url = $entity->$source_field->uri;
      } else {
        $url = $entity->$source_field->value;
      }
      return $url;
    }
    else {
      return '';
    }
  }

  private function getTargetFieldName(ContentEntityBase $entity): string {
    if ($entity->getEntityTypeId() === 'node') {
      return 'body';      
    } else {
      return 'field_body';    
    }
  }

  function queueEntityForTextExtract($entity_type, $entity): bool {
    // See if we are in the process of setting a field equal to it's extracted text, then skip the update to avoid a loop.
    $source_field = $this->getSourceUrlField($entity);
    $target_field = $this->getTargetFieldName($entity);

    if (empty($source_field)) {
      return FALSE;
    }

    /** @var \Drupal\Core\TempStore\PrivateTempStore $tempstore */
    $tempstore = \Drupal::service('tempstore.private');
    $store = $tempstore->get('extracting_text');
    $is_processing = $store->get('entity_type_id');

    if ($is_processing) {
      return FALSE;
    }

    $queue = \Drupal::service('queue')->get('sand_remote_queue');
    $item = new \Drupal\sand\ExtractText();
    $item->setEntityType($entity_type);
    $item->setEntityId($entity->id());
    $item->setSourceField($source_field);
    $item->setTargetField($target_field);

    try {
      $queue->createItem($item);
    } catch (Exception $exception) {
      watchdog_exception(__CLASS__, $exception);
    }
    
    return TRUE;
  }

}