<?php

namespace Drupal\sandremote\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the sandremote entity edit forms.
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
        $this->messenger()->addStatus($this->t('New sandremote %label has been created.', $message_arguments));
        $this->logger('sandremote')->notice('Created new sandremote %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The sandremote %label has been updated.', $message_arguments));
        $this->logger('sandremote')->notice('Updated sandremote %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.sandremote.canonical', ['sandremote' => $entity->id()]);

    return $result;
  }

}
