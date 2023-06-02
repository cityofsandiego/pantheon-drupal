<?php

namespace Drupal\sand_aws;

use Recurr\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Aws\Textract\TextractClient;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;

/**
 * Service description.
 */
class ExtractText {

  /**
   * The container.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerInterface
   */
  protected $container;

  /**
   * Constructs an ExtractText object.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container.
   */
  public function __construct(ContainerInterface $container) {
    $this->container = $container;
  }

  /**
   * Method description.
   */
  public function getClient() {
    $settings = \Drupal::config('sand_aws.settings');
    $client = new TextractClient([
      'version' => $settings->get('version'),
      'region' => $settings->get('region'), 
      'credentials' => [
        'key'    => $settings->get('key'),
        'secret' => $settings->get('secret'),
      ]
    ]);
    return $client;
  }
  
  public function startDocumentTextDetection($file) {
    $settings = \Drupal::config('sand_aws.settings');
    $bucket = $settings->get('bucket');
    $client = $this->getClient();

    $startOptions = [
      'DocumentLocation' => [
        'S3Object' => [
          'Bucket' => $bucket,
          'Name' => $file->getFilename(),
        ],
      ],
      'FeatureTypes' => ['TABLES', 'FORMS']
    ];

    $object = $client->StartDocumentTextDetection($startOptions);
    $jobId = $object->get('JobId');
    return $jobId;
  }

  public function getFile($url) {
    return system_retrieve_file($url, 'public://', TRUE);
  }
  
  public function copyToS3Bucket($url) {

    $settings = \Drupal::config('sand_aws.settings');

    $bucket = $settings->get('bucket');

    $s3 = new S3Client([
      'version' => $settings->get('version'),
      'region'  => $settings->get('region'),
    ]);

    /** @var  \Drupal\file\FileInterface $file */
    $file = $this->getFile($url);
    // Prepare the upload parameters.
    $uploader = new MultipartUploader($s3, '/path/to/large/file.zip', [
      'bucket' => $bucket,
      'key'    => $file->getFilename(),
    ]);

    try {
      $result = $uploader->upload();
    } catch (\Exception $e) {
      //echo $e->getMessage()
    }
  }
  
  public function addToQueue($url) {
    $queue = \Drupal::service('queue')->get('sand_aws_queue');
    $item = new \Drupal\sand_remote\ExtractText();
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
  }

  public function getText() {
    $client = $this->getClient();

    // Just hard-coded the jobId using the output from junk.php.
    $jobId = 'b73f2df019b0cf609cef6fefeafc546324ef7f7121e21900733b52c90d122ff2';

    $getOptions = ['JobId' => $jobId];
    $getObject = $client->GetDocumentTextDetection($getOptions);

    $blocks = $getObject->get('Blocks');
    $JobStatus = $getObject->get('JobStatus');

    if ($JobStatus !== 'SUCCEEDED') {
      return "Job failed with status " . $JobStatus;
    }

    // Loop through all the blocks:
    $output = '';
    foreach ($blocks as $key => $value) {
      if (isset($value['BlockType']) && $value['BlockType']) {
        // BlockType is WORD, LINE, or PAGE
        $blockType = $value['BlockType'];
        if (isset($value['Text']) && $value['Text']) {
          $text = $value['Text'];
          if ($blockType == 'LINE') {
            $output .= print_r($text, TRUE) . "\n";
          }
        }
      }
    }
    return $output;
  }
  
}
