<?php

namespace Drupal\if_dept_permission\EventSubscriber;

use Drupal\core_event_dispatcher\Event\Form\FormAlterEvent;
use Drupal\if_dept_permission\UserInformation;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class EntityTypeSubscriber.
 *
 * @package Drupal\if_dept_permission\EventSubscriber
 */
class NodeEditPermissionCheck implements EventSubscriberInterface {

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
      'hook_event_dispatcher.form.alter' => 'alterForm',
    ];
  }

  /**
   * If node being edited is not in a department the content owner has set, then
   * throw access denied page.
   *
   * @param \Drupal\core_event_dispatcher\Event\Form\FormAlterEvent $event
   *   Form alter event.
   */
  public function alterForm(FormAlterEvent $event) {
    if (str_contains($event->getFormId(), '_edit_form') && in_array('content_owner', $this->userInformation->userRoles())) {
      $access = FALSE;
      $form = $event->getForm();
      if (array_key_exists('field_department', $form)) {
        foreach ($form['field_department']['widget']['#default_value'] as $tid) {
          if (in_array($tid['target_id'], $this->userInformation->userDepartments())) {
            $access = TRUE;
          }
        }
      }
      if ($access == FALSE) {
        throw new AccessDeniedHttpException();
      }
    }
  }

}