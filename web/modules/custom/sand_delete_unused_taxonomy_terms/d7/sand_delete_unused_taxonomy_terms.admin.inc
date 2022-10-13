<?php
/**
* @file
* Calls results to administration's pages.
*/

/**
* Form constructor for module configuration.
*
*/
function sand_delete_unused_taxonomy_terms_admin_settings($form_state) {
    $form = array();
    $form['info'] = array(
        '#markup' => t('This will delete all unused terms in Vocabulary 3 (Category)'),
    );
    $form['#submit'][] = 'custom_form_submit';
  return system_settings_form($form);
}

/**
 * Submit handler
 */
function custom_form_submit($form, &$form_state) {

  // NOTE: The VID is hard coded.
  $query = "
  SELECT taxonomy_term_data.tid AS tid
  FROM 
  {taxonomy_term_data} taxonomy_term_data
  LEFT JOIN {taxonomy_index} taxonomy_index ON taxonomy_term_data.tid = taxonomy_index.tid
  LEFT JOIN {node} node_taxonomy_index ON taxonomy_index.nid = node_taxonomy_index.nid
  LEFT JOIN {taxonomy_vocabulary} taxonomy_vocabulary ON taxonomy_term_data.vid = taxonomy_vocabulary.vid
  WHERE taxonomy_term_data.vid = '3'
  GROUP BY tid
  HAVING COUNT(DISTINCT node_taxonomy_index.nid) = '0'";

  $tids = \Drupal::database()->query($query)->fetchCol();

  foreach ($tids as $tid) {
    $tid->delete();
    \Drupal::messenger()->addMessage($tid);
  }
}
