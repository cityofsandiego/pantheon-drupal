<?php

namespace Drupal\sand_feeds\Drush\Commands;

use Drupal\facets\Exception\Exception;
use Drupal\feeds\Entity\Feed;
use Drupal\feeds\FeedInterface;
use Drupal\sand_feeds\SandFeedImportHandler;
use Drush\Commands\DrushCommands;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * A Drush commandfile.
 */
class SandFeedsCommands extends DrushCommands {

  /**
   * The service container.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerInterface
   */
  protected ContainerInterface $container;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * Constructs a SandFeedsCommands object.
   */
  public function __construct(ContainerInterface $container, EntityTypeManagerInterface $entity_type_manager) {
    $this->container = $container;
    $this->entityTypeManager = $entity_type_manager;
    parent::__construct();
  }


  /**
   * {@inheritdoc}
   *
   **/
  public static function create(ContainerInterface $container): static {
    return new static(
      $container,
      $container->get('entity_type.manager')
    );
  }


  /**
   * Command description here.
   *
   * @param $id
   *   Feed ID
   * @param array $options
   *   An associative array of options whose values come from cli, aliases,
   *   config, etc.
   *
   * @option option-name
   *   Description
   * @usage sand_feeds:import sandimport
   *   Usage description
   *
   * @command sand_feeds:import
   * @aliases sandimport
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function import($id, array $options = ['option-name' => 'default']) {
    try {
      $feed = Feed::load($id);
      if ($feed instanceof FeedInterface) {
        $entity_type = $this->entityTypeManager->getDefinition('feeds_feed');
        $handler = SandFeedImportHandler::createInstance($this->container, $entity_type);
        $handler->startCronImport($feed);
        \Drupal::logger('sand_feeds')->notice("Feed Submitted #%id, %label", ['%id' => $feed->id(), '%label' => $feed->label()]);
        $this->logger()->success(dt('Feed Submitted.'));
      } else {
        \Drupal::logger('sand_feeds')->notice("Feed NOT Submitted for #%id", ['%id' => $id]);
        $this->logger()->success(dt('Feed NOT Submitted.'));
      }
    }
    catch (Exception $exception) {
      \Drupal::logger('sand_feeds')->error($exception->getMessage());
      \Drupal::logger('sand_feeds')->notice("Feed NOT Submitted for #%id", ['%id' => $id]);
      $this->logger()->success(dt('Feed NOT Submitted.'));
    }

  }


}
