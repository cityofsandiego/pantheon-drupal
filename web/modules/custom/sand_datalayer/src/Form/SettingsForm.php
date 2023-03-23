<?php

namespace Drupal\sand_datalayer\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use PHPUnit\Util\Exception;

/**
 * Configure Sand datalayer settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'sand_datalayer_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['sand_datalayer.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $default_department = $this->config('sand_datalayer.settings')->get('default_department');
    try {
      $term = \Drupal::entityTypeManager()
        ->getStorage('taxonomy_term')
        ->load($default_department);
    } catch (Exception $exception) {
      \Drupal::logger('sand_datalayer')->warning( 'Exception when trying to get the default department tid = @tid, exception: @exception', 
          [ '@tid' => $default_department, 
            '@exception' => $exception,
          ]
        );
      $name = '';
    }
    
    if (is_a($term, 'Drupal\taxonomy\Entity\Term')) {
      $name = 'Saved Department is: ' . $term->getName();
    }
    
    $form['info'] = [
      '#markup' => '<p>We are using the contributed module datalayer to provide information to our feedback form. In addition to the default information it provides we add the department on each page that has one full node in view mode that has one department taxonomy term. If the page does not meet this criteria then the default department term is assigned to the output. By default, we are setting it originally to the Web Team term.</p>',
    ];
    
    $form['default_department'] = [
      '#type' => 'number',
      '#required' => TRUE,
      '#title' => $this->t('Default Department Term'),
      '#description' => $this->t('This is the department term that will be used if there is NO department term on this page or there are multiple department terms on this page'),
      '#default_value' => $default_department,
    ];
    
    if (!empty($name)) {
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
    // Validate that the number entered in the form for default_department is a
    // valid taxonomy term.
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
    // Save field default_department to config.
    $this->config('sand_datalayer.settings')
      ->set('default_department', $form_state->getValue('default_department'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
