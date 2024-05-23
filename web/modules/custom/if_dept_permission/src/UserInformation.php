<?php

namespace Drupal\if_dept_permission;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Get valid term ids for departments set on the current user.  Provides the
 * roles the current user is granted.
 */
class UserInformation {

  /**
   * Current user account.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  private $user;

  /**
   * Entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private $entityTypeManager;

  /**
   * Constructs a UserProfileForm alter.
   *
   * @param \Drupal\Core\Session\AccountInterface $user
   *   The current user.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Entity type manager.
   */
  public function __construct(AccountInterface $user, EntityTypeManagerInterface $entity_type_manager) {
    $this->user = $user;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Return roles of current user
   */
  public function userRoles() {
    return $this->user->getRoles();
  }

  /**
   * Return department tids set on current user and all child terms.
   */
  public function userDepartments() {
    $tids = [];
    $user = $this->entityTypeManager->getStorage('user')->load($this->user->id());
    foreach ($user->get('field_department')->getValue() as $tid) {
      $tids[] = $tid['target_id'];
      // include all children
      $child_terms = $this->entityTypeManager->getStorage('taxonomy_term')->loadTree('department', $tid['target_id'], NULL, FALSE);
      foreach ($child_terms as $child_term) {
        $tids[] = $child_term->tid;
      }
    }
    return $tids;
  }

}
