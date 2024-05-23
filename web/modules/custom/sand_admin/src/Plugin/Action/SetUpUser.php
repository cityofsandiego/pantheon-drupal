<?php

namespace Drupal\sand_admin\Plugin\Action;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Action\ActionBase;

/**
 * Provides a a Set up user action.
 *
 * @Action(
 *   id = "sand_admin_set_up_user",
 *   label = @Translation("Set up user"),
 *   type = "user",
 *   category = @Translation("Custom")
 * )
 *
 * @DCG
 * For a simple updating entity fields consider extending FieldUpdateActionBase.
 */
class SetUpUser extends ActionBase {

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    return $return_as_object ? AccessResult::allowed() : TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function execute($user = NULL) {
    /** @var \Drupal\user\Entity\User $user */
    
    // Set up for SAML.
    $externalauth = \Drupal::service('externalauth.externalauth');
    $authname = $user->getAccountName();
    \Drupal::modulehandler()->alter('simplesamlphp_auth_account_authname', $authname, $user);
    $externalauth->linkExistingAccount($authname, 'simplesamlphp_auth', $user);

    // Set password.
    $userPassword = \Drupal::service('password_generator');
    $length = 20;
    $password = $userPassword->generate($length);
    $user->setPassword($password);

    \Drupal::logger('sand_admin')->info('Userid, password: ' . $user->id() . ':' . $password);

    return $user;
  }

}
