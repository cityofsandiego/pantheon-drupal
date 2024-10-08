<?php

declare(strict_types = 1);

namespace Drupal\linkit_media_library\Plugin\CKEditor5Plugin;

use Drupal\ckeditor5\Plugin\CKEditor5PluginDefault;
use Drupal\ckeditor5\Plugin\CKEditor5PluginDefinition;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Url;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\editor\EditorInterface;
use Drupal\media_library\MediaLibraryState;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * CKEditor 5 Media Library plugin.
 *
 * Provides media library support and options for the CKEditor 5 build.
 *
 * @internal
 *   Plugin classes are internal.
 */
class LinkitMediaLibrary extends CKEditor5PluginDefault implements ContainerFactoryPluginInterface {

  use StringTranslationTrait;

  /**
   * The media type entity storage.
   *
   * @var \Drupal\Core\Config\Entity\ConfigEntityStorageInterface
   */
  protected $mediaTypeStorage;

  /**
   * MediaLibrary constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param \Drupal\ckeditor5\Plugin\CKEditor5PluginDefinition $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(array $configuration, string $plugin_id, CKEditor5PluginDefinition $plugin_definition, EntityTypeManagerInterface $entity_type_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->mediaTypeStorage = $entity_type_manager->getStorage('media_type');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDynamicPluginConfig(array $static_plugin_config, EditorInterface $editor): array {

    if (!$editor->hasAssociatedFilterFormat()) {
      return $static_plugin_config;
    }

    /** @var \Drupal\filter\FilterFormatInterface $filter_format */
    $filter_format = $editor->getFilterFormat();

    /** @var \Drupal\filter\FilterPluginCollection $filters */
    $filters = $filter_format->filters();
    if (!$filters->has('linkit') || !$filters->get('linkit')->status === TRUE) {
      return $static_plugin_config;
    }

    // Get the profile ID from the editor settings.
    $profile_id = $editor->getSettings()['plugins']['linkit_extension']['linkit_profile'];

    /** @var \Drupal\Linkit\ProfileInterface $linkit_profile */
    $profile = \Drupal::entityTypeManager()
      ->getStorage('linkit_profile')
      ->load($profile_id);

    $has_media = FALSE;
    $bundles = [];
    foreach ($profile->getMatchers() as $matcher) {
      if ($matcher->getPluginId() != 'entity:media') {
        continue;
      }
      $has_media = TRUE;
      $configuration = $matcher->getConfiguration();
      $bundles += $configuration['settings']['bundles'];
    }

    if (!$has_media) {
      return $static_plugin_config;
    }

    // If the types are not limited, we must load all media types.
    if (empty($bundles)) {
      $bundles = $this->mediaTypeStorage->getQuery()->execute();
    }

    /** @var \Drupal\media_library\MediaLibraryState $state */
    $state = MediaLibraryState::create(
      'linkit_media_library.opener.editor',
      $bundles,
      reset($bundles),
      1,
      ['filter_format_id' => $editor->getFilterFormat()->id()]
    );

    $library_url = Url::fromRoute('media_library.ui')
      ->setOption('query', $state->all())
      ->toString(TRUE)
      ->getGeneratedUrl();

    $dynamic_plugin_config = $static_plugin_config;
    $dynamic_plugin_config['linkitMediaLibrary']['libraryURL'] = $library_url;
    return $dynamic_plugin_config;
  }

}
