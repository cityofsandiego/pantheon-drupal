<?php

namespace Drupal\sand_search\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a sand_search form.
 */
class SandSearchSettings extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sand_search_sand_search_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['info'] = [
      '#markup' => '<h2>List of search indices</h2>',
    ];
    
    $form['link_content'] = [ '#markup' => '<a href="/admin/config/search/search-api/searchindex/content">Content</a>', ];
    $form['link_remote'] = [ '#markup' => '<a href="/admin/config/search/search-api/searchindex/remote">Remote</a>', ];
    
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (mb_strlen($form_state->getValue('message')) < 10) {
      $form_state->setErrorByName('message', $this->t('Message should be at least 10 characters.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $form_state->setRedirect('<front>');
  }

}
