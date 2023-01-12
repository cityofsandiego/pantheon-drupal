<?php

namespace Drupal\sand_remote\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the sand_remote entity edit forms.
 */
class SandremoteForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $entity = $this->getEntity();

    $message_arguments = ['%label' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%label' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New sand_remote %label has been created.', $message_arguments));
        $this->logger('sand_remote')->notice('Created new sand_remote %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The sand_remote %label has been updated.', $message_arguments));
        $this->logger('sand_remote')->notice('Updated sand_remote %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.sand_remote.canonical', ['sand_remote' => $entity->id()]);

    return $result;
  }

}
