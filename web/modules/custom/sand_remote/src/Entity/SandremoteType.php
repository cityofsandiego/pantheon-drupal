<?php

namespace Drupal\sand_remote\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Sandremote type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "sand_remote_type",
 *   label = @Translation("Sandremote type"),
 *   label_collection = @Translation("Sandremote types"),
 *   label_singular = @Translation("sand_remote type"),
 *   label_plural = @Translation("sand_remotes types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count sand_remotes type",
 *     plural = "@count sand_remotes types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\sand_remote\Form\SandremoteTypeForm",
 *       "edit" = "Drupal\sand_remote\Form\SandremoteTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\sand_remote\SandremoteTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   admin_permission = "administer sand_remote types",
 *   bundle_of = "sand_remote",
 *   config_prefix = "sand_remote_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/sand_remote_types/add",
 *     "edit-form" = "/admin/structure/sand_remote_types/manage/{sand_remote_type}",
 *     "delete-form" = "/admin/structure/sand_remote_types/manage/{sand_remote_type}/delete",
 *     "collection" = "/admin/structure/sand_remote_types"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   }
 * )
 */
class SandremoteType extends ConfigEntityBundleBase {

  /**
   * The machine name of this sand_remote type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the sand_remote type.
   *
   * @var string
   */
  protected $label;

}
