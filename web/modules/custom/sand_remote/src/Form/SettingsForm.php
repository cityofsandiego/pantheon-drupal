<?php

namespace Drupal\sand_remote\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure San Diego Remote Data Module settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sand_remote_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['sand_remote.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {



    //    $form['example'] = [
    //      '#type' => 'textfield',
    //      '#title' => $this->t('Example'),
    //      '#default_value' => $this->config('sand_remote.settings')->get('example'),
    //    ];
    
    
    $form['#tree'] = TRUE;

    $form['contacts'] = array(
      '#type' => 'table',
      '#caption' => $this->t('Sample Table'),
      '#header' => array(
        $this->t('MyName'),
        $this->t('MyPhone'),
      ),
    );
    for ($i = 1; $i <= 2; $i++) {
      $form['contacts'][$i]['name'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('MyName'),
        '#title_display' => 'invisible',
      );
      $form['contacts'][$i]['phone'] = array(
        '#type' => 'tel',
        '#title' => $this->t('MyPhone'),
        '#title_display' => 'invisible',
      );
    }


    // Gather the number of names in the form already.
    $num_names = $form_state->get('num_names');
    // We have to ensure that there is at least one name field.
    if ($num_names === NULL) {
      $name_field = $form_state->set('num_names', 1);
      $num_names = 1;
    }

    $form['names_fieldset'] = [
      '#type' => 'fieldset',
      '#caption' => $this->t('People coming to picnic'),
      '#prefix' => '<div id="names-fieldset-wrapper">',
      '#suffix' => '</div>',
    ];

    for ($i = 0; $i < $num_names; $i++) {
      $form['names_row'.$i] = [
        '#type' => 'fieldset',
        '#caption' => $this->t('Row'),
        '#prefix' => '<div id="names--row-fieldset-wrapper">',
        '#suffix' => '</div>',
      ];
      $form['names_fieldset']['names_row'.$i]['name'][$i] = [
        '#type' => 'textfield',
        '#title' => $this->t('Name'),
        '#size' => 20,
      ];
      $form['names_fieldset']['names_row'.$i]['name2'][$i] = [
        '#type' => 'textfield',
        '#title' => $this->t('Name2'),
        '#size' => 20,
        '#suffix' => '- ',
      ];
    }

    $form['names_fieldset']['actions'] = [
      '#type' => 'actions',
    ];
    
    $form['names_fieldset']['actions']['add_name'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add one more'),
      '#submit' => ['::addOne'],
      '#ajax' => [
        'callback' => '::addmoreCallback',
        'wrapper' => 'names-fieldset-wrapper',
      ],
    ];
    // If there is more than one name, add the remove button.
    if ($num_names > 1) {
      $form['names_fieldset']['actions']['remove_name'] = [
        '#type' => 'submit',
        '#value' => $this->t('Remove one'),
        '#submit' => ['::removeCallback'],
        '#ajax' => [
          'callback' => '::addmoreCallback',
          'wrapper' => 'names-fieldset-wrapper',
        ],
      ];
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * Callback for both ajax-enabled buttons.
   *
   * Selects and returns the fieldset with the names in it.
   */
  public function addmoreCallback(array &$form, FormStateInterface $form_state) {
    return $form['names_fieldset'];
  }


  /**
   * Submit handler for the "add-one-more" button.
   *
   * Increments the max counter and causes a rebuild.
   */
  public function addOne(array &$form, FormStateInterface $form_state) {
    $name_field = $form_state->get('num_names');
    $add_button = $name_field + 1;
    $form_state->set('num_names', $add_button);
    // Since our buildForm() method relies on the value of 'num_names' to
    // generate 'name' form elements, we have to tell the form to rebuild. If we
    // don't do this, the form builder will not call buildForm().
    $form_state->setRebuild();
  }

  /**
   * Submit handler for the "remove one" button.
   *
   * Decrements the max counter and causes a form rebuild.
   */
  public function removeCallback(array &$form, FormStateInterface $form_state) {
    $name_field = $form_state->get('num_names');
    if ($name_field > 1) {
      $remove_button = $name_field - 1;
      $form_state->set('num_names', $remove_button);
    }
    // Since our buildForm() method relies on the value of 'num_names' to
    // generate 'name' form elements, we have to tell the form to rebuild. If we
    // don't do this, the form builder will not call buildForm().
    $form_state->setRebuild();
  }


  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
//    if ($form_state->getValue('example') != 'example') {
//      $form_state->setErrorByName('example', $this->t('The value is not correct.'));
//    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('sand_remote.settings')
      ->set('example', $form_state->getValue('example'))
      ->save();
    $values = $form_state->getValue(['names_fieldset', 'name']);
    parent::submitForm($form, $form_state);
  }

}
