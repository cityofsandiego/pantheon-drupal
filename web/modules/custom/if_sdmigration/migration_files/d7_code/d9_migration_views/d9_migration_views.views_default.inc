<?php

/**
 * @file
 * d9_migration_views.views_default.inc
 */

/**
 * Implements hook_views_default_views().
 */
function d9_migration_views_views_default_views() {
  $export = array();

  $view = new view();
  $view->name = 'content_migration';
  $view->description = '';
  $view->tag = 'default';
  $view->base_table = 'node';
  $view->human_name = 'Content Migration (nodes)';
  $view->core = 7;
  $view->api_version = '3.0';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['use_more_always'] = FALSE;
  $handler->display->display_options['access']['type'] = 'perm';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['pager']['options']['id'] = '0';
  $handler->display->display_options['pager']['options']['quantity'] = '9';
  $handler->display->display_options['style_plugin'] = 'views_json';
  $handler->display->display_options['style_options']['field_output'] = 'raw';
  $handler->display->display_options['style_options']['plaintext_output'] = 1;
  $handler->display->display_options['style_options']['remove_newlines'] = 0;
  $handler->display->display_options['style_options']['jsonp_prefix'] = '';
  $handler->display->display_options['style_options']['using_views_api_mode'] = 0;
  $handler->display->display_options['style_options']['translate_labels'] = 0;
  $handler->display->display_options['style_options']['object_arrays'] = 0;
  $handler->display->display_options['style_options']['numeric_strings'] = 0;
  $handler->display->display_options['style_options']['bigint_string'] = 0;
  $handler->display->display_options['style_options']['pretty_print'] = 0;
  $handler->display->display_options['style_options']['unescaped_slashes'] = 0;
  $handler->display->display_options['style_options']['unescaped_unicode'] = 0;
  $handler->display->display_options['style_options']['char_encoding'] = array();
  /* Relationship: Content: Image (field_image:fid) */
  $handler->display->display_options['relationships']['field_image_fid']['id'] = 'field_image_fid';
  $handler->display->display_options['relationships']['field_image_fid']['table'] = 'field_data_field_image';
  $handler->display->display_options['relationships']['field_image_fid']['field'] = 'field_image_fid';
  /* Relationship: Content: Feature Video / Image (field_dept_par_feature_video_img:fid) */
  $handler->display->display_options['relationships']['field_dept_par_feature_video_img_fid']['id'] = 'field_dept_par_feature_video_img_fid';
  $handler->display->display_options['relationships']['field_dept_par_feature_video_img_fid']['table'] = 'field_data_field_dept_par_feature_video_img';
  $handler->display->display_options['relationships']['field_dept_par_feature_video_img_fid']['field'] = 'field_dept_par_feature_video_img_fid';
  /* Field: Content: Nid */
  $handler->display->display_options['fields']['nid']['id'] = 'nid';
  $handler->display->display_options['fields']['nid']['table'] = 'node';
  $handler->display->display_options['fields']['nid']['field'] = 'nid';
  $handler->display->display_options['fields']['nid']['label'] = 'D7 ID';
  /* Field: Content: Path */
  $handler->display->display_options['fields']['path']['id'] = 'path';
  $handler->display->display_options['fields']['path']['table'] = 'node';
  $handler->display->display_options['fields']['path']['field'] = 'path';
  /* Field: Content: Resources */
  $handler->display->display_options['fields']['field_dept_resources_coll_1']['id'] = 'field_dept_resources_coll_1';
  $handler->display->display_options['fields']['field_dept_resources_coll_1']['table'] = 'field_data_field_dept_resources_coll';
  $handler->display->display_options['fields']['field_dept_resources_coll_1']['field'] = 'field_dept_resources_coll';
  $handler->display->display_options['fields']['field_dept_resources_coll_1']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_dept_resources_coll_1']['alter']['text'] = '[field_dept_resources_coll_1-value]';
  $handler->display->display_options['fields']['field_dept_resources_coll_1']['type'] = 'field_collection_fields';
  $handler->display->display_options['fields']['field_dept_resources_coll_1']['settings'] = array(
    'view_mode' => 'token',
  );
  $handler->display->display_options['fields']['field_dept_resources_coll_1']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_dept_resources_coll_1']['separator'] = '|';
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department']['id'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_department']['alter']['text'] = '[field_department-tid] ';
  $handler->display->display_options['fields']['field_department']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_department']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_department']['separator'] = '|';
  /* Field: Content: Category */
  $handler->display->display_options['fields']['field_category']['id'] = 'field_category';
  $handler->display->display_options['fields']['field_category']['table'] = 'field_data_field_category';
  $handler->display->display_options['fields']['field_category']['field'] = 'field_category';
  $handler->display->display_options['fields']['field_category']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_category']['alter']['text'] = '[field_category-tid]';
  $handler->display->display_options['fields']['field_category']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_category']['separator'] = '|';
  /* Field: Field: Search KeyMatch */
  $handler->display->display_options['fields']['field_search_keymatch']['id'] = 'field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['table'] = 'field_data_field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['field'] = 'field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_search_keymatch']['alter']['text'] = '[field_search_keymatch-tid]';
  $handler->display->display_options['fields']['field_search_keymatch']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_search_keymatch']['separator'] = '|';
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department_1']['id'] = 'field_department_1';
  $handler->display->display_options['fields']['field_department_1']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department_1']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department_1']['relationship'] = 'field_image_fid';
  $handler->display->display_options['fields']['field_department_1']['label'] = 'Image Department';
  $handler->display->display_options['fields']['field_department_1']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_department_1']['alter']['text'] = '[field_department_1-tid]';
  $handler->display->display_options['fields']['field_department_1']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_department_1']['settings'] = array(
    'view_mode' => 'default',
    'links' => 1,
    'use_content_language' => 1,
  );
  $handler->display->display_options['fields']['field_department_1']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_department_1']['separator'] = '|';
  /* Field: Field: License settings for this file */
  $handler->display->display_options['fields']['field_license']['id'] = 'field_license';
  $handler->display->display_options['fields']['field_license']['table'] = 'field_data_field_license';
  $handler->display->display_options['fields']['field_license']['field'] = 'field_license';
  $handler->display->display_options['fields']['field_license']['relationship'] = 'field_image_fid';
  $handler->display->display_options['fields']['field_license']['label'] = 'Image License settings for this file';
  $handler->display->display_options['fields']['field_license']['type'] = 'list_key';
  /* Field: File: Alt Text */
  $handler->display->display_options['fields']['field_file_image_alt_text']['id'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['table'] = 'field_data_field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['field'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['relationship'] = 'field_image_fid';
  $handler->display->display_options['fields']['field_file_image_alt_text']['label'] = 'Image Alt Text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['type'] = 'text_plain';
  /* Field: File: File ID */
  $handler->display->display_options['fields']['fid']['id'] = 'fid';
  $handler->display->display_options['fields']['fid']['table'] = 'file_managed';
  $handler->display->display_options['fields']['fid']['field'] = 'fid';
  $handler->display->display_options['fields']['fid']['relationship'] = 'field_image_fid';
  $handler->display->display_options['fields']['fid']['label'] = 'Image File ID';
  /* Field: File: Path */
  $handler->display->display_options['fields']['uri']['id'] = 'uri';
  $handler->display->display_options['fields']['uri']['table'] = 'file_managed';
  $handler->display->display_options['fields']['uri']['field'] = 'uri';
  $handler->display->display_options['fields']['uri']['relationship'] = 'field_image_fid';
  $handler->display->display_options['fields']['uri']['label'] = 'Image Path';
  /* Field: Content: Sidebar Content */
  $handler->display->display_options['fields']['field_additional_content']['id'] = 'field_additional_content';
  $handler->display->display_options['fields']['field_additional_content']['table'] = 'field_data_field_additional_content';
  $handler->display->display_options['fields']['field_additional_content']['field'] = 'field_additional_content';
  $handler->display->display_options['fields']['field_additional_content']['label'] = 'Contact Info';
  $handler->display->display_options['fields']['field_additional_content']['alter']['text'] = '[field_additional_content-value]';
  /* Field: Content: Feature Alt Text */
  $handler->display->display_options['fields']['field_dept_feature_alt_text']['id'] = 'field_dept_feature_alt_text';
  $handler->display->display_options['fields']['field_dept_feature_alt_text']['table'] = 'field_data_field_dept_feature_alt_text';
  $handler->display->display_options['fields']['field_dept_feature_alt_text']['field'] = 'field_dept_feature_alt_text';
  /* Field: Content: Featured Content */
  $handler->display->display_options['fields']['field_dept_par_featured_content']['id'] = 'field_dept_par_featured_content';
  $handler->display->display_options['fields']['field_dept_par_featured_content']['table'] = 'field_data_field_dept_par_featured_content';
  $handler->display->display_options['fields']['field_dept_par_featured_content']['field'] = 'field_dept_par_featured_content';
  /* Field: Content: Hide News Feed */
  $handler->display->display_options['fields']['field_dept_par_hide_news_feed']['id'] = 'field_dept_par_hide_news_feed';
  $handler->display->display_options['fields']['field_dept_par_hide_news_feed']['table'] = 'field_data_field_dept_par_hide_news_feed';
  $handler->display->display_options['fields']['field_dept_par_hide_news_feed']['field'] = 'field_dept_par_hide_news_feed';
  $handler->display->display_options['fields']['field_dept_par_hide_news_feed']['type'] = 'list_key';
  /* Field: Content: Social Links */
  $handler->display->display_options['fields']['field_dept_par_social_links_coll']['id'] = 'field_dept_par_social_links_coll';
  $handler->display->display_options['fields']['field_dept_par_social_links_coll']['table'] = 'field_data_field_dept_par_social_links_coll';
  $handler->display->display_options['fields']['field_dept_par_social_links_coll']['field'] = 'field_dept_par_social_links_coll';
  $handler->display->display_options['fields']['field_dept_par_social_links_coll']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_dept_par_social_links_coll']['alter']['text'] = '[field_dept_par_social_links_coll-value]';
  $handler->display->display_options['fields']['field_dept_par_social_links_coll']['type'] = 'field_collection_list';
  $handler->display->display_options['fields']['field_dept_par_social_links_coll']['settings'] = array(
    'add' => 'Add',
    'edit' => 'Edit',
    'translate' => 'Translate',
    'delete' => 'Delete',
    'description' => 1,
  );
  $handler->display->display_options['fields']['field_dept_par_social_links_coll']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_dept_par_social_links_coll']['separator'] = '| ';
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department_2']['id'] = 'field_department_2';
  $handler->display->display_options['fields']['field_department_2']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department_2']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department_2']['relationship'] = 'field_dept_par_feature_video_img_fid';
  $handler->display->display_options['fields']['field_department_2']['label'] = 'Featured Image Department';
  $handler->display->display_options['fields']['field_department_2']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_department_2']['alter']['text'] = '[field_department_2-tid]';
  $handler->display->display_options['fields']['field_department_2']['type'] = 'entityreference_entity_view';
  $handler->display->display_options['fields']['field_department_2']['settings'] = array(
    'view_mode' => 'default',
    'links' => 1,
    'use_content_language' => 1,
  );
  $handler->display->display_options['fields']['field_department_2']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_department_2']['separator'] = '|';
  /* Field: Field: License settings for this file */
  $handler->display->display_options['fields']['field_license_1']['id'] = 'field_license_1';
  $handler->display->display_options['fields']['field_license_1']['table'] = 'field_data_field_license';
  $handler->display->display_options['fields']['field_license_1']['field'] = 'field_license';
  $handler->display->display_options['fields']['field_license_1']['relationship'] = 'field_dept_par_feature_video_img_fid';
  $handler->display->display_options['fields']['field_license_1']['label'] = 'Featured Image License settings for this file';
  /* Field: File: Alt Text */
  $handler->display->display_options['fields']['field_file_image_alt_text_1']['id'] = 'field_file_image_alt_text_1';
  $handler->display->display_options['fields']['field_file_image_alt_text_1']['table'] = 'field_data_field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text_1']['field'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text_1']['relationship'] = 'field_dept_par_feature_video_img_fid';
  $handler->display->display_options['fields']['field_file_image_alt_text_1']['label'] = 'Featured Image Alt Text';
  $handler->display->display_options['fields']['field_file_image_alt_text_1']['type'] = 'text_plain';
  /* Field: File: File ID */
  $handler->display->display_options['fields']['fid_1']['id'] = 'fid_1';
  $handler->display->display_options['fields']['fid_1']['table'] = 'file_managed';
  $handler->display->display_options['fields']['fid_1']['field'] = 'fid';
  $handler->display->display_options['fields']['fid_1']['relationship'] = 'field_dept_par_feature_video_img_fid';
  $handler->display->display_options['fields']['fid_1']['label'] = 'Featured Image File ID';
  /* Field: File: Path */
  $handler->display->display_options['fields']['uri_1']['id'] = 'uri_1';
  $handler->display->display_options['fields']['uri_1']['table'] = 'file_managed';
  $handler->display->display_options['fields']['uri_1']['field'] = 'uri';
  $handler->display->display_options['fields']['uri_1']['relationship'] = 'field_dept_par_feature_video_img_fid';
  $handler->display->display_options['fields']['uri_1']['label'] = 'Featured Image Path';
  /* Field: Content: Published status */
  $handler->display->display_options['fields']['status']['id'] = 'status';
  $handler->display->display_options['fields']['status']['table'] = 'node';
  $handler->display->display_options['fields']['status']['field'] = 'status';
  $handler->display->display_options['fields']['status']['type'] = 'boolean';
  $handler->display->display_options['fields']['status']['not'] = 0;
  /* Field: Content: News Alt Text */
  $handler->display->display_options['fields']['field_dept_news_alt_text']['id'] = 'field_dept_news_alt_text';
  $handler->display->display_options['fields']['field_dept_news_alt_text']['table'] = 'field_data_field_dept_news_alt_text';
  $handler->display->display_options['fields']['field_dept_news_alt_text']['field'] = 'field_dept_news_alt_text';
  $handler->display->display_options['fields']['field_dept_news_alt_text']['type'] = 'text_plain';
  /* Field: Content: Show Top Slider */
  $handler->display->display_options['fields']['field_dept_par_show_top_slider']['id'] = 'field_dept_par_show_top_slider';
  $handler->display->display_options['fields']['field_dept_par_show_top_slider']['table'] = 'field_data_field_dept_par_show_top_slider';
  $handler->display->display_options['fields']['field_dept_par_show_top_slider']['field'] = 'field_dept_par_show_top_slider';
  $handler->display->display_options['fields']['field_dept_par_show_top_slider']['type'] = 'list_key';
  /* Field: Content: Sidebar */
  $handler->display->display_options['fields']['field_intro']['id'] = 'field_intro';
  $handler->display->display_options['fields']['field_intro']['table'] = 'field_data_field_intro';
  $handler->display->display_options['fields']['field_intro']['field'] = 'field_intro';
  $handler->display->display_options['fields']['field_intro']['alter']['text'] = '[field_intro-value] ';
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['link_to_node'] = FALSE;
  /* Field: Content: Single Line Title */
  $handler->display->display_options['fields']['field_dept_par_single_line_title']['id'] = 'field_dept_par_single_line_title';
  $handler->display->display_options['fields']['field_dept_par_single_line_title']['table'] = 'field_data_field_dept_par_single_line_title';
  $handler->display->display_options['fields']['field_dept_par_single_line_title']['field'] = 'field_dept_par_single_line_title';
  $handler->display->display_options['fields']['field_dept_par_single_line_title']['type'] = 'list_key';
  /* Sort criterion: Content: Post date */
  $handler->display->display_options['sorts']['created']['id'] = 'created';
  $handler->display->display_options['sorts']['created']['table'] = 'node';
  $handler->display->display_options['sorts']['created']['field'] = 'created';
  $handler->display->display_options['sorts']['created']['order'] = 'DESC';
  /* Filter criterion: Content: Published status */
  $handler->display->display_options['filters']['status']['id'] = 'status';
  $handler->display->display_options['filters']['status']['table'] = 'node';
  $handler->display->display_options['filters']['status']['field'] = 'status';
  $handler->display->display_options['filters']['status']['value'] = 1;
  $handler->display->display_options['filters']['status']['group'] = 1;
  $handler->display->display_options['filters']['status']['expose']['operator'] = FALSE;
  /* Filter criterion: Content: Type */
  $handler->display->display_options['filters']['type']['id'] = 'type';
  $handler->display->display_options['filters']['type']['table'] = 'node';
  $handler->display->display_options['filters']['type']['field'] = 'type';
  $handler->display->display_options['filters']['type']['value'] = array(
    'department' => 'department',
  );
  $handler->display->display_options['filters']['type']['expose']['operator_id'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['label'] = 'Type';
  $handler->display->display_options['filters']['type']['expose']['operator'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['identifier'] = 'type';

  /* Display: Data export */
  $handler = $view->new_display('views_data_export', 'Data export', 'views_data_export_1');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['style_options']['provide_file'] = 0;
  $handler->display->display_options['style_options']['filename'] = 'departments.csv';
  $handler->display->display_options['style_options']['parent_sort'] = 0;
  $handler->display->display_options['style_options']['quote'] = 0;
  $handler->display->display_options['style_options']['trim'] = 1;
  $handler->display->display_options['style_options']['replace_newlines'] = 0;
  $handler->display->display_options['style_options']['newline_token'] = '1';
  $handler->display->display_options['style_options']['header'] = 1;
  $handler->display->display_options['style_options']['keep_html'] = 1;
  $handler->display->display_options['style_options']['encoding'] = 'ASCII';
  $handler->display->display_options['path'] = 'migration/departments';
  $handler->display->display_options['use_batch'] = 'batch';
  $handler->display->display_options['segment_size'] = '100';

  /* Display: Data export */
  $handler = $view->new_display('views_data_export', 'Data export', 'views_data_export_2');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['style_options']['provide_file'] = 0;
  $handler->display->display_options['style_options']['filename'] = 'departments.csv';
  $handler->display->display_options['style_options']['parent_sort'] = 0;
  $handler->display->display_options['style_options']['quote'] = 0;
  $handler->display->display_options['style_options']['trim'] = 1;
  $handler->display->display_options['style_options']['replace_newlines'] = 0;
  $handler->display->display_options['style_options']['newline_token'] = '1';
  $handler->display->display_options['style_options']['header'] = 1;
  $handler->display->display_options['style_options']['keep_html'] = 1;
  $handler->display->display_options['style_options']['encoding'] = 'ASCII';
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Content: Published status */
  $handler->display->display_options['filters']['status']['id'] = 'status';
  $handler->display->display_options['filters']['status']['table'] = 'node';
  $handler->display->display_options['filters']['status']['field'] = 'status';
  $handler->display->display_options['filters']['status']['value'] = 1;
  $handler->display->display_options['filters']['status']['group'] = 1;
  $handler->display->display_options['filters']['status']['expose']['operator'] = FALSE;
  /* Filter criterion: Content: Type */
  $handler->display->display_options['filters']['type']['id'] = 'type';
  $handler->display->display_options['filters']['type']['table'] = 'node';
  $handler->display->display_options['filters']['type']['field'] = 'type';
  $handler->display->display_options['filters']['type']['value'] = array(
    'department' => 'department',
  );
  $handler->display->display_options['filters']['type']['expose']['operator_id'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['label'] = 'Type';
  $handler->display->display_options['filters']['type']['expose']['operator'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['identifier'] = 'type';
  $handler->display->display_options['path'] = 'migration/departments-small';
  $handler->display->display_options['use_batch'] = 'batch';
  $handler->display->display_options['segment_size'] = '100';

  /* Display: Data export 3 */
  $handler = $view->new_display('views_data_export', 'Data export 3', 'views_data_export_3');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['style_options']['provide_file'] = 0;
  $handler->display->display_options['style_options']['parent_sort'] = 0;
  $handler->display->display_options['style_options']['quote'] = 1;
  $handler->display->display_options['style_options']['trim'] = 0;
  $handler->display->display_options['style_options']['replace_newlines'] = 0;
  $handler->display->display_options['style_options']['newline_token'] = '1';
  $handler->display->display_options['style_options']['header'] = 1;
  $handler->display->display_options['style_options']['keep_html'] = 1;
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Content: Published status */
  $handler->display->display_options['filters']['status']['id'] = 'status';
  $handler->display->display_options['filters']['status']['table'] = 'node';
  $handler->display->display_options['filters']['status']['field'] = 'status';
  $handler->display->display_options['filters']['status']['value'] = 1;
  $handler->display->display_options['filters']['status']['group'] = 1;
  $handler->display->display_options['filters']['status']['expose']['operator'] = FALSE;
  /* Filter criterion: Content: Type */
  $handler->display->display_options['filters']['type']['id'] = 'type';
  $handler->display->display_options['filters']['type']['table'] = 'node';
  $handler->display->display_options['filters']['type']['field'] = 'type';
  $handler->display->display_options['filters']['type']['value'] = array(
    'department_parent' => 'department_parent',
  );
  $handler->display->display_options['filters']['type']['expose']['operator_id'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['label'] = 'Type';
  $handler->display->display_options['filters']['type']['expose']['operator'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['identifier'] = 'type';
  $handler->display->display_options['path'] = 'migration/department-parents';
  $handler->display->display_options['use_batch'] = 'batch';
  $handler->display->display_options['segment_size'] = '100';

  /* Display: Data export 4 */
  $handler = $view->new_display('views_data_export', 'Data export 4', 'views_data_export_4');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['style_options']['provide_file'] = 0;
  $handler->display->display_options['style_options']['parent_sort'] = 0;
  $handler->display->display_options['style_options']['quote'] = 1;
  $handler->display->display_options['style_options']['trim'] = 0;
  $handler->display->display_options['style_options']['replace_newlines'] = 0;
  $handler->display->display_options['style_options']['newline_token'] = '1';
  $handler->display->display_options['style_options']['header'] = 1;
  $handler->display->display_options['style_options']['keep_html'] = 1;
  $handler->display->display_options['defaults']['relationships'] = FALSE;
  /* Relationship: Content: Featured Video / Image (field_bucket_featured_vid_img:fid) */
  $handler->display->display_options['relationships']['field_bucket_featured_vid_img_fid']['id'] = 'field_bucket_featured_vid_img_fid';
  $handler->display->display_options['relationships']['field_bucket_featured_vid_img_fid']['table'] = 'field_data_field_bucket_featured_vid_img';
  $handler->display->display_options['relationships']['field_bucket_featured_vid_img_fid']['field'] = 'field_bucket_featured_vid_img_fid';
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Content: Nid */
  $handler->display->display_options['fields']['nid']['id'] = 'nid';
  $handler->display->display_options['fields']['nid']['table'] = 'node';
  $handler->display->display_options['fields']['nid']['field'] = 'nid';
  $handler->display->display_options['fields']['nid']['label'] = 'D7 ID';
  /* Field: Content: Path */
  $handler->display->display_options['fields']['path']['id'] = 'path';
  $handler->display->display_options['fields']['path']['table'] = 'node';
  $handler->display->display_options['fields']['path']['field'] = 'path';
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['link_to_node'] = FALSE;
  /* Field: Content: Subtitle */
  $handler->display->display_options['fields']['field_bucket_subtitle']['id'] = 'field_bucket_subtitle';
  $handler->display->display_options['fields']['field_bucket_subtitle']['table'] = 'field_data_field_bucket_subtitle';
  $handler->display->display_options['fields']['field_bucket_subtitle']['field'] = 'field_bucket_subtitle';
  /* Field: Field: Bucket */
  $handler->display->display_options['fields']['field_bucket_taxonomy']['id'] = 'field_bucket_taxonomy';
  $handler->display->display_options['fields']['field_bucket_taxonomy']['table'] = 'field_data_field_bucket_taxonomy';
  $handler->display->display_options['fields']['field_bucket_taxonomy']['field'] = 'field_bucket_taxonomy';
  $handler->display->display_options['fields']['field_bucket_taxonomy']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_bucket_taxonomy']['alter']['text'] = '[field_bucket_taxonomy-tid]';
  $handler->display->display_options['fields']['field_bucket_taxonomy']['type'] = 'taxonomy_term_reference_plain';
  /* Field: Content: Body */
  $handler->display->display_options['fields']['body']['id'] = 'body';
  $handler->display->display_options['fields']['body']['table'] = 'field_data_body';
  $handler->display->display_options['fields']['body']['field'] = 'body';
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department_2']['id'] = 'field_department_2';
  $handler->display->display_options['fields']['field_department_2']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department_2']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department_2']['relationship'] = 'field_bucket_featured_vid_img_fid';
  $handler->display->display_options['fields']['field_department_2']['label'] = 'Featured Image Department';
  $handler->display->display_options['fields']['field_department_2']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_department_2']['alter']['text'] = '[field_department_2-tid]';
  $handler->display->display_options['fields']['field_department_2']['type'] = 'entityreference_entity_view';
  $handler->display->display_options['fields']['field_department_2']['settings'] = array(
    'view_mode' => 'default',
    'links' => 1,
    'use_content_language' => 1,
  );
  $handler->display->display_options['fields']['field_department_2']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_department_2']['separator'] = '|';
  /* Field: Field: License settings for this file */
  $handler->display->display_options['fields']['field_license_1']['id'] = 'field_license_1';
  $handler->display->display_options['fields']['field_license_1']['table'] = 'field_data_field_license';
  $handler->display->display_options['fields']['field_license_1']['field'] = 'field_license';
  $handler->display->display_options['fields']['field_license_1']['relationship'] = 'field_bucket_featured_vid_img_fid';
  $handler->display->display_options['fields']['field_license_1']['label'] = 'Featured Image License settings for this file';
  /* Field: File: Alt Text */
  $handler->display->display_options['fields']['field_file_image_alt_text_1']['id'] = 'field_file_image_alt_text_1';
  $handler->display->display_options['fields']['field_file_image_alt_text_1']['table'] = 'field_data_field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text_1']['field'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text_1']['relationship'] = 'field_bucket_featured_vid_img_fid';
  $handler->display->display_options['fields']['field_file_image_alt_text_1']['label'] = 'Featured Image Alt Text';
  $handler->display->display_options['fields']['field_file_image_alt_text_1']['type'] = 'text_plain';
  /* Field: File: File ID */
  $handler->display->display_options['fields']['fid_1']['id'] = 'fid_1';
  $handler->display->display_options['fields']['fid_1']['table'] = 'file_managed';
  $handler->display->display_options['fields']['fid_1']['field'] = 'fid';
  $handler->display->display_options['fields']['fid_1']['relationship'] = 'field_bucket_featured_vid_img_fid';
  $handler->display->display_options['fields']['fid_1']['label'] = 'Featured Image File ID';
  /* Field: File: Path */
  $handler->display->display_options['fields']['uri_1']['id'] = 'uri_1';
  $handler->display->display_options['fields']['uri_1']['table'] = 'file_managed';
  $handler->display->display_options['fields']['uri_1']['field'] = 'uri';
  $handler->display->display_options['fields']['uri_1']['relationship'] = 'field_bucket_featured_vid_img_fid';
  $handler->display->display_options['fields']['uri_1']['label'] = 'Featured Image Path';
  /* Field: Content: Featured Cards */
  $handler->display->display_options['fields']['field_bucket_featured_cards_coll']['id'] = 'field_bucket_featured_cards_coll';
  $handler->display->display_options['fields']['field_bucket_featured_cards_coll']['table'] = 'field_data_field_bucket_featured_cards_coll';
  $handler->display->display_options['fields']['field_bucket_featured_cards_coll']['field'] = 'field_bucket_featured_cards_coll';
  $handler->display->display_options['fields']['field_bucket_featured_cards_coll']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_bucket_featured_cards_coll']['alter']['text'] = '[field_bucket_featured_cards_coll-value]';
  $handler->display->display_options['fields']['field_bucket_featured_cards_coll']['type'] = 'field_collection_fields';
  $handler->display->display_options['fields']['field_bucket_featured_cards_coll']['settings'] = array(
    'view_mode' => 'full',
  );
  $handler->display->display_options['fields']['field_bucket_featured_cards_coll']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_bucket_featured_cards_coll']['separator'] = '|';
  /* Field: Content: Featured Section Title */
  $handler->display->display_options['fields']['field_bucket_featured_title']['id'] = 'field_bucket_featured_title';
  $handler->display->display_options['fields']['field_bucket_featured_title']['table'] = 'field_data_field_bucket_featured_title';
  $handler->display->display_options['fields']['field_bucket_featured_title']['field'] = 'field_bucket_featured_title';
  /* Field: Content: Events / Programs & Initiatives Items */
  $handler->display->display_options['fields']['field_bucket_events_pi_coll']['id'] = 'field_bucket_events_pi_coll';
  $handler->display->display_options['fields']['field_bucket_events_pi_coll']['table'] = 'field_data_field_bucket_events_pi_coll';
  $handler->display->display_options['fields']['field_bucket_events_pi_coll']['field'] = 'field_bucket_events_pi_coll';
  $handler->display->display_options['fields']['field_bucket_events_pi_coll']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_bucket_events_pi_coll']['alter']['text'] = '[field_bucket_events_pi_coll-value]';
  $handler->display->display_options['fields']['field_bucket_events_pi_coll']['type'] = 'field_collection_fields';
  $handler->display->display_options['fields']['field_bucket_events_pi_coll']['settings'] = array(
    'view_mode' => 'full',
  );
  $handler->display->display_options['fields']['field_bucket_events_pi_coll']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_bucket_events_pi_coll']['separator'] = '|';
  /* Field: Content: Resources */
  $handler->display->display_options['fields']['field_dept_resources_coll']['id'] = 'field_dept_resources_coll';
  $handler->display->display_options['fields']['field_dept_resources_coll']['table'] = 'field_data_field_dept_resources_coll';
  $handler->display->display_options['fields']['field_dept_resources_coll']['field'] = 'field_dept_resources_coll';
  $handler->display->display_options['fields']['field_dept_resources_coll']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_dept_resources_coll']['alter']['text'] = '[field_dept_resources_coll-value]';
  $handler->display->display_options['fields']['field_dept_resources_coll']['type'] = 'field_collection_fields';
  $handler->display->display_options['fields']['field_dept_resources_coll']['settings'] = array(
    'view_mode' => 'full',
  );
  $handler->display->display_options['fields']['field_dept_resources_coll']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_dept_resources_coll']['separator'] = '|';
  /* Field: Field: Featured Items */
  $handler->display->display_options['fields']['field_bucket_featured_coll']['id'] = 'field_bucket_featured_coll';
  $handler->display->display_options['fields']['field_bucket_featured_coll']['table'] = 'field_data_field_bucket_featured_coll';
  $handler->display->display_options['fields']['field_bucket_featured_coll']['field'] = 'field_bucket_featured_coll';
  $handler->display->display_options['fields']['field_bucket_featured_coll']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_bucket_featured_coll']['alter']['text'] = '[field_bucket_featured_coll-value]';
  $handler->display->display_options['fields']['field_bucket_featured_coll']['type'] = 'field_collection_fields';
  $handler->display->display_options['fields']['field_bucket_featured_coll']['settings'] = array(
    'view_mode' => 'full',
  );
  $handler->display->display_options['fields']['field_bucket_featured_coll']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_bucket_featured_coll']['separator'] = '|';
  /* Field: Field: Search KeyMatch */
  $handler->display->display_options['fields']['field_search_keymatch']['id'] = 'field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['table'] = 'field_data_field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['field'] = 'field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_search_keymatch']['alter']['text'] = '[field_search_keymatch-tid]';
  $handler->display->display_options['fields']['field_search_keymatch']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_search_keymatch']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_search_keymatch']['separator'] = '|';
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Content: Published status */
  $handler->display->display_options['filters']['status']['id'] = 'status';
  $handler->display->display_options['filters']['status']['table'] = 'node';
  $handler->display->display_options['filters']['status']['field'] = 'status';
  $handler->display->display_options['filters']['status']['value'] = 1;
  $handler->display->display_options['filters']['status']['group'] = 1;
  $handler->display->display_options['filters']['status']['expose']['operator'] = FALSE;
  /* Filter criterion: Content: Type */
  $handler->display->display_options['filters']['type']['id'] = 'type';
  $handler->display->display_options['filters']['type']['table'] = 'node';
  $handler->display->display_options['filters']['type']['field'] = 'type';
  $handler->display->display_options['filters']['type']['value'] = array(
    'bucket' => 'bucket',
  );
  $handler->display->display_options['filters']['type']['expose']['operator_id'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['label'] = 'Type';
  $handler->display->display_options['filters']['type']['expose']['operator'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['identifier'] = 'type';
  $handler->display->display_options['path'] = 'migration/buckets';
  $export['content_migration'] = $view;

  $view = new view();
  $view->name = 'field_collection_migrations';
  $view->description = '';
  $view->tag = 'default';
  $view->base_table = 'field_collection_item';
  $view->human_name = 'Field collection migrations';
  $view->core = 7;
  $view->api_version = '3.0';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['use_more_always'] = FALSE;
  $handler->display->display_options['access']['type'] = 'none';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['style_plugin'] = 'default';
  $handler->display->display_options['row_plugin'] = 'fields';
  /* Relationship: Field collection item: Image (field_bucket_events_pi_image:fid) */
  $handler->display->display_options['relationships']['field_bucket_events_pi_image_fid']['id'] = 'field_bucket_events_pi_image_fid';
  $handler->display->display_options['relationships']['field_bucket_events_pi_image_fid']['table'] = 'field_data_field_bucket_events_pi_image';
  $handler->display->display_options['relationships']['field_bucket_events_pi_image_fid']['field'] = 'field_bucket_events_pi_image_fid';
  /* Field: Field collection item: Field collection item ID */
  $handler->display->display_options['fields']['item_id']['id'] = 'item_id';
  $handler->display->display_options['fields']['item_id']['table'] = 'field_collection_item';
  $handler->display->display_options['fields']['item_id']['field'] = 'item_id';
  $handler->display->display_options['fields']['item_id']['label'] = 'ID';
  /* Field: Field collection item: Type */
  $handler->display->display_options['fields']['field_social_links_type']['id'] = 'field_social_links_type';
  $handler->display->display_options['fields']['field_social_links_type']['table'] = 'field_data_field_social_links_type';
  $handler->display->display_options['fields']['field_social_links_type']['field'] = 'field_social_links_type';
  /* Field: Field collection item: URL */
  $handler->display->display_options['fields']['field_social_links_url']['id'] = 'field_social_links_url';
  $handler->display->display_options['fields']['field_social_links_url']['table'] = 'field_data_field_social_links_url';
  $handler->display->display_options['fields']['field_social_links_url']['field'] = 'field_social_links_url';
  /* Filter criterion: Field collection item: Field name */
  $handler->display->display_options['filters']['field_name']['id'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['table'] = 'field_collection_item';
  $handler->display->display_options['filters']['field_name']['field'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['value'] = array(
    'field_dept_par_social_links_coll' => 'field_dept_par_social_links_coll',
  );

  /* Display: Data export */
  $handler = $view->new_display('views_data_export', 'Data export', 'views_data_export_1');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['defaults']['relationships'] = FALSE;
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Field collection item: Field collection item ID */
  $handler->display->display_options['fields']['item_id']['id'] = 'item_id';
  $handler->display->display_options['fields']['item_id']['table'] = 'field_collection_item';
  $handler->display->display_options['fields']['item_id']['field'] = 'item_id';
  $handler->display->display_options['fields']['item_id']['label'] = 'ID';
  /* Field: Field collection item: Icon */
  $handler->display->display_options['fields']['field_resources_coll_icon']['id'] = 'field_resources_coll_icon';
  $handler->display->display_options['fields']['field_resources_coll_icon']['table'] = 'field_data_field_resources_coll_icon';
  $handler->display->display_options['fields']['field_resources_coll_icon']['field'] = 'field_resources_coll_icon';
  /* Field: Field collection item: Label */
  $handler->display->display_options['fields']['field_resources_coll_label']['id'] = 'field_resources_coll_label';
  $handler->display->display_options['fields']['field_resources_coll_label']['table'] = 'field_data_field_resources_coll_label';
  $handler->display->display_options['fields']['field_resources_coll_label']['field'] = 'field_resources_coll_label';
  /* Field: Field collection item: URL */
  $handler->display->display_options['fields']['field_resources_coll_url']['id'] = 'field_resources_coll_url';
  $handler->display->display_options['fields']['field_resources_coll_url']['table'] = 'field_data_field_resources_coll_url';
  $handler->display->display_options['fields']['field_resources_coll_url']['field'] = 'field_resources_coll_url';
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Field collection item: Field name */
  $handler->display->display_options['filters']['field_name']['id'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['table'] = 'field_collection_item';
  $handler->display->display_options['filters']['field_name']['field'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['value'] = array(
    'field_dept_resources_coll' => 'field_dept_resources_coll',
  );
  $handler->display->display_options['path'] = 'migration/fieldcollection/field_dept_resources_coll';

  /* Display: Data export */
  $handler = $view->new_display('views_data_export', 'Data export', 'views_data_export_2');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['defaults']['relationships'] = FALSE;
  $handler->display->display_options['path'] = 'migration/fieldcollection/field_dept_par_social_links_coll';

  /* Display: Data export 3 */
  $handler = $view->new_display('views_data_export', 'Data export 3', 'views_data_export_3');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['defaults']['relationships'] = FALSE;
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Field collection item: Field collection item ID */
  $handler->display->display_options['fields']['item_id']['id'] = 'item_id';
  $handler->display->display_options['fields']['item_id']['table'] = 'field_collection_item';
  $handler->display->display_options['fields']['item_id']['field'] = 'item_id';
  $handler->display->display_options['fields']['item_id']['label'] = 'ID';
  /* Field: Field collection item: Card */
  $handler->display->display_options['fields']['field_featured_cards_card']['id'] = 'field_featured_cards_card';
  $handler->display->display_options['fields']['field_featured_cards_card']['table'] = 'field_data_field_featured_cards_card';
  $handler->display->display_options['fields']['field_featured_cards_card']['field'] = 'field_featured_cards_card';
  $handler->display->display_options['fields']['field_featured_cards_card']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_featured_cards_card']['alter']['text'] = '[field_featured_cards_card-value]';
  $handler->display->display_options['fields']['field_featured_cards_card']['type'] = 'field_collection_fields';
  $handler->display->display_options['fields']['field_featured_cards_card']['settings'] = array(
    'view_mode' => 'full',
  );
  $handler->display->display_options['fields']['field_featured_cards_card']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_featured_cards_card']['separator'] = '|';
  /* Field: Field collection item: Section Title */
  $handler->display->display_options['fields']['field_featured_cards_title']['id'] = 'field_featured_cards_title';
  $handler->display->display_options['fields']['field_featured_cards_title']['table'] = 'field_data_field_featured_cards_title';
  $handler->display->display_options['fields']['field_featured_cards_title']['field'] = 'field_featured_cards_title';
  /* Field: Field collection item: Section Title URL */
  $handler->display->display_options['fields']['field_featured_cards_title_url']['id'] = 'field_featured_cards_title_url';
  $handler->display->display_options['fields']['field_featured_cards_title_url']['table'] = 'field_data_field_featured_cards_title_url';
  $handler->display->display_options['fields']['field_featured_cards_title_url']['field'] = 'field_featured_cards_title_url';
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Field collection item: Field name */
  $handler->display->display_options['filters']['field_name']['id'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['table'] = 'field_collection_item';
  $handler->display->display_options['filters']['field_name']['field'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['value'] = array(
    'field_bucket_featured_coll' => 'field_bucket_featured_coll',
  );
  $handler->display->display_options['path'] = 'migration/fieldcollection/field_bucket_featured_cards_coll';

  /* Display: Data export 4 */
  $handler = $view->new_display('views_data_export', 'Data export 4', 'views_data_export_4');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Field collection item: Field collection item ID */
  $handler->display->display_options['fields']['item_id']['id'] = 'item_id';
  $handler->display->display_options['fields']['item_id']['table'] = 'field_collection_item';
  $handler->display->display_options['fields']['item_id']['field'] = 'item_id';
  $handler->display->display_options['fields']['item_id']['label'] = 'ID';
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department']['id'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['relationship'] = 'field_bucket_events_pi_image_fid';
  /* Field: Field: License settings for this file */
  $handler->display->display_options['fields']['field_license']['id'] = 'field_license';
  $handler->display->display_options['fields']['field_license']['table'] = 'field_data_field_license';
  $handler->display->display_options['fields']['field_license']['field'] = 'field_license';
  $handler->display->display_options['fields']['field_license']['relationship'] = 'field_bucket_events_pi_image_fid';
  $handler->display->display_options['fields']['field_license']['label'] = 'Image License settings for this file';
  $handler->display->display_options['fields']['field_license']['type'] = 'list_key';
  /* Field: File: Alt Text */
  $handler->display->display_options['fields']['field_file_image_alt_text']['id'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['table'] = 'field_data_field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['field'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['relationship'] = 'field_bucket_events_pi_image_fid';
  $handler->display->display_options['fields']['field_file_image_alt_text']['label'] = 'Image Alt Text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['type'] = 'text_plain';
  /* Field: File: File ID */
  $handler->display->display_options['fields']['fid']['id'] = 'fid';
  $handler->display->display_options['fields']['fid']['table'] = 'file_managed';
  $handler->display->display_options['fields']['fid']['field'] = 'fid';
  $handler->display->display_options['fields']['fid']['relationship'] = 'field_bucket_events_pi_image_fid';
  $handler->display->display_options['fields']['fid']['label'] = 'Image File ID';
  /* Field: File: Path */
  $handler->display->display_options['fields']['uri']['id'] = 'uri';
  $handler->display->display_options['fields']['uri']['table'] = 'file_managed';
  $handler->display->display_options['fields']['uri']['field'] = 'uri';
  $handler->display->display_options['fields']['uri']['relationship'] = 'field_bucket_events_pi_image_fid';
  $handler->display->display_options['fields']['uri']['label'] = 'Image Path';
  /* Field: Field collection item: Label */
  $handler->display->display_options['fields']['field_bucket_events_pi_label']['id'] = 'field_bucket_events_pi_label';
  $handler->display->display_options['fields']['field_bucket_events_pi_label']['table'] = 'field_data_field_bucket_events_pi_label';
  $handler->display->display_options['fields']['field_bucket_events_pi_label']['field'] = 'field_bucket_events_pi_label';
  $handler->display->display_options['fields']['field_bucket_events_pi_label']['type'] = 'text_plain';
  /* Field: Field collection item: URL */
  $handler->display->display_options['fields']['field_bucket_events_pi_url']['id'] = 'field_bucket_events_pi_url';
  $handler->display->display_options['fields']['field_bucket_events_pi_url']['table'] = 'field_data_field_bucket_events_pi_url';
  $handler->display->display_options['fields']['field_bucket_events_pi_url']['field'] = 'field_bucket_events_pi_url';
  $handler->display->display_options['fields']['field_bucket_events_pi_url']['type'] = 'text_plain';
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Field collection item: Field name */
  $handler->display->display_options['filters']['field_name']['id'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['table'] = 'field_collection_item';
  $handler->display->display_options['filters']['field_name']['field'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['value'] = array(
    'field_bucket_events_pi_coll' => 'field_bucket_events_pi_coll',
    'field_dept_par_social_links_coll' => 'field_dept_par_social_links_coll',
  );
  $handler->display->display_options['path'] = 'migration/fieldcollection/field_bucket_events_pi_coll';

  /* Display: Data export 5 */
  $handler = $view->new_display('views_data_export', 'Data export 5', 'views_data_export_5');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['defaults']['relationships'] = FALSE;
  /* Relationship: Field collection item: Image (field_bucket_ft_image:fid) */
  $handler->display->display_options['relationships']['field_bucket_ft_image_fid']['id'] = 'field_bucket_ft_image_fid';
  $handler->display->display_options['relationships']['field_bucket_ft_image_fid']['table'] = 'field_data_field_bucket_ft_image';
  $handler->display->display_options['relationships']['field_bucket_ft_image_fid']['field'] = 'field_bucket_ft_image_fid';
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Field collection item: Field collection item ID */
  $handler->display->display_options['fields']['item_id']['id'] = 'item_id';
  $handler->display->display_options['fields']['item_id']['table'] = 'field_collection_item';
  $handler->display->display_options['fields']['item_id']['field'] = 'item_id';
  $handler->display->display_options['fields']['item_id']['label'] = 'ID';
  /* Field: Field collection item: Label */
  $handler->display->display_options['fields']['field_bucket_ft_label']['id'] = 'field_bucket_ft_label';
  $handler->display->display_options['fields']['field_bucket_ft_label']['table'] = 'field_data_field_bucket_ft_label';
  $handler->display->display_options['fields']['field_bucket_ft_label']['field'] = 'field_bucket_ft_label';
  $handler->display->display_options['fields']['field_bucket_ft_label']['type'] = 'text_plain';
  /* Field: Field collection item: URL */
  $handler->display->display_options['fields']['field_bucket_ft_url']['id'] = 'field_bucket_ft_url';
  $handler->display->display_options['fields']['field_bucket_ft_url']['table'] = 'field_data_field_bucket_ft_url';
  $handler->display->display_options['fields']['field_bucket_ft_url']['field'] = 'field_bucket_ft_url';
  $handler->display->display_options['fields']['field_bucket_ft_url']['type'] = 'text_plain';
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department']['id'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['relationship'] = 'field_bucket_ft_image_fid';
  /* Field: Field: License settings for this file */
  $handler->display->display_options['fields']['field_license']['id'] = 'field_license';
  $handler->display->display_options['fields']['field_license']['table'] = 'field_data_field_license';
  $handler->display->display_options['fields']['field_license']['field'] = 'field_license';
  $handler->display->display_options['fields']['field_license']['relationship'] = 'field_bucket_ft_image_fid';
  $handler->display->display_options['fields']['field_license']['label'] = 'Image License settings for this file';
  $handler->display->display_options['fields']['field_license']['type'] = 'list_key';
  /* Field: File: Alt Text */
  $handler->display->display_options['fields']['field_file_image_alt_text']['id'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['table'] = 'field_data_field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['field'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['relationship'] = 'field_bucket_ft_image_fid';
  $handler->display->display_options['fields']['field_file_image_alt_text']['label'] = 'Image Alt Text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['type'] = 'text_plain';
  /* Field: File: File ID */
  $handler->display->display_options['fields']['fid']['id'] = 'fid';
  $handler->display->display_options['fields']['fid']['table'] = 'file_managed';
  $handler->display->display_options['fields']['fid']['field'] = 'fid';
  $handler->display->display_options['fields']['fid']['relationship'] = 'field_bucket_ft_image_fid';
  /* Field: File: Path */
  $handler->display->display_options['fields']['uri']['id'] = 'uri';
  $handler->display->display_options['fields']['uri']['table'] = 'file_managed';
  $handler->display->display_options['fields']['uri']['field'] = 'uri';
  $handler->display->display_options['fields']['uri']['relationship'] = 'field_bucket_ft_image_fid';
  $handler->display->display_options['fields']['uri']['label'] = 'Image Path';
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Field collection item: Field name */
  $handler->display->display_options['filters']['field_name']['id'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['table'] = 'field_collection_item';
  $handler->display->display_options['filters']['field_name']['field'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['value'] = array(
    'field_bucket_featured_coll' => 'field_bucket_featured_coll',
  );
  $handler->display->display_options['path'] = 'migration/fieldcollection/field_bucket_featured_coll';
  $export['field_collection_migrations'] = $view;

  $view = new view();
  $view->name = 'taxonomy_migration';
  $view->description = '';
  $view->tag = 'default';
  $view->base_table = 'taxonomy_term_data';
  $view->human_name = 'Taxonomy Migration';
  $view->core = 7;
  $view->api_version = '3.0';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['title'] = 'Search KeyMatch';
  $handler->display->display_options['use_more_always'] = FALSE;
  $handler->display->display_options['access']['type'] = 'perm';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['style_plugin'] = 'default';
  $handler->display->display_options['row_plugin'] = 'fields';
  /* Relationship: Taxonomy term: Parent term */
  $handler->display->display_options['relationships']['parent']['id'] = 'parent';
  $handler->display->display_options['relationships']['parent']['table'] = 'taxonomy_term_hierarchy';
  $handler->display->display_options['relationships']['parent']['field'] = 'parent';
  /* Field: Taxonomy term: Name */
  $handler->display->display_options['fields']['name']['id'] = 'name';
  $handler->display->display_options['fields']['name']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['name']['field'] = 'name';
  $handler->display->display_options['fields']['name']['alter']['word_boundary'] = FALSE;
  $handler->display->display_options['fields']['name']['alter']['ellipsis'] = FALSE;
  /* Field: Taxonomy term: Term ID */
  $handler->display->display_options['fields']['tid']['id'] = 'tid';
  $handler->display->display_options['fields']['tid']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['tid']['field'] = 'tid';
  $handler->display->display_options['fields']['tid']['separator'] = '';
  /* Field: Taxonomy term: Weight */
  $handler->display->display_options['fields']['weight']['id'] = 'weight';
  $handler->display->display_options['fields']['weight']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['weight']['field'] = 'weight';
  /* Filter criterion: Taxonomy vocabulary: Machine name */
  $handler->display->display_options['filters']['machine_name']['id'] = 'machine_name';
  $handler->display->display_options['filters']['machine_name']['table'] = 'taxonomy_vocabulary';
  $handler->display->display_options['filters']['machine_name']['field'] = 'machine_name';
  $handler->display->display_options['filters']['machine_name']['value'] = array(
    'bucket' => 'bucket',
  );

  /* Display: Data export */
  $handler = $view->new_display('views_data_export', 'Data export', 'views_data_export_1');
  $handler->display->display_options['defaults']['title'] = FALSE;
  $handler->display->display_options['title'] = 'Departments';
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['style_options']['provide_file'] = 0;
  $handler->display->display_options['style_options']['parent_sort'] = 0;
  $handler->display->display_options['style_options']['quote'] = 0;
  $handler->display->display_options['style_options']['trim'] = 0;
  $handler->display->display_options['style_options']['replace_newlines'] = 0;
  $handler->display->display_options['style_options']['newline_token'] = '1';
  $handler->display->display_options['style_options']['header'] = 1;
  $handler->display->display_options['style_options']['keep_html'] = 0;
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Taxonomy term: Term ID */
  $handler->display->display_options['fields']['tid']['id'] = 'tid';
  $handler->display->display_options['fields']['tid']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['tid']['field'] = 'tid';
  $handler->display->display_options['fields']['tid']['separator'] = '';
  /* Field: Taxonomy term: Term ID */
  $handler->display->display_options['fields']['tid_1']['id'] = 'tid_1';
  $handler->display->display_options['fields']['tid_1']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['tid_1']['field'] = 'tid';
  $handler->display->display_options['fields']['tid_1']['relationship'] = 'parent';
  $handler->display->display_options['fields']['tid_1']['label'] = 'Parent Term ID';
  $handler->display->display_options['fields']['tid_1']['separator'] = '';
  /* Field: Taxonomy term: Name */
  $handler->display->display_options['fields']['name']['id'] = 'name';
  $handler->display->display_options['fields']['name']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['name']['field'] = 'name';
  $handler->display->display_options['fields']['name']['alter']['word_boundary'] = FALSE;
  $handler->display->display_options['fields']['name']['alter']['ellipsis'] = FALSE;
  /* Field: Taxonomy term: Weight */
  $handler->display->display_options['fields']['weight']['id'] = 'weight';
  $handler->display->display_options['fields']['weight']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['weight']['field'] = 'weight';
  $handler->display->display_options['fields']['weight']['separator'] = '';
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Taxonomy vocabulary: Machine name */
  $handler->display->display_options['filters']['machine_name']['id'] = 'machine_name';
  $handler->display->display_options['filters']['machine_name']['table'] = 'taxonomy_vocabulary';
  $handler->display->display_options['filters']['machine_name']['field'] = 'machine_name';
  $handler->display->display_options['filters']['machine_name']['value'] = array(
    'department' => 'department',
  );
  $handler->display->display_options['path'] = 'migration/taxonomy/departments';
  $handler->display->display_options['sitename_title'] = 0;

  /* Display: Data export */
  $handler = $view->new_display('views_data_export', 'Data export', 'views_data_export_2');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['style_options']['provide_file'] = 0;
  $handler->display->display_options['style_options']['parent_sort'] = 0;
  $handler->display->display_options['style_options']['quote'] = 0;
  $handler->display->display_options['style_options']['trim'] = 0;
  $handler->display->display_options['style_options']['replace_newlines'] = 0;
  $handler->display->display_options['style_options']['newline_token'] = '1';
  $handler->display->display_options['style_options']['header'] = 1;
  $handler->display->display_options['style_options']['keep_html'] = 0;
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Taxonomy term: Term ID */
  $handler->display->display_options['fields']['tid']['id'] = 'tid';
  $handler->display->display_options['fields']['tid']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['tid']['field'] = 'tid';
  $handler->display->display_options['fields']['tid']['separator'] = '';
  /* Field: Taxonomy term: Term ID */
  $handler->display->display_options['fields']['tid_1']['id'] = 'tid_1';
  $handler->display->display_options['fields']['tid_1']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['tid_1']['field'] = 'tid';
  $handler->display->display_options['fields']['tid_1']['relationship'] = 'parent';
  $handler->display->display_options['fields']['tid_1']['label'] = 'Parent Term ID';
  $handler->display->display_options['fields']['tid_1']['separator'] = '';
  /* Field: Taxonomy term: Name */
  $handler->display->display_options['fields']['name']['id'] = 'name';
  $handler->display->display_options['fields']['name']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['name']['field'] = 'name';
  $handler->display->display_options['fields']['name']['alter']['word_boundary'] = FALSE;
  $handler->display->display_options['fields']['name']['alter']['ellipsis'] = FALSE;
  /* Field: Taxonomy term: Weight */
  $handler->display->display_options['fields']['weight']['id'] = 'weight';
  $handler->display->display_options['fields']['weight']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['weight']['field'] = 'weight';
  $handler->display->display_options['fields']['weight']['separator'] = '';
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Taxonomy vocabulary: Machine name */
  $handler->display->display_options['filters']['machine_name']['id'] = 'machine_name';
  $handler->display->display_options['filters']['machine_name']['table'] = 'taxonomy_vocabulary';
  $handler->display->display_options['filters']['machine_name']['field'] = 'machine_name';
  $handler->display->display_options['filters']['machine_name']['value'] = array(
    'categories' => 'categories',
  );
  $handler->display->display_options['path'] = 'migration/taxonomy/categories';
  $handler->display->display_options['sitename_title'] = 0;

  /* Display: Data export */
  $handler = $view->new_display('views_data_export', 'Data export', 'views_data_export_3');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['style_options']['provide_file'] = 0;
  $handler->display->display_options['style_options']['parent_sort'] = 0;
  $handler->display->display_options['style_options']['quote'] = 0;
  $handler->display->display_options['style_options']['trim'] = 0;
  $handler->display->display_options['style_options']['replace_newlines'] = 0;
  $handler->display->display_options['style_options']['newline_token'] = '1';
  $handler->display->display_options['style_options']['header'] = 1;
  $handler->display->display_options['style_options']['keep_html'] = 0;
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Taxonomy term: Term ID */
  $handler->display->display_options['fields']['tid']['id'] = 'tid';
  $handler->display->display_options['fields']['tid']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['tid']['field'] = 'tid';
  $handler->display->display_options['fields']['tid']['separator'] = '';
  /* Field: Taxonomy term: Term ID */
  $handler->display->display_options['fields']['tid_1']['id'] = 'tid_1';
  $handler->display->display_options['fields']['tid_1']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['tid_1']['field'] = 'tid';
  $handler->display->display_options['fields']['tid_1']['relationship'] = 'parent';
  $handler->display->display_options['fields']['tid_1']['label'] = 'Parent Term ID';
  $handler->display->display_options['fields']['tid_1']['separator'] = '';
  /* Field: Taxonomy term: Name */
  $handler->display->display_options['fields']['name']['id'] = 'name';
  $handler->display->display_options['fields']['name']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['name']['field'] = 'name';
  $handler->display->display_options['fields']['name']['alter']['word_boundary'] = FALSE;
  $handler->display->display_options['fields']['name']['alter']['ellipsis'] = FALSE;
  /* Field: Taxonomy term: Weight */
  $handler->display->display_options['fields']['weight']['id'] = 'weight';
  $handler->display->display_options['fields']['weight']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['weight']['field'] = 'weight';
  $handler->display->display_options['fields']['weight']['separator'] = '';
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Taxonomy vocabulary: Machine name */
  $handler->display->display_options['filters']['machine_name']['id'] = 'machine_name';
  $handler->display->display_options['filters']['machine_name']['table'] = 'taxonomy_vocabulary';
  $handler->display->display_options['filters']['machine_name']['field'] = 'machine_name';
  $handler->display->display_options['filters']['machine_name']['value'] = array(
    'search_keymatch' => 'search_keymatch',
  );
  $handler->display->display_options['path'] = 'migration/taxonomy/keymatch';
  $handler->display->display_options['sitename_title'] = 0;

  /* Display: Data export */
  $handler = $view->new_display('views_data_export', 'Data export', 'views_data_export_4');
  $handler->display->display_options['defaults']['title'] = FALSE;
  $handler->display->display_options['title'] = 'Location';
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['style_options']['provide_file'] = 0;
  $handler->display->display_options['style_options']['parent_sort'] = 0;
  $handler->display->display_options['style_options']['quote'] = 0;
  $handler->display->display_options['style_options']['trim'] = 0;
  $handler->display->display_options['style_options']['replace_newlines'] = 0;
  $handler->display->display_options['style_options']['newline_token'] = '1';
  $handler->display->display_options['style_options']['header'] = 1;
  $handler->display->display_options['style_options']['keep_html'] = 0;
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Taxonomy term: Term ID */
  $handler->display->display_options['fields']['tid']['id'] = 'tid';
  $handler->display->display_options['fields']['tid']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['tid']['field'] = 'tid';
  $handler->display->display_options['fields']['tid']['separator'] = '';
  /* Field: Taxonomy term: Term ID */
  $handler->display->display_options['fields']['tid_1']['id'] = 'tid_1';
  $handler->display->display_options['fields']['tid_1']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['tid_1']['field'] = 'tid';
  $handler->display->display_options['fields']['tid_1']['relationship'] = 'parent';
  $handler->display->display_options['fields']['tid_1']['label'] = 'Parent Term ID';
  $handler->display->display_options['fields']['tid_1']['separator'] = '';
  /* Field: Taxonomy term: Name */
  $handler->display->display_options['fields']['name']['id'] = 'name';
  $handler->display->display_options['fields']['name']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['name']['field'] = 'name';
  $handler->display->display_options['fields']['name']['alter']['word_boundary'] = FALSE;
  $handler->display->display_options['fields']['name']['alter']['ellipsis'] = FALSE;
  /* Field: Taxonomy term: Weight */
  $handler->display->display_options['fields']['weight']['id'] = 'weight';
  $handler->display->display_options['fields']['weight']['table'] = 'taxonomy_term_data';
  $handler->display->display_options['fields']['weight']['field'] = 'weight';
  $handler->display->display_options['fields']['weight']['separator'] = '';
  $handler->display->display_options['path'] = 'migration/taxonomy/location';
  $handler->display->display_options['sitename_title'] = 0;

  /* Display: Data export 5 */
  $handler = $view->new_display('views_data_export', 'Data export 5', 'views_data_export_5');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['path'] = 'migration/taxonomy/buckets';
  $export['taxonomy_migration'] = $view;

  return $export;
}
