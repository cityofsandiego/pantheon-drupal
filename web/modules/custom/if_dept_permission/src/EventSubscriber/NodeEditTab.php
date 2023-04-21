<?php

namespace Drupal\if_dept_permission\EventSubscriber;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\core_event_dispatcher\Event\Menu\MenuLocalTasksAlterEvent;
use Drupal\if_dept_permission\UserInformation;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class EntityTypeSubscriber.
 *
 * @package Drupal\if_dept_permission\EventSubscriber
 */
class NodeEditTab implements EventSubscriberInterface {

  /**
   * User information.
   *
   * @var \Drupal\if_dept_permission\UserInformation
   */
  private $userInformation;

  /**
   * Entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  private $entityTypeManager;

  /**
   * Constructs a UserProfileForm alter.
   *
   * @param \Drupal\if_dept_permission\UserInformation $user_information
   *   Current user information.
   */
  public function __construct(UserInformation $user_information, EntityTypeManagerInterface $entity_type_manager) {
    $this->userInformation = $user_information;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   *
   * @return array
   *   The event names to listen for, and the methods that should be executed.
   */
  public static function getSubscribedEvents() {
    return [
      'hook_event_dispatcher.menu_local_tasks.alter' => 'alterLocalTasks'
    ];
  }

  /**
   * If node being edited is not in a department the content owner has set, then
   * hide the edit tab for it.
   *
   * @param \Drupal\core_event_dispatcher\Event\Menu\MenuLocalTasksAlterEvent $event
   *   Form alter event.
   */
  public function alterLocalTasks(MenuLocalTasksAlterEvent $event) {
    $tabs = $event->getData()['tabs'];
    if ($tabs !== NULL && array_key_exists(0, $tabs) && array_key_exists('entity.node.canonical', $tabs[0])) {
      $node_url = $tabs[0]['entity.node.canonical']['#link']['url'];
      if ($node_url !== NULL) {
        $node_id = $node_url->getRouteParameters()['node'];
        $node = $this->entityTypeManager->getStorage('node')->load($node_id);
        if (in_array('content_owner', $this->userInformation->userRoles())) {
          $access = FALSE;
          if ($node->hasField('field_department')) {
            foreach ($node->get('field_department')->getValue() as $tid) {
              if (in_array($tid['target_id'], $this->userInformation->userDepartments())) {
                $access = TRUE;
              }
            }
          }
          if ($access == FALSE) {
            // This hides the edit and revision tabs for content owners when the
            // node does not have a department taxonomy set which the user has
            // access to.
            unset($event->getData()['tabs'][0]['entity.node.edit_form']);
            unset($event->getData()['tabs'][0]['entity.node.version_history']);
          }
        }
      }
    }
  }

}