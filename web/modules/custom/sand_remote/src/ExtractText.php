<?php

namespace Drupal\sand_remote;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Entity\EntityInterface;
use Drupal\file\Entity\File;
use Recurr\Exception;
use Drupal\Core\Entity\ContentEntityBase;

/**
 * Service description.
 */
class ExtractText {

  // This will be 'node' or 'sand_remote'.
  public $entity_type;
  // This will be the entity id.
  public $entity_id;
  // This is the source of the data (i.e. documentum).
  public $source;
  // This is the field that contains the URL to fetch.
  public $url_field;
  // This is the field to set the text to (i.e. field_body). 
  public $target_field;

  /**
   * Getter
   * 
   * @return string
   */
  public function getEntityType(): ?string {
    return $this->entity_type;
  }

  /**
   * Setter
   * 
   * @param $entity_type
   *
   * @return $this
   */
  public function setEntityType(string $entity_type): ExtractText {
    $this->entity_type = $entity_type;
    return $this;
  }

  /**
   * Getter
   * 
   * @return int $entity_id
   */
  public function getEntityId(): ?int {
    return $this->entity_id;
  }

  /**
   * Setter
   * 
   * @param int $entity_id
   *
   * @return $this
   */
  public function setEntityId(int $entity_id): ExtractText {
    $this->entity_id = $entity_id;
    return $this;
  }

  /**
   * Getter
   *
   * @return string $source_name
   */
  public function getSource(): ?string {
    return $this->source;
  }

  /**
   * Setter
   *
   * @param string $source_name
   * 
   * @return $this
   */
  public function setSource(string $source): ExtractText {
    $this->source = $source; 
    return $this;
  }


  /**
   * Getter
   * 
   * @return string $url_field
   */
  public function getUrlField(): ?string {
    return $this->url_field;
  }

  /**
   * Setter
   * 
   * @param EntityInterface $entity
   *
   * @return $this
   */
  public function setUrlField(ContentEntityBase $entity, string $source): bool {
    /**
     * get name of field that holds source name from the config
     * lookup the url field based on the source name from the config
     */
    $url = '';
    $mappings = \Drupal::config('sand_remote.settings')->get('mappings');
    foreach ($mappings as $mapping) {
      if ($mapping['source'] === $source) {
        $url_field = $mapping['url_field'];
        if ($entity->hasField($url_field)) {
          $url = $entity->$url_field->value;
          if (!empty($mapping['from'])) {
            $url = str_replace($mapping['from'], $mapping['to'], $url);
          }
        }
      }
    }
    
    if (empty($url)) {
      \Drupal::logger('sand_remote')
        ->notice(
          'Could not get a source field for entity: %entity id: %id',
          [ '%entity' => $entity->getEntityType(), '%id' => $entity->id()]
        );
      return FALSE;
    }
    
    $this->url_field = $url;
    return TRUE;
  }

  /**
   * Getter
   * 
   * @return string $target_field
   */
  public function getTargetField(): string {
    return $this->target_field;
  }

  /**
   * Setter
   * 
   * @param string $target_field
   *
   * @return $this
   */
  public function setTargetField(string $target_field): ExtractText {
    $this->target_field = $target_field;
    return $this;
  }

  /**
   * Get text extracted from the PDF of the url field of this class.
   * 
   * @return string
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function extractText(): string {

    $url = $this->getUrlField();

    // If the URL field is empty then return nothing.
    if (empty($url)) {
      return '';
    }

    // Get extractor plugin.
    $extractor_plugin_id = \Drupal::config("search_api_attachments.admin_config")
      ->get("extraction_method");
    $config_of_search_api_attachments = \Drupal::configFactory()
      ->get('search_api_attachments.admin_config');
    $configuration = $config_of_search_api_attachments->get($extractor_plugin_id . '_configuration');
    /** @var \Drupal\search_api_attachments\Plugin\search_api_attachments\TikaExtractor $extractor_plugin */
    $extractor_plugin = \Drupal::service('plugin.manager.search_api_attachments.text_extractor')
      ->createInstance($extractor_plugin_id, $configuration);

    // Create a file object since the extractor needs it. It's a temp file.
    $file = File::create([
      'filename' => $url,
      'uri' => $url,
      'status' => 1,
      'uid' => 1,
    ]);

    try {
      $extracted_data = $extractor_plugin->extract($file);
      $cleaned_data = $this->cleanExtractedData($extracted_data);
      // @todo interface with Boone's tesserac server if the cleaned data is empty
      \Drupal::logger('sand_remote')
        ->error('Got %size text when extracting text on %entity_type ID: %id, on URL: %url, error: %error', [
          '%size' => strlen($cleaned_data) / 1024 . 'KB',
          '%entity_type' => $this->getEntityType(),
          '%id' => $this->getEntityId(),
          '%url' => $url,
          '%error' => $e->getMessage(),
        ]);
      return $cleaned_data;
    } catch (\Exception $e) {
      if ($e->getMessage() === 'Tika Extractor is not available.') {
        \Drupal::logger('sand_remote')
          ->error('Got NO text when trying to extract text on %entity_type ID: %id, on URL: %url, error: %error', [
            '%entity_type' => $this->getEntityType(),
            '%id' => $this->getEntityId(),
            '%url' => $url,
            '%error' => $e->getMessage(),
          ]);
      } else {
        \Drupal::logger('sand_remote')
          ->error('Some Error trying to extract text on %entity_type ID: %id, on URL: %url, error: %error', [
            '%entity_type' => $this->getEntityType(),
            '%id' => $this->getEntityId(),
            '%url' => $url,
            '%error' => $e->getMessage(),
          ]);
      }
      return '';

    }

  }

  /**
   * Clean up text, Stolen from D7 apachesolr function.
   * 
   * @param string $text
   *
   * @return string
   */
  protected function apachesolr_clean_text(string $text): string {
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
    // Remove white spaces around punctuation marks. This is not a perfect solution,
    // but a rough attempt for at least US and Western Europe.
    // Pc: Connector punctuation, Pd: Dash punctuation, Pe: Close punctuation, Pf: Final punctuation,
    // Pi: Initial punctuation, Po: Other punctuation, including ¿?¡!,.:;, Ps: Open punctuation
    $text = preg_replace('/\s(\p{Pc}|\p{Pd}|\p{Pe}|\p{Pf}|!|\?|,|\.|:|;)/s', '$1', $text);
    $text = preg_replace('/(\p{Ps}|¿|¡)\s/s', '$1', $text);
    return $text;
  }

  /**
   * Clean up text and convert to 3 character UTF8
   * 
   * @param string $string
   *
   * @return string
   */
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

  /**
   * Set the target field of this class the text extracted from the PDF source.
   * 
   * @return bool
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function setText(): bool {
    // Has this the target text changed, so we know if we should save or not.
    $changed = FALSE;
    
    // Load the Entity. Currently, node or sand_remote entity type.
    $entity = \Drupal::entityTypeManager()
      ->getStorage($this->getEntityType())
      ->load($this->getEntityId());

    // Set variable to say we are setting the Text so don't fire our hooks for insert and update.
    /** @var \Drupal\Core\TempStore\PrivateTempStore $tempstore */
    $tempstore = \Drupal::service('tempstore.private');
    $store = $tempstore->get('extracting_text');
    $store->set('entity_type_id', $this->getEntityType() . ':' . $this->getEntityId());

    $url = $this->getUrlField();
    
    // Target field name and value.
    $target_field = $this->getTargetField();
    $target_value = $entity->$target_field->value;

    // If source and target are empty then just return.
    if (empty($url) && empty($target_value)) {
      $store->delete('entity_type_id');
      return FALSE;
    }
    
    // If the source url is empty then clear out the target field.
    if (empty($url) && !empty($target_field)) {
      $entity->$target_field->value = '';
      $changed = TRUE;
    }

    // Extract the text from the URL.
    $extracted_text = $this->extractText();
    
    // If both are NULL/empty string then nothing to do.
    if (empty($target_value) && empty($extracted_text)) {
      $changed = FALSE;
    }
    // If the extracted text is different from the current value, update it.
    elseif ($target_value !== $extracted_text) {
      $entity->$target_field->value = $extracted_text;
      $changed = TRUE;
    }
    
    // If we changed something, save it.
    if ($changed) {
      // @todo when saving to NOT update the entity's update time so it can be sorted with other nodes.
      // @todo maybe set a status field and extraction time.
      $entity->save();
    }
    
    // Delete out the variable that says we are processing it. This was set so
    // in the *_update or *_insert hooks don't loop endlessly.
    $store->delete('entity_type_id');
    
    // Return if we $changed to say if we updated the entity or not.
    return $changed;
    
  }
  private function getSourceFromEntity(ContentEntityBase $entity): ?string {
    $source_field = \Drupal::config('sand_remote.settings')->get('source_field');
    if ($entity->hasField($source_field)) {
      return $entity->$source_field->value;
    } else {
      \Drupal::logger('sand_remote')
        ->notice(
          'Could not get a source for entity: %entity id: %id',
          [ '%entity' => $entity->getEntityType(), '%id' => $entity->id()]
        );
      return NULL;
    }
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
      \Drupal::logger('sand_remote')
        ->notice(
          'Could not get a source field for entity: %entity id: %id',
          [ '%entity' => $entity->getEntityType(), '%id' => $entity->id()]
        );
    }
    return $url_field;
  }
  
  private function getUrlValue($entity) {
    // Source field.
    $source_field = $this->getSourceUrlField($entity);
    if ($entity->hasField($source_field)) {
      $source_field_type = $entity->$source_field->getFieldDefinition()->getType();
      if ($source_field_type === 'link') {
        $url = $entity->$source_field->uri;
      } else {
        $url = $entity->$source_field->value;
      }
      $mappings = \Drupal::config('sand_remote.settings')->get('mappings');
      foreach($mappings as $mapping) {
        if ($mapping['source_name'] === $this->getSourceUrlField($entity)) {
          $url = str_replace($mapping['from'], $mapping['to'], $url);
        }
      }
      return $url;
    }
    else {
      return '';
    }
  }

  private function getTargetFromEntity(EntityInterface $entity): string {
    if ($entity->getEntityTypeId() === 'node') {
      return 'body';      
    } else {
      return 'field_body';    
    }
  }

  function queueEntityForTextExtract($entity_type, $entity): bool {
    $source = $this->getSourceFromEntity($entity);

    // If there is nothing in the source field, there is nothing we can do.
    if (empty($source)) {
      return FALSE;
    }

    /** @var \Drupal\Core\TempStore\PrivateTempStore $tempstore */
    $tempstore = \Drupal::service('tempstore.private');
    $store = $tempstore->get('extracting_text');
    $is_processing = $store->get('entity_type_id');

    // See if we are in the process of setting a field equal to it's extracted text, then skip the update to avoid a loop.
    if ($is_processing) {
      return FALSE;
    }

    $queue = \Drupal::service('queue')->get('sand_remote_queue');
    $item = new ExtractText();
    $item->setEntityType($entity_type);
    $item->setEntityId($entity->id());
    $item->setSource($source);
    $item->setUrlField($entity, $source);
    $item->setTargetField($this->getTargetFromEntity($entity));

    try {
      $queue->createItem($item);
    } catch (Exception $exception) {
      watchdog_exception(__CLASS__, $exception);
    }
    
    return TRUE;
  }

}

