<?php

namespace Drupal\sand_datalayer\Form;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Sand datalayer settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sand_datalayer_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['sand_datalayer.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $default_department = $this->config('sand_datalayer.settings')->get('default_department') ?? '';
    if (!empty($default_department)) {
      /** @var \Drupal\taxonomy\Entity\Term $term_webteam */
      $term_webteam = \Drupal::entityTypeManager()
        ->getStorage('taxonomy_term')
        ->load($default_department);
    }
    if (!empty($term_webteam)) {
      $name = 'Saved Department is: ' . $term_webteam->getName();
    } else {
      /** @var \Drupal\taxonomy\Entity\Term $term_webteam */
      $term_webteam = \Drupal::entityTypeManager()
        ->getStorage('taxonomy_term')
        ->load(WEBTEAM_TAXONOMY_ID);
      $name = $term_webteam->getName();
    }
    
    $form['default_department'] = [
      '#type' => 'number',
      '#title' => $this->t('Default Department Term'),
      '#description' => $this->t('This is the department term that will be used if there is NO department term on this page or there are multiple department terms on this page'),
      '#default_value' => $default_department,
    ];
    $form['info'] = [
      '#prefix' => '<p>',
      '#markup' => $this->t('If this is empty it will use the default of Taxonomy Term ID: %tid, %name', ['%tid' => WEBTEAM_TAXONOMY_ID, '%name' => $name]),
      '#postfix' => '</p>',
    ];
    if (!empty($default_department)) {
      $form['default_department_name'] = [
        '#prefix' => '<p>',
        '#markup' => $name,
        '#postfix' => '</p>',
      ];
    }
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $default_department = $form_state->getValue('default_department');
    if (!empty($default_department)) {
      $term = \Drupal::entityTypeManager()
        ->getStorage('taxonomy_term')
        ->load($form_state->getValue('default_department'));
      if (empty($term)) {
        $form_state->setValue('default_department_name', '');
        $form_state->setErrorByName('default_department', $this->t('There is no department term with that id, please re-check.'));
      }
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('sand_datalayer.settings')
      ->set('default_department', $form_state->getValue('default_department'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
