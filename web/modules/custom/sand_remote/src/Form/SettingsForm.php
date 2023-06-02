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

    $config = $this->config('sand_remote.settings');
    $form['#tree'] = TRUE;
    
    $form['info'] = [
      '#markup' => '<h3>Warning</h3><p>Do not change anything here unless you 100% know what you are doing otherwise it can impact our remote data.</p>', 
      '#suffix' => '<hr><p>&nbsp;</p>',
    ];

    // This is the field that is used to get the source of the data from the entity.
    $form['queue'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Turn Off Queuing for PDF Text'),
      '#default_value' => $config->get('queue'),
      '#description' => $this->t('Check this box if you do not want to queue each updated Or inserted item for PDF extraction')
    );

//    $form['webdata'] = array(
//      '#type' => 'checkbox',
//      '#title' => $this->t('If no text is extracted try WebData server?'),
//      '#default_value' => $config->get('webdata'),
//      '#description' => $this->t('If the normal method of text extraction via search_api_attachments gets no data then mark the entity for processing by the webdata server that uses tesseract to extract text from PDFs. The webdata server will get data from a view then use REST to update the body field.')
//    );

    $form['fetch'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Fetch remote file before extracting text?'),
      '#default_value' => $config->get('fetch'),
      '#description' => $this->t('Check this box if you want to fetch the remote file for PDF extraction before extracting text.')
    );

    $form['utf8threechar'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Save extracted text as 3 character UTF8 instead of normal 4 character UTF8?'),
      '#default_value' => $config->get('utf8threechar'),
      '#description' => $this->t('Our previous database only allowed three character UTF-8.')
    );

    $form['no_text_body_status'] = array(
      '#type' => 'textfield',
      '#size' => 60,
      '#title' => $this->t('Body Status text if no text'),
      '#required' => TRUE,
      '#default_value' => $config->get('no_text_body_status'),
      '#description' => $this->t('Set the field_body_status to start with this value if there is no text extracted using the inital method (not the WebData server). Usually the initial method will be tika (set in search_api_attachments module). After this text a colon and the date in format "YmdHis" will be appended.')
    );

    // This is the field that is used to get the source of the data from the entity.
    $form['source_field'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Source Field'),
      '#required' => TRUE,
      '#default_value' => $config->get('source_field'),
      '#description' => $this->t('This is the field of the entity we get the source name from (i.e. documentum)')
    );

    // Container for the AJAX callback. Everything inside this will be updated.
    $form['mappings_fieldset'] = [
      '#type' => 'fieldset',
      '#description' => '<p>Each row represents a value in the field: "field_source". If that value in field_source is equal to the first field "Source", then get the URL of the PDF to process from the "URL Field" and replace the text in "From URL" with "To URL (so we can transform the URL)".</p>',
      '#prefix' => '<div id="names-fieldset-wrapper">',
      '#suffix' => '</div>',
    ];

    // Table definition.
    $form['mappings_fieldset']['mappings'] = array(
      '#type' => 'table',
      '#caption' => $this->t('<h3>URL Mappings for different data sources</h3>'),
      '#prefix' => '<div id="names-fieldset-wrapper">',
      '#suffix' => '</div>',
      '#header' => array(
        $this->t('Source'),
        $this->t('URL Field' ),
        $this->t('From URL'),
        $this->t('To URL'),
      ),
    );

    // Gather the number of names in the form already.
    $mappings = $config->get('mappings');
    
    // We have to ensure that there is at least one name field. If the config has
    // more than one field then use that for the number of sources and populate it
    // from the config.
    $num_names = $form_state->get('num_names');
    if ($num_names === NULL) {
      // Get previously saved mappings
      $name_field = $form_state->set('num_names', count($mappings));
      $num_names = count($mappings);
    } 
    
    // Table rows
    for ($i = 1; $i <= $num_names; $i++) {
      $form['mappings_fieldset']['mappings'][$i]['source'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('Source'),
        '#title_display' => 'invisible',
        '#required' => TRUE,
        '#default_value' => $mappings[$i]['source'],
      );
      $form['mappings_fieldset']['mappings'][$i]['url_field'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('URL Field'),
        '#title_display' => 'invisible',
        '#required' => TRUE,
        '#default_value' => $mappings[$i]['url_field'],
      );
      $form['mappings_fieldset']['mappings'][$i]['from'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('From URL'),
        '#title_display' => 'invisible',
        '#required' => TRUE,
        '#default_value' => $mappings[$i]['from'],
      );
      $form['mappings_fieldset']['mappings'][$i]['to'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('To URL'),
        '#title_display' => 'invisible',
        '#required' => TRUE,
        '#default_value' => $mappings[$i]['to'],
      );
    }

    // Container for the AJAX buttons.
    $form['mappings_fieldset']['actions'] = [
      '#type' => 'actions',
    ];
    
    $form['mappings_fieldset']['actions']['add_name'] = [
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
      $form['mappings_fieldset']['actions']['remove_name'] = [
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
    return $form['mappings_fieldset'];
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
    // @todo Tried to not have the required fields checked on removeCallback but not working!    
    //    $form_state->setLimitValidationErrors(NULL);
    
    // Since our buildForm() method relies on the value of 'num_names' to
    // generate 'name' form elements, we have to tell the form to rebuild. If we
    // don't do this, the form builder will not call buildForm().
    $form_state->setRebuild();
  }


  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
      parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('sand_remote.settings')
      ->set('queue', $form_state->getValue(['queue']))
      ->set('webdata', $form_state->getValue(['webdata']))
      ->set('no_text_body_status', $form_state->getValue(['no_text_body_status']))
      ->set('fetch', $form_state->getValue(['fetch']))
      ->set('utf8threechar', $form_state->getValue(['utf8threechar']))
      ->set('source_field', $form_state->getValue(['source_field']))
      ->set('mappings', $form_state->getValue(['mappings_fieldset','mappings']))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
