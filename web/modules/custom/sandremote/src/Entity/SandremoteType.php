<?php

namespace Drupal\sandremote\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Sandremote type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "sandremote_type",
 *   label = @Translation("Sandremote type"),
 *   label_collection = @Translation("Sandremote types"),
 *   label_singular = @Translation("sandremote type"),
 *   label_plural = @Translation("sandremotes types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count sandremotes type",
 *     plural = "@count sandremotes types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\sandremote\Form\SandremoteTypeForm",
 *       "edit" = "Drupal\sandremote\Form\SandremoteTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\sandremote\SandremoteTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   admin_permission = "administer sandremote types",
 *   bundle_of = "sandremote",
 *   config_prefix = "sandremote_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/sandremote_types/add",
 *     "edit-form" = "/admin/structure/sandremote_types/manage/{sandremote_type}",
 *     "delete-form" = "/admin/structure/sandremote_types/manage/{sandremote_type}/delete",
 *     "collection" = "/admin/structure/sandremote_types"
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
   * The machine name of this sandremote type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the sandremote type.
   *
   * @var string
   */
  protected $label;

}
