<?php

namespace Drupal\if_dept_permission\EventSubscriber;

use Drupal\if_dept_permission\UserInformation;
use Drupal\views_event_dispatcher\Event\Views\ViewsQueryAlterEvent;
use Drupal\views_event_dispatcher\ViewsHookEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class EntityTypeSubscriber.
 *
 * @package Drupal\if_dept_permission\EventSubscriber
 */
class AdminContentView implements EventSubscriberInterface {

  /**
   * User information.
   *
   * @var \Drupal\if_dept_permission\UserInformation
   */
  private $userInformation;

    /**
     * Constructs a UserProfileForm alter.
     *
     * @param \Drupal\if_dept_permission\UserInformation $user_information
     *   Current user information.
     */
  public function __construct(UserInformation $user_information) {
    $this->userInformation = $user_information;
  }

  /**
   * {@inheritdoc}
   *
   * @return array
   *   The event names to listen for, and the methods that should be executed.
   */
  public static function getSubscribedEvents() {
    return [
      ViewsHookEvents::VIEWS_QUERY_ALTER => 'alterAdminContentView',
    ];
  }

  /**
   * Views query alter to hide content the user does not have permission to
   * edit.
   *
   * @param \Drupal\views_event_dispatcher\Event\Views\ViewsQueryAlterEvent $event
   *   ViewsPreRender event.
   */
  public function alterAdminContentView(ViewsQueryAlterEvent $event) {
    $view = $event->getView();
    $viewDisplay = $view->getDisplay();
    $displayName = $view->current_display;
    if ($view->id() ==  'content' && in_array('content_owner', $this->userInformation->userRoles())) {
      $event->getQuery()->where[1]['conditions'][] = [
        'field' => 'node__field_department.field_department_target_id',
        'value' => $this->userInformation->userDepartments(),
        'operator' => 'in',
      ];
    }
    if ($view->id() ==  'files' && in_array('content_owner', $this->userInformation->userRoles())) {
      $event->getQuery()->where[1]['conditions'][] = [
        'field' => 'field_media_' . $displayName . '_file_managed__media__field_department.field_department_target_id',
        'value' => $this->userInformation->userDepartments(),
        'operator' => 'in',
      ];
    }
  }

}
