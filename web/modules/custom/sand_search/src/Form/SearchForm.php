<?php

namespace Drupal\sand_search\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a sand_search form.
 */
class SearchForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sand_search_search';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $arg1 = null, $arg2 = null, $arg3 = null) {

    $form['search_api_fulltext'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search'),
      '#required' => TRUE,
    ];
    $form['redirect_path'] = [
      '#type' => 'hidden',
      '#default_value' => $arg1,  
    ];
    $form['facet0'] = [
      '#type' => 'hidden',
      '#default_value' => $arg2,
    ];
    $form['facet1'] = [
      '#type' => 'hidden',
      '#default_value' => $arg3,
    ];
    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Search'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state, $arg1 = null) {
    if (mb_strlen($form_state->getValue('search_api_fulltext')) < 3) {
      $form_state->setErrorByName('search_api_fulltext', $this->t('Search should be at least 3 characters.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $options = [
      'query' => [
        'search_api_fulltext' => $form_state->getValue('search_api_fulltext'),
      ],
    ];
    // Add facet 0 in if given.
    if (!empty($facet0 = $form_state->getValue('facet0'))) {
      $options['query']['f[0]'] = $facet0;
    }
    // Add facet 1 in if given.
    if (!empty($facet1 = $form_state->getValue('facet1'))) {
      $options['query']['f[1]'] = $facet1;
    }
    $url = Url::fromUserInput($form_state->getValue('redirect_path'), $options);
    $form_state->setRedirectUrl($url);
    //$this->messenger()->addStatus($this->t('The message has been sent.'));
    //$form_state->setRedirect('<front>');
  }

}
