<?php

declare(strict_types=1);

namespace Drupal\sand_delete_unused_taxonomy_terms\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\taxonomy\Entity\Vocabulary;

/**
 * Set the vocabulary you want to look for unused items in.
 */
class SandDeleteUnusedTaxonomyTermsAdminSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'sand_delete_unused_taxonomy_terms_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('sand_delete_unused_taxonomy_terms.settings');

    foreach (Element::children($form) as $variable) {
      $config->set($variable, $form_state->getValue($form[$variable]['#parents']));
    }
    $config->save();

    if (method_exists($this, '_submitForm')) {
      $this->_submitForm($form, $form_state);
    }

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames():array {
    return ['sand_delete_unused_taxonomy_terms.settings'];
  }

  /**
   * Get a list of vocabularies for the select statement in the form.
   */
  public function getVocabularies():array {
    $return = [];
    $vocabularies = Vocabulary::loadMultiple();
    foreach ($vocabularies as $id => $vocabulary) {
      $return[$id] = $vocabulary->label();
    }
    return $return;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state):array {
    $vocabularies = $this->getVocabularies();
    $form = [];
    $form['info'] = [
      '#markup' => t('This will delete all unused terms in the selected Vocabulary'),
    ];
    $form['favorite'] = [
      '#type' => 'select',
      '#title' => $this->t('Favorite color'),
      '#options' => $vocabularies,
      '#empty_option' => $this->t('-select vocabulary-'),
      '#description' => $this->t('Select vocabulary to delete unused terms from'),
    ];
    $form['#submit'][] = 'custom_form_submit';
    return parent::buildForm($form, $form_state);
  }

}
