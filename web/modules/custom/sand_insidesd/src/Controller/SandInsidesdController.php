<?php

declare(strict_types=1);

namespace Drupal\sand_insidesd\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\Entity\Node;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Database\Connection;
use Drupal\media\Entity\Media;
use Drupal\file\Entity\File;
use function PHPUnit\Framework\throwException;

/**
 * Returns responses for Sand insidesd routes.
 */
final class SandInsidesdController extends ControllerBase {

  protected $entityTypeManager;
  protected $connection;
  protected $table ;
  private int $max_count = 9999;
  /**
   * The controller constructor.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, Connection $connection, string $table) {
    $this->entityTypeManager = $entityTypeManager;
    $this->connection = $connection;
    $this->table = $table;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new self(
      $container->get('entity_type.manager'),
      $container->get('database'),
      'sand_insidesd_cleanup',
    );
  }

  private function truncate() {
   $this->connection->truncate($this->table)->execute();
  }

  private function populate_mid_from_field_image() {
    $storage = $this->entityTypeManager->getStorage('node');
    $nids = $storage->getQuery()
      ->accessCheck(FALSE)
      ->condition('type', 'article')
      ->condition('field_image', NULL, 'IS NOT NULL')
      ->execute();

    $count = 0;
    foreach ($nids as $nid) {
      if ($count > $this->max_count) {
        break;
      }

      $node = Node::load($nid);
      $mid = $node->get('field_image')->getString();
      $media = Media::load($mid);
      $bundle = $media->bundle();
      // Don't need to process remote videos.
      if ($bundle === 'remote_video') {
        continue;
      }
      if ($media->hasField('field_media_image')) {
        $fid = $media->field_media_image->target_id;
      } else {
        $fid = null;
      }

      $result = $this->connection->insert('sand_insidesd_cleanup')
        ->fields([
          'id' => $node->id(),
          'mid' => $mid,
          'fid' => $fid,
          'bundle' => $bundle,
          'description' => 'Media Images found in the field: field_image',
          //          'created' => \Drupal::time()->getRequestTime(),
        ])
        ->execute();
      $count++;
    }
  }

  private function get_output($type = 'array') {
    $output = match ($type) {
      'array' => [],
      'string' => '',
      default => throw new \RuntimeException("Bad Parameter to get_output method."),
    };

    $query = $this->connection->query("SELECT id, mid FROM " . $this->table);
    $result = $query->fetchAll();
    $output = '';
    foreach ($result as $row) {
      switch ($type) {
        case 'array':
          $output[] = [$row->id, $row->mid];
          break;
        case 'string':
          $output .= $row->id . '-' . $row->mid . ', ';
          break;
      }
    }
    return $output;
  }

  /**
   * Builds the response.
   */
  public function __invoke(): array {

    $this->truncate();
    $this->populate_mid_from_field_image();

    $output = $this->get_output('string');

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $output,
    ];

    return $build;
  }

}
