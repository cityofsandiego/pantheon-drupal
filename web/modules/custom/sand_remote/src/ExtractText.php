<?php

namespace Drupal\sand_remote;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\file\Entity\File;
use Recurr\Exception;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\File\Exception\FileException;
use Drupal\Core\File\Exception\InvalidStreamWrapperException;
use GuzzleHttp\Exception\TransferException;
use Drupal\Core\Logger\RfcLogLevel;

use Drupal\sand_type\Entity\Bundle\ExternalData;

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

  private $file;
  
  private $file_size;
  
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
   * Getter
   *
   * @return $entity
   */
  public function getEntity() {
    $entity = \Drupal::entityTypeManager()
      ->getStorage($this->getEntityType())
      ->load($this->getEntityId());
    return $entity;
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
        ->warning(
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

    try {
      $cleaned_data = $this->cleanExtractedData($extractor_plugin->extract($this->getFile()));
      // Set logging level based on amount of cleaned data returned.
      if (strlen($cleaned_data) === 0) {
        $level = $severity = RfcLogLevel::WARNING;
      }
      else {
        $level = RfcLogLevel::INFO;
      }
      // @todo interface with Boone's tesserac server if the cleaned data is empty
      \Drupal::logger('sand_remote')
        ->log($level,
          'Got %size text extracting from %entity_type ID: %id, on URL: %url, File Size: %filesize', [
          '%size' => round(strlen($cleaned_data) / 1024, 2) . 'KB',
          '%entity_type' => $this->getEntityType(),
          '%id' => $this->getEntityId(),
          '%url' => $url,
          '%filesize' => $this->getFileSize() ? round($this->getFileSize() / 1024, 2) . 'KB' : 'Unknown',  
        ]);
      return $cleaned_data;
    } catch (\Exception $e) {
      if ($e->getMessage() === 'Tika Extractor is not available.') {
        \Drupal::logger('sand_remote')
          ->error('Tika Extractor is not available or another error such as invalid cert when trying to extract text on %entity_type ID: %id, on URL: %url, error: %error', [
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
   * Based on system_retrieve_file but with verify arg.
   * 
   * @param $destination
   * @param $managed
   * @param $replace
   *
   * @return \Drupal\file\FileInterface|false|string
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  function getRemoteFile($destination = NULL, $managed = FALSE, $replace = FileSystemInterface::EXISTS_RENAME) {
    $url = $this->getUrlField();
    $parsed_url = parse_url($url);
    /** @var \Drupal\Core\File\FileSystemInterface $file_system */
    $file_system = \Drupal::service('file_system');
    if (!isset($destination)) {
      $path = $file_system->basename($parsed_url['path']);
      $path = \Drupal::config('system.file')->get('default_scheme') . '://' . $path;
      $path = \Drupal::service('stream_wrapper_manager')->normalizeUri($path);
    }
    else {
      if (is_dir($file_system->realpath($destination))) {
        // Prevent URIs with triple slashes when glueing parts together.
        $path = str_replace('///', '//', "$destination/") . \Drupal::service('file_system')->basename($parsed_url['path']);
      }
      else {
        $path = $destination;
      }
    }
    try {
      $data = (string) \Drupal::httpClient()
        ->get($url, [ 'verify' => FALSE, ])
        ->getBody();
      if ($managed) {
        /** @var \Drupal\file\FileRepositoryInterface $file_repository */
        $file_repository = \Drupal::service('file.repository');
        $local = $file_repository->writeData($data, $path, $replace);
      }
      else {
        $local = $file_system->saveData($data, $path, $replace);
      }
    }
    catch (TransferException $exception) {
      \Drupal::messenger()->addError(t('Failed to fetch file due to error "%error"', ['%error' => $exception->getMessage()]));
      return FALSE;
    }
    catch (FileException | InvalidStreamWrapperException $e) {
      \Drupal::messenger()->addError(t('Failed to save file due to error "%error"', ['%error' => $e->getMessage()]));
      return FALSE;
    }
    if (!$local) {
      \Drupal::messenger()->addError(t('@remote could not be saved to @path.', ['@remote' => $url, '@path' => $path]));
    }

    return $local;
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
  public function cleanExtractedData($string): string {
    
    // No work to do.
    if (is_null($string)) {
      return '';
    }
    
    // Strip out ant invalid UTF8.
    try {
      $text = iconv("UTF-8", "UTF-8//IGNORE", $string);
    } catch (Exception $exception) {
      \Drupal::logger('sand_remote')
        ->error('Error trying to extract text on Sandremote ID: %id, on URL: %url, error: %error', ['%id' => $this->id(), '%url' => $this->field_url->value, '%error' => $exception->getMessage()]);
      $text = $string;
    }

    // Use clean up routine originally found in D7 apachesolr.
    $text = trim($this->apachesolr_clean_text($text));
    
    // Many of our documents have table of contents with . . . , pull those out.
    $text = preg_replace('/\. \. \./', ' ', $text);
    $text = preg_replace('/\.\.\./', ' ', $text);
    
    // Cleanup __'s.
    $text = preg_replace('/__/', ' ', $text);
    // Should it be 3 or 4 char UTF8?
    if (\Drupal::config('sand_remote.settings')->get('utf8threechar')) {
      $text = $this->convertToThreeCharUTF8($text);
    }
    return $text;
  }

  protected function convertToThreeCharUTF8(string $string): string {
    //$text = Unicode::convertToUtf8($string);
    // Convert to 3 character UTF8 @todo we can remove this if our DB supports 4 byte UTF8. 
    return preg_replace('/[\x{10000}-\x{10FFFF}]/u', "\xEF\xBF\xBD", $string);
  }

  /**
   * Create file for remote text extract.
   * 
   * @param $url
   *
   * @return \Drupal\Core\Entity\ContentEntityBase|\Drupal\Core\Entity\EntityBase|\Drupal\Core\Entity\EntityInterface|\Drupal\file\Entity\File|(\Drupal\file\Entity\File&\Drupal\Core\Entity\EntityInterface)
   */
  private function createURLFile($url) {
    $file = File::create([
      'filename' => $url,
      'uri' => $url,
      'status' => 1,
      'uid' => 1,
    ]);
    return $file;
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
    
    // Check and make sure entity loaded.
    if (!$entity instanceof ContentEntityInterface) {
      return FALSE;
    }
    
    // No longer process nodes of type External-Data.
    if ($entity instanceof ExternalData) {
        return FALSE;
    }
    
    $url = $this->getUrlField();
    
    // Target field name and value.
    $target_field = $this->getTargetField();
    $target_value = $entity->$target_field->value;

    // If source and target are empty then just return.
    if (empty($url) && empty($target_value)) {
      return FALSE;
    }
    
    // If the source url is empty then clear out the target field.
    if (empty($url) && !empty($target_field)) {
      $entity->$target_field->value = '';
      if ($entity->hasField('field_body_status') && $entity->hasField('field_internal_notes')) {
        $entity->field_body_status->value = 'cleared:' . date('YmdHis');
        $entity->field_internal_notes->value = 'The source url was empty and the target field was not.';
      }
      $changed = TRUE;
    }

    // See if the configuration wants us to bring the file locally first.
    if (\Drupal::config('sand_remote.settings')->get('fetch')) {
      $file = $this->getRemoteFile('temporary://', TRUE, FileSystemInterface::EXISTS_RENAME);
      if ($file instanceof File) {
        // For some reason it set the file to permanent minute even know the destination is temporary, resetting it here.
        $file->setTemporary();
        $file->save();
        $this->setFile($file);
        $this->setFileSize($file->getSize());
        $extracted_text = $this->extractText();
      }
    }
    else {
      // Create a file object since the extractor needs it. It's a temp file.
      $file = $this->createURLFile($url);
      $this->setFile($file);
      $extracted_text = $this->extractText();
    }

    if (empty($extracted_text)) {
      if ($entity->hasField('field_body_status') && $entity->hasField('field_internal_notes')) {
        $body_status = \Drupal::config('sand_remote.settings')->get('no_text_body_status');
        $entity->field_body_status->value = $body_status . ':' . date('YmdHis');
        $entity->field_internal_notes->value = 'The extracted text was empty, queue it for the webdata server to try by marking it with specific text in the field_body_status (seeing settings for Remote Data).';
      }
      $changed = TRUE;
    }
    
    // If the extracted text is different from the current value, update it.
    elseif ($target_value !== $extracted_text) {
      $entity->$target_field->value = $extracted_text;
      if ($entity->hasField('field_body_status') && $entity->hasField('field_internal_notes')) {
        $entity->field_body_status->value = 'updated:' . date('YmdHis');
        $entity->field_internal_notes->value = 'The extracted text was different than the current target field';
      }
      $changed = TRUE;
    }
    
    // If we changed something, save it.
    if ($changed) {
      $entity->set('field_import_date', date('Y-m-d\TH:i:s', time()));
      $entity->set('field_skip_text_extract_queuing', TRUE);
      $entity->save();
    }
    
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

  /**
   * @return mixed
   */
  public function getFile() {
    return $this->file;
  }

  /**
   * @param mixed $file
   */
  public function setFile($file): void {
    $this->file = $file;
  }

  public function getTargetFromEntity(EntityInterface $entity): string {
    if ($entity->getEntityTypeId() === 'node') {
      return 'body';      
    } else {
      return 'field_body';    
    }
  }

  function queueEntityForTextExtract($entity_type, $entity): bool {
    
    $queue = \Drupal::config('sand_remote.settings')->get('queue');
    if (!empty($queue)) {
      return false;
    }
    
    $source = $this->getSourceFromEntity($entity);

    // If there is nothing in the source field, there is nothing we can do.
    if (empty($source)) {
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

    /**
     * @return mixed
     */
    public function getFileSize() {
        return $this->file_size;
    }

    /**
     * @param mixed $file_size
     */
    public function setFileSize($file_size): void {
        $this->file_size = $file_size;
    }

}
