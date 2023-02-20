<?php

namespace Drupal\sand_remote\Plugin\Action;

use Drupal\sand_remote\Entity\Sandremote;
use Drupal\views_bulk_operations\Action\ViewsBulkOperationsActionBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

//use Drupal\Core\Entity\EntityInterface;
use Drupal\node\Entity\Node;
use Drupal\sand_remote\SandremoteInterface;

/**
 * This is a test Action.
 *
 * @Action(
 *   id = "sand_remote_mig_action",
 *   label = @Translation("San Diego Mig Action"),
 *   type = "",
 *   confirm = TRUE,
 *   requirements = {
 *     "_permission" = "administer actions",
 *     "_custom_access" = FALSE,
 *   },
 * )
 */
class migAction extends ViewsBulkOperationsActionBase {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function execute(Node $entity = NULL) {
    $sand_remote = Sandremote::create([
      'type' => 'sand_remote',
      'bundle' => 'external',
      'label' => $entity->id(),
    ]);
    $sand_remote->save();
  }
    

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    // If certain fields are updated, access should be checked against them as well.
    // @see Drupal\Core\Field\FieldUpdateActionBase::access().
    return $object->access('update', $account, $return_as_object);
  }

}
