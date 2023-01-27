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

  /* Display: Data export 5 */
  $handler = $view->new_display('views_data_export', 'Data export 5', 'views_data_export_5');
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
  $handler->display->display_options['defaults']['relationships'] = FALSE;
  /* Relationship: Content: Address (field_location_address) */
  $handler->display->display_options['relationships']['field_location_address_lid']['id'] = 'field_location_address_lid';
  $handler->display->display_options['relationships']['field_location_address_lid']['table'] = 'field_data_field_location_address';
  $handler->display->display_options['relationships']['field_location_address_lid']['field'] = 'field_location_address_lid';
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
  /* Field: Location: Street */
  $handler->display->display_options['fields']['street_1']['id'] = 'street_1';
  $handler->display->display_options['fields']['street_1']['table'] = 'location';
  $handler->display->display_options['fields']['street_1']['field'] = 'street';
  /* Field: Location: Additional */
  $handler->display->display_options['fields']['additional']['id'] = 'additional';
  $handler->display->display_options['fields']['additional']['table'] = 'location';
  $handler->display->display_options['fields']['additional']['field'] = 'additional';
  /* Field: Location: City */
  $handler->display->display_options['fields']['city']['id'] = 'city';
  $handler->display->display_options['fields']['city']['table'] = 'location';
  $handler->display->display_options['fields']['city']['field'] = 'city';
  /* Field: Location: Latitude */
  $handler->display->display_options['fields']['latitude']['id'] = 'latitude';
  $handler->display->display_options['fields']['latitude']['table'] = 'location';
  $handler->display->display_options['fields']['latitude']['field'] = 'latitude';
  $handler->display->display_options['fields']['latitude']['style'] = 'dd';
  /* Field: Location: Longitude */
  $handler->display->display_options['fields']['longitude']['id'] = 'longitude';
  $handler->display->display_options['fields']['longitude']['table'] = 'location';
  $handler->display->display_options['fields']['longitude']['field'] = 'longitude';
  $handler->display->display_options['fields']['longitude']['style'] = 'dd';
  /* Field: Location: Name */
  $handler->display->display_options['fields']['name']['id'] = 'name';
  $handler->display->display_options['fields']['name']['table'] = 'location';
  $handler->display->display_options['fields']['name']['field'] = 'name';
  /* Field: Location: Postal Code */
  $handler->display->display_options['fields']['postal_code']['id'] = 'postal_code';
  $handler->display->display_options['fields']['postal_code']['table'] = 'location';
  $handler->display->display_options['fields']['postal_code']['field'] = 'postal_code';
  /* Field: Location: Province */
  $handler->display->display_options['fields']['province']['id'] = 'province';
  $handler->display->display_options['fields']['province']['table'] = 'location';
  $handler->display->display_options['fields']['province']['field'] = 'province';
  /* Field: Content: Alternate Amenities Title */
  $handler->display->display_options['fields']['field_alt_amenities_title']['id'] = 'field_alt_amenities_title';
  $handler->display->display_options['fields']['field_alt_amenities_title']['table'] = 'field_data_field_alt_amenities_title';
  $handler->display->display_options['fields']['field_alt_amenities_title']['field'] = 'field_alt_amenities_title';
  /* Field: Content: Alternate Restrictions Title */
  $handler->display->display_options['fields']['field_alt_restrictions_title']['id'] = 'field_alt_restrictions_title';
  $handler->display->display_options['fields']['field_alt_restrictions_title']['table'] = 'field_data_field_alt_restrictions_title';
  $handler->display->display_options['fields']['field_alt_restrictions_title']['field'] = 'field_alt_restrictions_title';
  /* Field: Content: Amenities */
  $handler->display->display_options['fields']['field_location_amenities_coll']['id'] = 'field_location_amenities_coll';
  $handler->display->display_options['fields']['field_location_amenities_coll']['table'] = 'field_data_field_location_amenities_coll';
  $handler->display->display_options['fields']['field_location_amenities_coll']['field'] = 'field_location_amenities_coll';
  $handler->display->display_options['fields']['field_location_amenities_coll']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_location_amenities_coll']['alter']['text'] = '[field_location_amenities_coll-value]';
  $handler->display->display_options['fields']['field_location_amenities_coll']['type'] = 'field_collection_fields';
  $handler->display->display_options['fields']['field_location_amenities_coll']['settings'] = array(
    'view_mode' => 'full',
  );
  $handler->display->display_options['fields']['field_location_amenities_coll']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_location_amenities_coll']['separator'] = '|';
  /* Field: Content: Body */
  $handler->display->display_options['fields']['body']['id'] = 'body';
  $handler->display->display_options['fields']['body']['table'] = 'field_data_body';
  $handler->display->display_options['fields']['body']['field'] = 'body';
  /* Field: Content: Bucket */
  $handler->display->display_options['fields']['field_location_bucket']['id'] = 'field_location_bucket';
  $handler->display->display_options['fields']['field_location_bucket']['table'] = 'field_data_field_location_bucket';
  $handler->display->display_options['fields']['field_location_bucket']['field'] = 'field_location_bucket';
  $handler->display->display_options['fields']['field_location_bucket']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_location_bucket']['alter']['text'] = '[field_location_bucket-tid]';
  $handler->display->display_options['fields']['field_location_bucket']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_location_bucket']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_location_bucket']['separator'] = '|';
  /* Field: Content: Contact Name */
  $handler->display->display_options['fields']['field_location_contact_name']['id'] = 'field_location_contact_name';
  $handler->display->display_options['fields']['field_location_contact_name']['table'] = 'field_data_field_location_contact_name';
  $handler->display->display_options['fields']['field_location_contact_name']['field'] = 'field_location_contact_name';
  /* Field: Content: Contact Title */
  $handler->display->display_options['fields']['field_location_contact_title']['id'] = 'field_location_contact_title';
  $handler->display->display_options['fields']['field_location_contact_title']['table'] = 'field_data_field_location_contact_title';
  $handler->display->display_options['fields']['field_location_contact_title']['field'] = 'field_location_contact_title';
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department']['id'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_department']['alter']['text'] = '[field_department-tid]';
  $handler->display->display_options['fields']['field_department']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_department']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_department']['separator'] = '|';
  /* Field: Content: Email */
  $handler->display->display_options['fields']['field_location_email']['id'] = 'field_location_email';
  $handler->display->display_options['fields']['field_location_email']['table'] = 'field_data_field_location_email';
  $handler->display->display_options['fields']['field_location_email']['field'] = 'field_location_email';
  /* Field: Content: Exceptions */
  $handler->display->display_options['fields']['field_location_exceptions_coll2']['id'] = 'field_location_exceptions_coll2';
  $handler->display->display_options['fields']['field_location_exceptions_coll2']['table'] = 'field_data_field_location_exceptions_coll2';
  $handler->display->display_options['fields']['field_location_exceptions_coll2']['field'] = 'field_location_exceptions_coll2';
  $handler->display->display_options['fields']['field_location_exceptions_coll2']['label'] = 'Secondary Exceptions';
  $handler->display->display_options['fields']['field_location_exceptions_coll2']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_location_exceptions_coll2']['alter']['text'] = '[field_location_exceptions_coll2-value]';
  $handler->display->display_options['fields']['field_location_exceptions_coll2']['type'] = 'field_collection_fields';
  $handler->display->display_options['fields']['field_location_exceptions_coll2']['settings'] = array(
    'view_mode' => 'full',
  );
  $handler->display->display_options['fields']['field_location_exceptions_coll2']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_location_exceptions_coll2']['separator'] = '|';
  /* Field: Content: External ID */
  $handler->display->display_options['fields']['field_location_external_id']['id'] = 'field_location_external_id';
  $handler->display->display_options['fields']['field_location_external_id']['table'] = 'field_data_field_location_external_id';
  $handler->display->display_options['fields']['field_location_external_id']['field'] = 'field_location_external_id';
  $handler->display->display_options['fields']['field_location_external_id']['type'] = 'text_plain';
  /* Field: Content: External Place ID */
  $handler->display->display_options['fields']['field_location_external_place_id']['id'] = 'field_location_external_place_id';
  $handler->display->display_options['fields']['field_location_external_place_id']['table'] = 'field_data_field_location_external_place_id';
  $handler->display->display_options['fields']['field_location_external_place_id']['field'] = 'field_location_external_place_id';
  $handler->display->display_options['fields']['field_location_external_place_id']['type'] = 'text_plain';
  /* Field: Content: Hours */
  $handler->display->display_options['fields']['field_location_hours']['id'] = 'field_location_hours';
  $handler->display->display_options['fields']['field_location_hours']['table'] = 'field_data_field_location_hours';
  $handler->display->display_options['fields']['field_location_hours']['field'] = 'field_location_hours';
  $handler->display->display_options['fields']['field_location_hours']['alter']['strip_tags'] = TRUE;
  $handler->display->display_options['fields']['field_location_hours']['element_default_classes'] = FALSE;
  $handler->display->display_options['fields']['field_location_hours']['click_sort_column'] = 'day';
  $handler->display->display_options['fields']['field_location_hours']['settings'] = array(
    'showclosed' => 'open',
    'date_first_day' => '0',
    'daysformat' => 'number',
    'hoursformat' => '2',
    'compress' => 0,
    'grouped' => 0,
    'closedformat' => 'Closed',
    'separator_days' => '\\',
    'separator_grouped_days' => '/',
    'separator_day_hours' => ';',
    'separator_hours_hours' => '~',
    'separator_more_hours' => '#',
    'current_status' => array(
      'position' => 'hide',
      'open_text' => 'Currently open!',
      'closed_text' => 'Currently closed',
    ),
  );
  $handler->display->display_options['fields']['field_location_hours']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_location_hours']['separator'] = '|';
  /* Field: Content: Location Hours Title */
  $handler->display->display_options['fields']['field_location_hours_title2']['id'] = 'field_location_hours_title2';
  $handler->display->display_options['fields']['field_location_hours_title2']['table'] = 'field_data_field_location_hours_title2';
  $handler->display->display_options['fields']['field_location_hours_title2']['field'] = 'field_location_hours_title2';
  $handler->display->display_options['fields']['field_location_hours_title2']['label'] = 'Secondary Location Hours Title';
  $handler->display->display_options['fields']['field_location_hours_title2']['type'] = 'text_plain';
  /* Field: Content: Location Type */
  $handler->display->display_options['fields']['field_location_location_type']['id'] = 'field_location_location_type';
  $handler->display->display_options['fields']['field_location_location_type']['table'] = 'field_data_field_location_location_type';
  $handler->display->display_options['fields']['field_location_location_type']['field'] = 'field_location_location_type';
  $handler->display->display_options['fields']['field_location_location_type']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_location_location_type']['alter']['text'] = '[field_location_location_type-tid]';
  $handler->display->display_options['fields']['field_location_location_type']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_location_location_type']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_location_location_type']['separator'] = '|';
  /* Field: Content: Notes */
  $handler->display->display_options['fields']['field_location_hours_notes2']['id'] = 'field_location_hours_notes2';
  $handler->display->display_options['fields']['field_location_hours_notes2']['table'] = 'field_data_field_location_hours_notes2';
  $handler->display->display_options['fields']['field_location_hours_notes2']['field'] = 'field_location_hours_notes2';
  $handler->display->display_options['fields']['field_location_hours_notes2']['label'] = 'Secondary Notes';
  /* Field: Content: Partial Re-Open of Citywide Closure */
  $handler->display->display_options['fields']['field_partial_re_open_citywide']['id'] = 'field_partial_re_open_citywide';
  $handler->display->display_options['fields']['field_partial_re_open_citywide']['table'] = 'field_data_field_partial_re_open_citywide';
  $handler->display->display_options['fields']['field_partial_re_open_citywide']['field'] = 'field_partial_re_open_citywide';
  $handler->display->display_options['fields']['field_partial_re_open_citywide']['type'] = 'list_key';
  /* Field: Content: Phone */
  $handler->display->display_options['fields']['field_location_phone']['id'] = 'field_location_phone';
  $handler->display->display_options['fields']['field_location_phone']['table'] = 'field_data_field_location_phone';
  $handler->display->display_options['fields']['field_location_phone']['field'] = 'field_location_phone';
  $handler->display->display_options['fields']['field_location_phone']['type'] = 'text_plain';
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
  /* Field: Content: Restrictions */
  $handler->display->display_options['fields']['field_location_restrictions_coll']['id'] = 'field_location_restrictions_coll';
  $handler->display->display_options['fields']['field_location_restrictions_coll']['table'] = 'field_data_field_location_restrictions_coll';
  $handler->display->display_options['fields']['field_location_restrictions_coll']['field'] = 'field_location_restrictions_coll';
  $handler->display->display_options['fields']['field_location_restrictions_coll']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_location_restrictions_coll']['alter']['text'] = '[field_location_restrictions_coll-value]';
  $handler->display->display_options['fields']['field_location_restrictions_coll']['type'] = 'field_collection_fields';
  $handler->display->display_options['fields']['field_location_restrictions_coll']['settings'] = array(
    'view_mode' => 'full',
  );
  $handler->display->display_options['fields']['field_location_restrictions_coll']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_location_restrictions_coll']['separator'] = '|';
  /* Field: Content: Secondary Hours */
  $handler->display->display_options['fields']['field_location_hours2']['id'] = 'field_location_hours2';
  $handler->display->display_options['fields']['field_location_hours2']['table'] = 'field_data_field_location_hours2';
  $handler->display->display_options['fields']['field_location_hours2']['field'] = 'field_location_hours2';
  $handler->display->display_options['fields']['field_location_hours2']['alter']['strip_tags'] = TRUE;
  $handler->display->display_options['fields']['field_location_hours2']['element_default_classes'] = FALSE;
  $handler->display->display_options['fields']['field_location_hours2']['click_sort_column'] = 'day';
  $handler->display->display_options['fields']['field_location_hours2']['settings'] = array(
    'showclosed' => 'open',
    'date_first_day' => '0',
    'daysformat' => 'number',
    'hoursformat' => '2',
    'compress' => 0,
    'grouped' => 0,
    'closedformat' => 'Closed',
    'separator_days' => '\\',
    'separator_grouped_days' => '/',
    'separator_day_hours' => ';',
    'separator_hours_hours' => '~',
    'separator_more_hours' => '#',
    'current_status' => array(
      'position' => 'hide',
      'open_text' => 'Currently open!',
      'closed_text' => 'Currently closed',
    ),
  );
  $handler->display->display_options['fields']['field_location_hours2']['delta_offset'] = '0';
  /* Field: Content: Sidebar Content */
  $handler->display->display_options['fields']['field_location_sidebar_content']['id'] = 'field_location_sidebar_content';
  $handler->display->display_options['fields']['field_location_sidebar_content']['table'] = 'field_data_field_location_sidebar_content';
  $handler->display->display_options['fields']['field_location_sidebar_content']['field'] = 'field_location_sidebar_content';
  /* Field: Content: Subtitle */
  $handler->display->display_options['fields']['field_location_subtitle']['id'] = 'field_location_subtitle';
  $handler->display->display_options['fields']['field_location_subtitle']['table'] = 'field_data_field_location_subtitle';
  $handler->display->display_options['fields']['field_location_subtitle']['field'] = 'field_location_subtitle';
  $handler->display->display_options['fields']['field_location_subtitle']['type'] = 'text_plain';
  /* Field: Content: Title Sort */
  $handler->display->display_options['fields']['field_title_sort']['id'] = 'field_title_sort';
  $handler->display->display_options['fields']['field_title_sort']['table'] = 'field_data_field_title_sort';
  $handler->display->display_options['fields']['field_title_sort']['field'] = 'field_title_sort';
  $handler->display->display_options['fields']['field_title_sort']['type'] = 'text_plain';
  /* Field: Content: Website */
  $handler->display->display_options['fields']['field_location_website']['id'] = 'field_location_website';
  $handler->display->display_options['fields']['field_location_website']['table'] = 'field_data_field_location_website';
  $handler->display->display_options['fields']['field_location_website']['field'] = 'field_location_website';
  $handler->display->display_options['fields']['field_location_website']['type'] = 'text_plain';
  /* Field: Field: Search KeyMatch */
  $handler->display->display_options['fields']['field_search_keymatch']['id'] = 'field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['table'] = 'field_data_field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['field'] = 'field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_search_keymatch']['alter']['text'] = '[field_search_keymatch-tid]';
  $handler->display->display_options['fields']['field_search_keymatch']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_search_keymatch']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_search_keymatch']['separator'] = '|';
  /* Field: Content: Notes */
  $handler->display->display_options['fields']['field_location_hours_notes']['id'] = 'field_location_hours_notes';
  $handler->display->display_options['fields']['field_location_hours_notes']['table'] = 'field_data_field_location_hours_notes';
  $handler->display->display_options['fields']['field_location_hours_notes']['field'] = 'field_location_hours_notes';
  /* Field: Content: Exceptions */
  $handler->display->display_options['fields']['field_location_exceptions_coll']['id'] = 'field_location_exceptions_coll';
  $handler->display->display_options['fields']['field_location_exceptions_coll']['table'] = 'field_data_field_location_exceptions_coll';
  $handler->display->display_options['fields']['field_location_exceptions_coll']['field'] = 'field_location_exceptions_coll';
  $handler->display->display_options['fields']['field_location_exceptions_coll']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_location_exceptions_coll']['alter']['text'] = '[field_location_exceptions_coll-value] ';
  $handler->display->display_options['fields']['field_location_exceptions_coll']['type'] = 'field_collection_fields';
  $handler->display->display_options['fields']['field_location_exceptions_coll']['settings'] = array(
    'view_mode' => 'full',
  );
  $handler->display->display_options['fields']['field_location_exceptions_coll']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_location_exceptions_coll']['separator'] = '|';
  /* Field: Content: Location Hours Title */
  $handler->display->display_options['fields']['field_location_hours_title']['id'] = 'field_location_hours_title';
  $handler->display->display_options['fields']['field_location_hours_title']['table'] = 'field_data_field_location_hours_title';
  $handler->display->display_options['fields']['field_location_hours_title']['field'] = 'field_location_hours_title';
  $handler->display->display_options['fields']['field_location_hours_title']['type'] = 'text_plain';
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
    'locations' => 'locations',
  );
  $handler->display->display_options['filters']['type']['expose']['operator_id'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['label'] = 'Type';
  $handler->display->display_options['filters']['type']['expose']['operator'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['identifier'] = 'type';
  $handler->display->display_options['path'] = 'migration/locations';
  $handler->display->display_options['use_batch'] = 'batch';
  $handler->display->display_options['segment_size'] = '100';

  /* Display: Data export 6 */
  $handler = $view->new_display('views_data_export', 'Data export 6', 'views_data_export_6');
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
  $handler->display->display_options['defaults']['relationships'] = FALSE;
  /* Relationship: Content: Image (field_image:fid) */
  $handler->display->display_options['relationships']['field_image_fid']['id'] = 'field_image_fid';
  $handler->display->display_options['relationships']['field_image_fid']['table'] = 'field_data_field_image';
  $handler->display->display_options['relationships']['field_image_fid']['field'] = 'field_image_fid';
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
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department']['id'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_department']['alter']['text'] = '[field_department-tid] ';
  $handler->display->display_options['fields']['field_department']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_department']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_department']['separator'] = '|';
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
  /* Field: Content: Caption */
  $handler->display->display_options['fields']['field_caption']['id'] = 'field_caption';
  $handler->display->display_options['fields']['field_caption']['table'] = 'field_data_field_caption';
  $handler->display->display_options['fields']['field_caption']['field'] = 'field_caption';
  /* Field: Content: Link Text */
  $handler->display->display_options['fields']['field_link_text']['id'] = 'field_link_text';
  $handler->display->display_options['fields']['field_link_text']['table'] = 'field_data_field_link_text';
  $handler->display->display_options['fields']['field_link_text']['field'] = 'field_link_text';
  $handler->display->display_options['fields']['field_link_text']['type'] = 'text_plain';
  /* Field: Content: Link URL */
  $handler->display->display_options['fields']['field_link_url']['id'] = 'field_link_url';
  $handler->display->display_options['fields']['field_link_url']['table'] = 'field_data_field_link_url';
  $handler->display->display_options['fields']['field_link_url']['field'] = 'field_link_url';
  $handler->display->display_options['fields']['field_link_url']['type'] = 'text_plain';
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['link_to_node'] = FALSE;
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
    'slide' => 'slide',
  );
  $handler->display->display_options['filters']['type']['expose']['operator_id'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['label'] = 'Type';
  $handler->display->display_options['filters']['type']['expose']['operator'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['identifier'] = 'type';
  $handler->display->display_options['path'] = 'migration/slides';
  $handler->display->display_options['use_batch'] = 'batch';
  $handler->display->display_options['segment_size'] = '100';

  /* Display: Data export 7 */
  $handler = $view->new_display('views_data_export', 'Data export 7', 'views_data_export_7');
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
  $handler->display->display_options['defaults']['relationships'] = FALSE;
  /* Relationship: Content: Photo (field_ma_photo:fid) */
  $handler->display->display_options['relationships']['field_ma_photo_fid']['id'] = 'field_ma_photo_fid';
  $handler->display->display_options['relationships']['field_ma_photo_fid']['table'] = 'field_data_field_ma_photo';
  $handler->display->display_options['relationships']['field_ma_photo_fid']['field'] = 'field_ma_photo_fid';
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
  $handler->display->display_options['fields']['field_department_1']['relationship'] = 'field_ma_photo_fid';
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
  $handler->display->display_options['fields']['field_license']['relationship'] = 'field_ma_photo_fid';
  $handler->display->display_options['fields']['field_license']['label'] = 'Image License settings for this file';
  $handler->display->display_options['fields']['field_license']['type'] = 'list_key';
  /* Field: File: Alt Text */
  $handler->display->display_options['fields']['field_file_image_alt_text']['id'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['table'] = 'field_data_field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['field'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['relationship'] = 'field_ma_photo_fid';
  $handler->display->display_options['fields']['field_file_image_alt_text']['label'] = 'Image Alt Text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['type'] = 'text_plain';
  /* Field: File: File ID */
  $handler->display->display_options['fields']['fid']['id'] = 'fid';
  $handler->display->display_options['fields']['fid']['table'] = 'file_managed';
  $handler->display->display_options['fields']['fid']['field'] = 'fid';
  $handler->display->display_options['fields']['fid']['relationship'] = 'field_ma_photo_fid';
  $handler->display->display_options['fields']['fid']['label'] = 'Image File ID';
  /* Field: File: Path */
  $handler->display->display_options['fields']['uri']['id'] = 'uri';
  $handler->display->display_options['fields']['uri']['table'] = 'file_managed';
  $handler->display->display_options['fields']['uri']['field'] = 'uri';
  $handler->display->display_options['fields']['uri']['relationship'] = 'field_ma_photo_fid';
  $handler->display->display_options['fields']['uri']['label'] = 'Image Path';
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['link_to_node'] = FALSE;
  /* Field: Content: Body */
  $handler->display->display_options['fields']['body']['id'] = 'body';
  $handler->display->display_options['fields']['body']['table'] = 'field_data_body';
  $handler->display->display_options['fields']['body']['field'] = 'body';
  /* Field: Content: Date of Photo */
  $handler->display->display_options['fields']['field_ma_photo_date']['id'] = 'field_ma_photo_date';
  $handler->display->display_options['fields']['field_ma_photo_date']['table'] = 'field_data_field_ma_photo_date';
  $handler->display->display_options['fields']['field_ma_photo_date']['field'] = 'field_ma_photo_date';
  $handler->display->display_options['fields']['field_ma_photo_date']['type'] = 'text_plain';
  /* Field: Content: Keywords */
  $handler->display->display_options['fields']['field_ma_keywords']['id'] = 'field_ma_keywords';
  $handler->display->display_options['fields']['field_ma_keywords']['table'] = 'field_data_field_ma_keywords';
  $handler->display->display_options['fields']['field_ma_keywords']['field'] = 'field_ma_keywords';
  $handler->display->display_options['fields']['field_ma_keywords']['type'] = 'text_plain';
  /* Field: Content: Location */
  $handler->display->display_options['fields']['field_ma_location']['id'] = 'field_ma_location';
  $handler->display->display_options['fields']['field_ma_location']['table'] = 'field_data_field_ma_location';
  $handler->display->display_options['fields']['field_ma_location']['field'] = 'field_ma_location';
  $handler->display->display_options['fields']['field_ma_location']['type'] = 'text_plain';
  /* Field: Content: Mayor */
  $handler->display->display_options['fields']['field_ma_mayor']['id'] = 'field_ma_mayor';
  $handler->display->display_options['fields']['field_ma_mayor']['table'] = 'field_data_field_ma_mayor';
  $handler->display->display_options['fields']['field_ma_mayor']['field'] = 'field_ma_mayor';
  $handler->display->display_options['fields']['field_ma_mayor']['type'] = 'list_key';
  /* Field: Content: Record ID */
  $handler->display->display_options['fields']['field_ma_record_id']['id'] = 'field_ma_record_id';
  $handler->display->display_options['fields']['field_ma_record_id']['table'] = 'field_data_field_ma_record_id';
  $handler->display->display_options['fields']['field_ma_record_id']['field'] = 'field_ma_record_id';
  $handler->display->display_options['fields']['field_ma_record_id']['type'] = 'text_plain';
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
    'mayoral_artifacts' => 'mayoral_artifacts',
  );
  $handler->display->display_options['filters']['type']['expose']['operator_id'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['label'] = 'Type';
  $handler->display->display_options['filters']['type']['expose']['operator'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['identifier'] = 'type';
  $handler->display->display_options['path'] = 'migration/mayoral-artifacts';
  $handler->display->display_options['use_batch'] = 'batch';
  $handler->display->display_options['segment_size'] = '100';

  /* Display: Data export 8 */
  $handler = $view->new_display('views_data_export', 'Data export 8', 'views_data_export_8');
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
  $handler->display->display_options['style_options']['keep_html'] = 0;
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
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department']['id'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_department']['alter']['text'] = '[field_department-tid]';
  $handler->display->display_options['fields']['field_department']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_department']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_department']['separator'] = '|';
  /* Field: Field: Search KeyMatch */
  $handler->display->display_options['fields']['field_search_keymatch']['id'] = 'field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['table'] = 'field_data_field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['field'] = 'field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_search_keymatch']['alter']['text'] = '[field_search_keymatch-tid]';
  $handler->display->display_options['fields']['field_search_keymatch']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_search_keymatch']['separator'] = '|';
  /* Field: Content: Sections */
  $handler->display->display_options['fields']['field_outreach_sections_coll']['id'] = 'field_outreach_sections_coll';
  $handler->display->display_options['fields']['field_outreach_sections_coll']['table'] = 'field_data_field_outreach_sections_coll';
  $handler->display->display_options['fields']['field_outreach_sections_coll']['field'] = 'field_outreach_sections_coll';
  $handler->display->display_options['fields']['field_outreach_sections_coll']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_outreach_sections_coll']['alter']['text'] = '[field_outreach_sections_coll-value]';
  $handler->display->display_options['fields']['field_outreach_sections_coll']['type'] = 'field_collection_fields';
  $handler->display->display_options['fields']['field_outreach_sections_coll']['settings'] = array(
    'view_mode' => 'full',
  );
  $handler->display->display_options['fields']['field_outreach_sections_coll']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_outreach_sections_coll']['separator'] = '|';
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['link_to_node'] = FALSE;
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
    'outreach' => 'outreach',
  );
  $handler->display->display_options['filters']['type']['expose']['operator_id'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['label'] = 'Type';
  $handler->display->display_options['filters']['type']['expose']['operator'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['identifier'] = 'type';
  $handler->display->display_options['path'] = 'migration/outreach';
  $handler->display->display_options['use_batch'] = 'batch';
  $handler->display->display_options['segment_size'] = '100';

  /* Display: Data export 9 */
  $handler = $view->new_display('views_data_export', 'Data export 9', 'views_data_export_9');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['defaults']['relationships'] = FALSE;
  /* Relationship: Content: Image (field_hero_image:fid) */
  $handler->display->display_options['relationships']['field_hero_image_fid']['id'] = 'field_hero_image_fid';
  $handler->display->display_options['relationships']['field_hero_image_fid']['table'] = 'field_data_field_hero_image';
  $handler->display->display_options['relationships']['field_hero_image_fid']['field'] = 'field_hero_image_fid';
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Content: Nid */
  $handler->display->display_options['fields']['nid']['id'] = 'nid';
  $handler->display->display_options['fields']['nid']['table'] = 'node';
  $handler->display->display_options['fields']['nid']['field'] = 'nid';
  $handler->display->display_options['fields']['nid']['label'] = 'D7 ID';
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department']['id'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_department']['alter']['text'] = '[field_department-tid]';
  $handler->display->display_options['fields']['field_department']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_department']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_department']['separator'] = '|';
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department_1']['id'] = 'field_department_1';
  $handler->display->display_options['fields']['field_department_1']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department_1']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department_1']['relationship'] = 'field_hero_image_fid';
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
  $handler->display->display_options['fields']['field_license']['relationship'] = 'field_hero_image_fid';
  $handler->display->display_options['fields']['field_license']['label'] = 'Image License settings for this file';
  $handler->display->display_options['fields']['field_license']['type'] = 'list_key';
  /* Field: File: Alt Text */
  $handler->display->display_options['fields']['field_file_image_alt_text']['id'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['table'] = 'field_data_field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['field'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['relationship'] = 'field_hero_image_fid';
  $handler->display->display_options['fields']['field_file_image_alt_text']['label'] = 'Image Alt Text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['type'] = 'text_plain';
  /* Field: File: File ID */
  $handler->display->display_options['fields']['fid']['id'] = 'fid';
  $handler->display->display_options['fields']['fid']['table'] = 'file_managed';
  $handler->display->display_options['fields']['fid']['field'] = 'fid';
  $handler->display->display_options['fields']['fid']['relationship'] = 'field_hero_image_fid';
  $handler->display->display_options['fields']['fid']['label'] = 'Image File ID';
  /* Field: File: Path */
  $handler->display->display_options['fields']['uri']['id'] = 'uri';
  $handler->display->display_options['fields']['uri']['table'] = 'file_managed';
  $handler->display->display_options['fields']['uri']['field'] = 'uri';
  $handler->display->display_options['fields']['uri']['relationship'] = 'field_hero_image_fid';
  $handler->display->display_options['fields']['uri']['label'] = 'Image Path';
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['link_to_node'] = FALSE;
  /* Field: Content: Caption */
  $handler->display->display_options['fields']['field_hero_caption']['id'] = 'field_hero_caption';
  $handler->display->display_options['fields']['field_hero_caption']['table'] = 'field_data_field_hero_caption';
  $handler->display->display_options['fields']['field_hero_caption']['field'] = 'field_hero_caption';
  $handler->display->display_options['fields']['field_hero_caption']['type'] = 'text_plain';
  /* Field: Content: Image by */
  $handler->display->display_options['fields']['field_hero_image_by']['id'] = 'field_hero_image_by';
  $handler->display->display_options['fields']['field_hero_image_by']['table'] = 'field_data_field_hero_image_by';
  $handler->display->display_options['fields']['field_hero_image_by']['field'] = 'field_hero_image_by';
  $handler->display->display_options['fields']['field_hero_image_by']['type'] = 'text_plain';
  /* Field: Content: Prefix Image by */
  $handler->display->display_options['fields']['field_hero_image_by_prefix']['id'] = 'field_hero_image_by_prefix';
  $handler->display->display_options['fields']['field_hero_image_by_prefix']['table'] = 'field_data_field_hero_image_by_prefix';
  $handler->display->display_options['fields']['field_hero_image_by_prefix']['field'] = 'field_hero_image_by_prefix';
  $handler->display->display_options['fields']['field_hero_image_by_prefix']['type'] = 'text_plain';
  /* Field: Content: Sitewide */
  $handler->display->display_options['fields']['field_hero_sitewide']['id'] = 'field_hero_sitewide';
  $handler->display->display_options['fields']['field_hero_sitewide']['table'] = 'field_data_field_hero_sitewide';
  $handler->display->display_options['fields']['field_hero_sitewide']['field'] = 'field_hero_sitewide';
  $handler->display->display_options['fields']['field_hero_sitewide']['type'] = 'list_key';
  /* Field: Content: Time of Day */
  $handler->display->display_options['fields']['field_hero_time_of_day']['id'] = 'field_hero_time_of_day';
  $handler->display->display_options['fields']['field_hero_time_of_day']['table'] = 'field_data_field_hero_time_of_day';
  $handler->display->display_options['fields']['field_hero_time_of_day']['field'] = 'field_hero_time_of_day';
  $handler->display->display_options['fields']['field_hero_time_of_day']['type'] = 'list_key';
  /* Field: Content: Use on Home Page of City of San Diego */
  $handler->display->display_options['fields']['field_hero_frontpage']['id'] = 'field_hero_frontpage';
  $handler->display->display_options['fields']['field_hero_frontpage']['table'] = 'field_data_field_hero_frontpage';
  $handler->display->display_options['fields']['field_hero_frontpage']['field'] = 'field_hero_frontpage';
  $handler->display->display_options['fields']['field_hero_frontpage']['type'] = 'list_key';
  /* Field: Content: Vimeo URL */
  $handler->display->display_options['fields']['field_vimeo_url']['id'] = 'field_vimeo_url';
  $handler->display->display_options['fields']['field_vimeo_url']['table'] = 'field_data_field_vimeo_url';
  $handler->display->display_options['fields']['field_vimeo_url']['field'] = 'field_vimeo_url';
  $handler->display->display_options['fields']['field_vimeo_url']['type'] = 'text_plain';
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
    'hero' => 'hero',
  );
  $handler->display->display_options['filters']['type']['expose']['operator_id'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['label'] = 'Type';
  $handler->display->display_options['filters']['type']['expose']['operator'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['identifier'] = 'type';
  $handler->display->display_options['path'] = 'migration/hero';

  /* Display: Data export 10 */
  $handler = $view->new_display('views_data_export', 'Data export 10', 'views_data_export_10');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['style_options']['provide_file'] = 0;
  $handler->display->display_options['style_options']['parent_sort'] = 0;
  $handler->display->display_options['style_options']['quote'] = 1;
  $handler->display->display_options['style_options']['trim'] = 1;
  $handler->display->display_options['style_options']['replace_newlines'] = 0;
  $handler->display->display_options['style_options']['newline_token'] = '1';
  $handler->display->display_options['style_options']['header'] = 1;
  $handler->display->display_options['style_options']['keep_html'] = 1;
  $handler->display->display_options['defaults']['relationships'] = FALSE;
  /* Relationship: Content: Attachment (field_attachment:fid) */
  $handler->display->display_options['relationships']['field_attachment_fid']['id'] = 'field_attachment_fid';
  $handler->display->display_options['relationships']['field_attachment_fid']['table'] = 'field_data_field_attachment';
  $handler->display->display_options['relationships']['field_attachment_fid']['field'] = 'field_attachment_fid';
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Content: Nid */
  $handler->display->display_options['fields']['nid']['id'] = 'nid';
  $handler->display->display_options['fields']['nid']['table'] = 'node';
  $handler->display->display_options['fields']['nid']['field'] = 'nid';
  $handler->display->display_options['fields']['nid']['label'] = 'D7 ID';
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department']['id'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_department']['alter']['text'] = '[field_department-tid]';
  $handler->display->display_options['fields']['field_department']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_department']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_department']['separator'] = '|';
  /* Field: Content: Category */
  $handler->display->display_options['fields']['field_category']['id'] = 'field_category';
  $handler->display->display_options['fields']['field_category']['table'] = 'field_data_field_category';
  $handler->display->display_options['fields']['field_category']['field'] = 'field_category';
  $handler->display->display_options['fields']['field_category']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_category']['alter']['text'] = '[field_category-tid]';
  $handler->display->display_options['fields']['field_category']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_category']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_category']['separator'] = '|';
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['link_to_node'] = FALSE;
  /* Field: Content: Body */
  $handler->display->display_options['fields']['body']['id'] = 'body';
  $handler->display->display_options['fields']['body']['table'] = 'field_data_body';
  $handler->display->display_options['fields']['body']['field'] = 'body';
  $handler->display->display_options['fields']['body']['alter']['trim_whitespace'] = TRUE;
  /* Field: File: Path */
  $handler->display->display_options['fields']['uri']['id'] = 'uri';
  $handler->display->display_options['fields']['uri']['table'] = 'file_managed';
  $handler->display->display_options['fields']['uri']['field'] = 'uri';
  $handler->display->display_options['fields']['uri']['relationship'] = 'field_attachment_fid';
  /* Field: Content: Display Body in Feeds */
  $handler->display->display_options['fields']['field_display_body']['id'] = 'field_display_body';
  $handler->display->display_options['fields']['field_display_body']['table'] = 'field_data_field_display_body';
  $handler->display->display_options['fields']['field_display_body']['field'] = 'field_display_body';
  $handler->display->display_options['fields']['field_display_body']['type'] = 'list_key';
  /* Field: Content: Edit Notes */
  $handler->display->display_options['fields']['field_edit_notes']['id'] = 'field_edit_notes';
  $handler->display->display_options['fields']['field_edit_notes']['table'] = 'field_data_field_edit_notes';
  $handler->display->display_options['fields']['field_edit_notes']['field'] = 'field_edit_notes';
  /* Field: Content: Icon */
  $handler->display->display_options['fields']['field_dept_doc_icon']['id'] = 'field_dept_doc_icon';
  $handler->display->display_options['fields']['field_dept_doc_icon']['table'] = 'field_data_field_dept_doc_icon';
  $handler->display->display_options['fields']['field_dept_doc_icon']['field'] = 'field_dept_doc_icon';
  /* Field: Content: ID */
  $handler->display->display_options['fields']['field_dept_doc_id']['id'] = 'field_dept_doc_id';
  $handler->display->display_options['fields']['field_dept_doc_id']['table'] = 'field_data_field_dept_doc_id';
  $handler->display->display_options['fields']['field_dept_doc_id']['field'] = 'field_dept_doc_id';
  /* Field: Content: Keywords */
  $handler->display->display_options['fields']['field_dept_doc_keywords']['id'] = 'field_dept_doc_keywords';
  $handler->display->display_options['fields']['field_dept_doc_keywords']['table'] = 'field_data_field_dept_doc_keywords';
  $handler->display->display_options['fields']['field_dept_doc_keywords']['field'] = 'field_dept_doc_keywords';
  $handler->display->display_options['fields']['field_dept_doc_keywords']['type'] = 'text_trimmed';
  $handler->display->display_options['fields']['field_dept_doc_keywords']['settings'] = array(
    'trim_length' => '255',
  );
  /* Field: Content: Promote to Front Page */
  $handler->display->display_options['fields']['field_promote_to_city_home']['id'] = 'field_promote_to_city_home';
  $handler->display->display_options['fields']['field_promote_to_city_home']['table'] = 'field_data_field_promote_to_city_home';
  $handler->display->display_options['fields']['field_promote_to_city_home']['field'] = 'field_promote_to_city_home';
  $handler->display->display_options['fields']['field_promote_to_city_home']['type'] = 'list_key';
  /* Field: Content: Replace Body text with Source URL text, on Save */
  $handler->display->display_options['fields']['field_replace_body_text_with_att']['id'] = 'field_replace_body_text_with_att';
  $handler->display->display_options['fields']['field_replace_body_text_with_att']['table'] = 'field_data_field_replace_body_text_with_att';
  $handler->display->display_options['fields']['field_replace_body_text_with_att']['field'] = 'field_replace_body_text_with_att';
  $handler->display->display_options['fields']['field_replace_body_text_with_att']['type'] = 'list_key';
  /* Field: Content: Source URL */
  $handler->display->display_options['fields']['field_dept_doc_url']['id'] = 'field_dept_doc_url';
  $handler->display->display_options['fields']['field_dept_doc_url']['table'] = 'field_data_field_dept_doc_url';
  $handler->display->display_options['fields']['field_dept_doc_url']['field'] = 'field_dept_doc_url';
  /* Field: Field: Search KeyMatch */
  $handler->display->display_options['fields']['field_search_keymatch']['id'] = 'field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['table'] = 'field_data_field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['field'] = 'field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['alter']['text'] = '[field_search_keymatch-tid]';
  $handler->display->display_options['fields']['field_search_keymatch']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_search_keymatch']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_search_keymatch']['separator'] = '|';
  /* Field: Content: Path */
  $handler->display->display_options['fields']['path']['id'] = 'path';
  $handler->display->display_options['fields']['path']['table'] = 'node';
  $handler->display->display_options['fields']['path']['field'] = 'path';
  $handler->display->display_options['fields']['path']['label'] = 'Alias';
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
    'department_document' => 'department_document',
  );
  $handler->display->display_options['filters']['type']['expose']['operator_id'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['label'] = 'Type';
  $handler->display->display_options['filters']['type']['expose']['operator'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['identifier'] = 'type';
  $handler->display->display_options['path'] = 'migration/department_document';
  $handler->display->display_options['use_batch'] = 'batch';
  $handler->display->display_options['segment_size'] = '100';

  /* Display: Data export 11 */
  $handler = $view->new_display('views_data_export', 'Data export 11', 'views_data_export_11');
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
  $handler->display->display_options['defaults']['relationships'] = FALSE;
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Content: Nid */
  $handler->display->display_options['fields']['nid']['id'] = 'nid';
  $handler->display->display_options['fields']['nid']['table'] = 'node';
  $handler->display->display_options['fields']['nid']['field'] = 'nid';
  $handler->display->display_options['fields']['nid']['label'] = 'D7 ID';
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department']['id'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_department']['alter']['text'] = '[field_department-tid]';
  $handler->display->display_options['fields']['field_department']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_department']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_department']['separator'] = '|';
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['link_to_node'] = FALSE;
  /* Field: Field: Search KeyMatch */
  $handler->display->display_options['fields']['field_search_keymatch']['id'] = 'field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['table'] = 'field_data_field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['field'] = 'field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_search_keymatch']['alter']['text'] = '[field_search_keymatch-tid]';
  $handler->display->display_options['fields']['field_search_keymatch']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_search_keymatch']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_search_keymatch']['separator'] = '|';
  /* Field: Content: Sections */
  $handler->display->display_options['fields']['field_outreach_sections_coll2']['id'] = 'field_outreach_sections_coll2';
  $handler->display->display_options['fields']['field_outreach_sections_coll2']['table'] = 'field_data_field_outreach_sections_coll2';
  $handler->display->display_options['fields']['field_outreach_sections_coll2']['field'] = 'field_outreach_sections_coll2';
  $handler->display->display_options['fields']['field_outreach_sections_coll2']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_outreach_sections_coll2']['alter']['text'] = '[field_outreach_sections_coll2-revision_id]';
  $handler->display->display_options['fields']['field_outreach_sections_coll2']['type'] = 'field_collection_fields';
  $handler->display->display_options['fields']['field_outreach_sections_coll2']['settings'] = array(
    'view_mode' => 'full',
  );
  $handler->display->display_options['fields']['field_outreach_sections_coll2']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_outreach_sections_coll2']['separator'] = '|';
  /* Field: Content: Edit Notes */
  $handler->display->display_options['fields']['field_edit_notes']['id'] = 'field_edit_notes';
  $handler->display->display_options['fields']['field_edit_notes']['table'] = 'field_data_field_edit_notes';
  $handler->display->display_options['fields']['field_edit_notes']['field'] = 'field_edit_notes';
  /* Field: Content: Outreach Version */
  $handler->display->display_options['fields']['field_outreach_version']['id'] = 'field_outreach_version';
  $handler->display->display_options['fields']['field_outreach_version']['table'] = 'field_data_field_outreach_version';
  $handler->display->display_options['fields']['field_outreach_version']['field'] = 'field_outreach_version';
  $handler->display->display_options['fields']['field_outreach_version']['type'] = 'list_key';
  /* Field: Content: Page Footer Type */
  $handler->display->display_options['fields']['field_outreach_footer_type']['id'] = 'field_outreach_footer_type';
  $handler->display->display_options['fields']['field_outreach_footer_type']['table'] = 'field_data_field_outreach_footer_type';
  $handler->display->display_options['fields']['field_outreach_footer_type']['field'] = 'field_outreach_footer_type';
  $handler->display->display_options['fields']['field_outreach_footer_type']['type'] = 'list_key';
  /* Field: Content: Page Header Type */
  $handler->display->display_options['fields']['field_outreach_header_type']['id'] = 'field_outreach_header_type';
  $handler->display->display_options['fields']['field_outreach_header_type']['table'] = 'field_data_field_outreach_header_type';
  $handler->display->display_options['fields']['field_outreach_header_type']['field'] = 'field_outreach_header_type';
  $handler->display->display_options['fields']['field_outreach_header_type']['type'] = 'list_key';
  /* Field: Content: Path */
  $handler->display->display_options['fields']['path']['id'] = 'path';
  $handler->display->display_options['fields']['path']['table'] = 'node';
  $handler->display->display_options['fields']['path']['field'] = 'path';
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
    'outreach2' => 'outreach2',
  );
  $handler->display->display_options['filters']['type']['expose']['operator_id'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['label'] = 'Type';
  $handler->display->display_options['filters']['type']['expose']['operator'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['identifier'] = 'type';
  $handler->display->display_options['path'] = 'migration/outreach2';
  $handler->display->display_options['use_batch'] = 'batch';
  $handler->display->display_options['segment_size'] = '100';

  /* Display: Data export 12 */
  $handler = $view->new_display('views_data_export', 'Data export 12', 'views_data_export_12');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '110000';
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
  /* Relationship: Content: PDF (field_pdf:fid) */
  $handler->display->display_options['relationships']['field_pdf_fid']['id'] = 'field_pdf_fid';
  $handler->display->display_options['relationships']['field_pdf_fid']['table'] = 'field_data_field_pdf';
  $handler->display->display_options['relationships']['field_pdf_fid']['field'] = 'field_pdf_fid';
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Content: Nid */
  $handler->display->display_options['fields']['nid']['id'] = 'nid';
  $handler->display->display_options['fields']['nid']['table'] = 'node';
  $handler->display->display_options['fields']['nid']['field'] = 'nid';
  $handler->display->display_options['fields']['nid']['label'] = 'D7 ID';
  /* Field: Field: Search KeyMatch */
  $handler->display->display_options['fields']['field_search_keymatch']['id'] = 'field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['table'] = 'field_data_field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['field'] = 'field_search_keymatch';
  $handler->display->display_options['fields']['field_search_keymatch']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_search_keymatch']['alter']['text'] = '[field_search_keymatch-tid]';
  $handler->display->display_options['fields']['field_search_keymatch']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_search_keymatch']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_search_keymatch']['separator'] = '|';
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['link_to_node'] = FALSE;
  /* Field: Content: A WebC URL */
  $handler->display->display_options['fields']['field_a_webc_url']['id'] = 'field_a_webc_url';
  $handler->display->display_options['fields']['field_a_webc_url']['table'] = 'field_data_field_a_webc_url';
  $handler->display->display_options['fields']['field_a_webc_url']['field'] = 'field_a_webc_url';
  /* Field: Content: Action */
  $handler->display->display_options['fields']['field_action']['id'] = 'field_action';
  $handler->display->display_options['fields']['field_action']['table'] = 'field_data_field_action';
  $handler->display->display_options['fields']['field_action']['field'] = 'field_action';
  /* Field: Content: Back Date */
  $handler->display->display_options['fields']['field_back_date']['id'] = 'field_back_date';
  $handler->display->display_options['fields']['field_back_date']['table'] = 'field_data_field_back_date';
  $handler->display->display_options['fields']['field_back_date']['field'] = 'field_back_date';
  $handler->display->display_options['fields']['field_back_date']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_back_date']['alter']['text'] = '[field_back_date-value]';
  $handler->display->display_options['fields']['field_back_date']['element_default_classes'] = FALSE;
  $handler->display->display_options['fields']['field_back_date']['settings'] = array(
    'format_type' => 'year_month_day_time',
    'custom_date_format' => 'Y-m-d',
    'fromto' => 'both',
    'multiple_number' => '',
    'multiple_from' => '',
    'multiple_to' => '',
    'show_remaining_days' => 0,
    'show_repeat_rule' => 'show',
  );
  /* Field: Content: Body */
  $handler->display->display_options['fields']['body']['id'] = 'body';
  $handler->display->display_options['fields']['body']['table'] = 'field_data_body';
  $handler->display->display_options['fields']['body']['field'] = 'body';
  $handler->display->display_options['fields']['body']['alter']['trim_whitespace'] = TRUE;
  /* Field: Content: Body Status */
  $handler->display->display_options['fields']['field_body_status']['id'] = 'field_body_status';
  $handler->display->display_options['fields']['field_body_status']['table'] = 'field_data_field_body_status';
  $handler->display->display_options['fields']['field_body_status']['field'] = 'field_body_status';
  /* Field: Content: Committee */
  $handler->display->display_options['fields']['field_committee']['id'] = 'field_committee';
  $handler->display->display_options['fields']['field_committee']['table'] = 'field_data_field_committee';
  $handler->display->display_options['fields']['field_committee']['field'] = 'field_committee';
  $handler->display->display_options['fields']['field_committee']['type'] = 'list_key';
  /* Field: Content: Doc Date */
  $handler->display->display_options['fields']['field_doc_date']['id'] = 'field_doc_date';
  $handler->display->display_options['fields']['field_doc_date']['table'] = 'field_data_field_doc_date';
  $handler->display->display_options['fields']['field_doc_date']['field'] = 'field_doc_date';
  $handler->display->display_options['fields']['field_doc_date']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_doc_date']['alter']['text'] = '[field_doc_date-value] ';
  $handler->display->display_options['fields']['field_doc_date']['element_default_classes'] = FALSE;
  $handler->display->display_options['fields']['field_doc_date']['settings'] = array(
    'format_type' => 'year_month_day_time',
    'custom_date_format' => 'Y-m-d',
    'fromto' => 'both',
    'multiple_number' => '',
    'multiple_from' => '',
    'multiple_to' => '',
    'show_remaining_days' => 0,
    'show_repeat_rule' => 'show',
  );
  /* Field: Content: Doc Date Num */
  $handler->display->display_options['fields']['field_doc_date_num']['id'] = 'field_doc_date_num';
  $handler->display->display_options['fields']['field_doc_date_num']['table'] = 'field_data_field_doc_date_num';
  $handler->display->display_options['fields']['field_doc_date_num']['field'] = 'field_doc_date_num';
  /* Field: Content: Doc Date Year */
  $handler->display->display_options['fields']['field_doc_date_year']['id'] = 'field_doc_date_year';
  $handler->display->display_options['fields']['field_doc_date_year']['table'] = 'field_data_field_doc_date_year';
  $handler->display->display_options['fields']['field_doc_date_year']['field'] = 'field_doc_date_year';
  /* Field: Content: Doc Num */
  $handler->display->display_options['fields']['field_doc_num']['id'] = 'field_doc_num';
  $handler->display->display_options['fields']['field_doc_num']['table'] = 'field_data_field_doc_num';
  $handler->display->display_options['fields']['field_doc_num']['field'] = 'field_doc_num';
  /* Field: Content: Doc Set */
  $handler->display->display_options['fields']['field_doc_set']['id'] = 'field_doc_set';
  $handler->display->display_options['fields']['field_doc_set']['table'] = 'field_data_field_doc_set';
  $handler->display->display_options['fields']['field_doc_set']['field'] = 'field_doc_set';
  /* Field: Content: Doc Type */
  $handler->display->display_options['fields']['field_doc_type']['id'] = 'field_doc_type';
  $handler->display->display_options['fields']['field_doc_type']['table'] = 'field_data_field_doc_type';
  $handler->display->display_options['fields']['field_doc_type']['field'] = 'field_doc_type';
  $handler->display->display_options['fields']['field_doc_type']['type'] = 'list_key';
  /* Field: Content: Document URL */
  $handler->display->display_options['fields']['field_document_url']['id'] = 'field_document_url';
  $handler->display->display_options['fields']['field_document_url']['table'] = 'field_data_field_document_url';
  $handler->display->display_options['fields']['field_document_url']['field'] = 'field_document_url';
  /* Field: Content: Flag Color */
  $handler->display->display_options['fields']['field_flag_color']['id'] = 'field_flag_color';
  $handler->display->display_options['fields']['field_flag_color']['table'] = 'field_data_field_flag_color';
  $handler->display->display_options['fields']['field_flag_color']['field'] = 'field_flag_color';
  /* Field: Content: Flag Text */
  $handler->display->display_options['fields']['field_flag_text']['id'] = 'field_flag_text';
  $handler->display->display_options['fields']['field_flag_text']['table'] = 'field_data_field_flag_text';
  $handler->display->display_options['fields']['field_flag_text']['field'] = 'field_flag_text';
  /* Field: Content: Import Date */
  $handler->display->display_options['fields']['field_import_date']['id'] = 'field_import_date';
  $handler->display->display_options['fields']['field_import_date']['table'] = 'field_data_field_import_date';
  $handler->display->display_options['fields']['field_import_date']['field'] = 'field_import_date';
  $handler->display->display_options['fields']['field_import_date']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_import_date']['alter']['text'] = '[field_import_date-value]';
  $handler->display->display_options['fields']['field_import_date']['element_default_classes'] = FALSE;
  $handler->display->display_options['fields']['field_import_date']['settings'] = array(
    'format_type' => 'year_month_day_time',
    'custom_date_format' => 'Y-m-d',
    'fromto' => 'both',
    'multiple_number' => '',
    'multiple_from' => '',
    'multiple_to' => '',
    'show_remaining_days' => 0,
    'show_repeat_rule' => 'show',
  );
  /* Field: Content: Internal Notes */
  $handler->display->display_options['fields']['field_internal_notes']['id'] = 'field_internal_notes';
  $handler->display->display_options['fields']['field_internal_notes']['table'] = 'field_data_field_internal_notes';
  $handler->display->display_options['fields']['field_internal_notes']['field'] = 'field_internal_notes';
  /* Field: Content: Muni Code Chapter */
  $handler->display->display_options['fields']['field_muni_code_chapter']['id'] = 'field_muni_code_chapter';
  $handler->display->display_options['fields']['field_muni_code_chapter']['table'] = 'field_data_field_muni_code_chapter';
  $handler->display->display_options['fields']['field_muni_code_chapter']['field'] = 'field_muni_code_chapter';
  $handler->display->display_options['fields']['field_muni_code_chapter']['type'] = 'list_key';
  /* Field: Content: Object Name */
  $handler->display->display_options['fields']['field_object_name']['id'] = 'field_object_name';
  $handler->display->display_options['fields']['field_object_name']['table'] = 'field_data_field_object_name';
  $handler->display->display_options['fields']['field_object_name']['field'] = 'field_object_name';
  /* Field: Content: Path */
  $handler->display->display_options['fields']['field_path']['id'] = 'field_path';
  $handler->display->display_options['fields']['field_path']['table'] = 'field_data_field_path';
  $handler->display->display_options['fields']['field_path']['field'] = 'field_path';
  /* Field: Content: PN Category */
  $handler->display->display_options['fields']['field_pn_category']['id'] = 'field_pn_category';
  $handler->display->display_options['fields']['field_pn_category']['table'] = 'field_data_field_pn_category';
  $handler->display->display_options['fields']['field_pn_category']['field'] = 'field_pn_category';
  /* Field: Content: PN Comm Plan Group */
  $handler->display->display_options['fields']['field_pn_comm_plan_group']['id'] = 'field_pn_comm_plan_group';
  $handler->display->display_options['fields']['field_pn_comm_plan_group']['table'] = 'field_data_field_pn_comm_plan_group';
  $handler->display->display_options['fields']['field_pn_comm_plan_group']['field'] = 'field_pn_comm_plan_group';
  /* Field: Content: PN Council District */
  $handler->display->display_options['fields']['field_pn_council_district']['id'] = 'field_pn_council_district';
  $handler->display->display_options['fields']['field_pn_council_district']['table'] = 'field_data_field_pn_council_district';
  $handler->display->display_options['fields']['field_pn_council_district']['field'] = 'field_pn_council_district';
  /* Field: Content: PN End Date */
  $handler->display->display_options['fields']['field_pn_end_date']['id'] = 'field_pn_end_date';
  $handler->display->display_options['fields']['field_pn_end_date']['table'] = 'field_data_field_pn_end_date';
  $handler->display->display_options['fields']['field_pn_end_date']['field'] = 'field_pn_end_date';
  /* Field: Content: PN End Date Date */
  $handler->display->display_options['fields']['field_pn_end_date_date']['id'] = 'field_pn_end_date_date';
  $handler->display->display_options['fields']['field_pn_end_date_date']['table'] = 'field_data_field_pn_end_date_date';
  $handler->display->display_options['fields']['field_pn_end_date_date']['field'] = 'field_pn_end_date_date';
  $handler->display->display_options['fields']['field_pn_end_date_date']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_pn_end_date_date']['alter']['text'] = '[field_pn_end_date_date-value]';
  $handler->display->display_options['fields']['field_pn_end_date_date']['element_default_classes'] = FALSE;
  $handler->display->display_options['fields']['field_pn_end_date_date']['settings'] = array(
    'format_type' => 'year_month_day_time',
    'custom_date_format' => 'Y-m-d',
    'fromto' => 'both',
    'multiple_number' => '',
    'multiple_from' => '',
    'multiple_to' => '',
    'show_remaining_days' => 0,
    'show_repeat_rule' => 'show',
  );
  /* Field: Content: R Modify Date */
  $handler->display->display_options['fields']['field_r_modify_date']['id'] = 'field_r_modify_date';
  $handler->display->display_options['fields']['field_r_modify_date']['table'] = 'field_data_field_r_modify_date';
  $handler->display->display_options['fields']['field_r_modify_date']['field'] = 'field_r_modify_date';
  $handler->display->display_options['fields']['field_r_modify_date']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_r_modify_date']['alter']['text'] = '[field_r_modify_date-value]';
  $handler->display->display_options['fields']['field_r_modify_date']['element_default_classes'] = FALSE;
  $handler->display->display_options['fields']['field_r_modify_date']['settings'] = array(
    'format_type' => 'year_month_day_time',
    'custom_date_format' => 'Y-m-d',
    'fromto' => 'both',
    'multiple_number' => '',
    'multiple_from' => '',
    'multiple_to' => '',
    'show_remaining_days' => 0,
    'show_repeat_rule' => 'show',
  );
  /* Field: Content: R Object ID */
  $handler->display->display_options['fields']['field_r_object_id']['id'] = 'field_r_object_id';
  $handler->display->display_options['fields']['field_r_object_id']['table'] = 'field_data_field_r_object_id';
  $handler->display->display_options['fields']['field_r_object_id']['field'] = 'field_r_object_id';
  /* Field: Content: Sort */
  $handler->display->display_options['fields']['field_sort1']['id'] = 'field_sort1';
  $handler->display->display_options['fields']['field_sort1']['table'] = 'field_data_field_sort1';
  $handler->display->display_options['fields']['field_sort1']['field'] = 'field_sort1';
  $handler->display->display_options['fields']['field_sort1']['settings'] = array(
    'thousand_separator' => '',
    'prefix_suffix' => 1,
  );
  /* Field: Content: Source */
  $handler->display->display_options['fields']['field_source']['id'] = 'field_source';
  $handler->display->display_options['fields']['field_source']['table'] = 'field_data_field_source';
  $handler->display->display_options['fields']['field_source']['field'] = 'field_source';
  /* Field: Content: Source Name */
  $handler->display->display_options['fields']['field_source_name']['id'] = 'field_source_name';
  $handler->display->display_options['fields']['field_source_name']['table'] = 'field_data_field_source_name';
  $handler->display->display_options['fields']['field_source_name']['field'] = 'field_source_name';
  /* Field: Content: Validated */
  $handler->display->display_options['fields']['field_validated']['id'] = 'field_validated';
  $handler->display->display_options['fields']['field_validated']['table'] = 'field_data_field_validated';
  $handler->display->display_options['fields']['field_validated']['field'] = 'field_validated';
  $handler->display->display_options['fields']['field_validated']['type'] = 'list_key';
  /* Field: File: Path */
  $handler->display->display_options['fields']['uri']['id'] = 'uri';
  $handler->display->display_options['fields']['uri']['table'] = 'file_managed';
  $handler->display->display_options['fields']['uri']['field'] = 'uri';
  $handler->display->display_options['fields']['uri']['relationship'] = 'field_pdf_fid';
  $handler->display->display_options['fields']['uri']['label'] = 'PDF Path';
  $handler->display->display_options['defaults']['sorts'] = FALSE;
  /* Sort criterion: Content: Nid */
  $handler->display->display_options['sorts']['nid']['id'] = 'nid';
  $handler->display->display_options['sorts']['nid']['table'] = 'node';
  $handler->display->display_options['sorts']['nid']['field'] = 'nid';
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
    'external_data' => 'external_data',
  );
  $handler->display->display_options['filters']['type']['expose']['operator_id'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['label'] = 'Type';
  $handler->display->display_options['filters']['type']['expose']['operator'] = 'type_op';
  $handler->display->display_options['filters']['type']['expose']['identifier'] = 'type';
  $handler->display->display_options['path'] = 'migration/external_data';
  $handler->display->display_options['use_batch'] = 'batch';
  $handler->display->display_options['segment_size'] = '100';
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
  $handler->display->display_options['fields']['item_id']['separator'] = '';
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
  $handler->display->display_options['fields']['item_id']['separator'] = '';
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
  $handler->display->display_options['fields']['item_id']['separator'] = '';
  /* Field: Field collection item: Section Title */
  $handler->display->display_options['fields']['field_featured_cards_title']['id'] = 'field_featured_cards_title';
  $handler->display->display_options['fields']['field_featured_cards_title']['table'] = 'field_data_field_featured_cards_title';
  $handler->display->display_options['fields']['field_featured_cards_title']['field'] = 'field_featured_cards_title';
  /* Field: Field collection item: Section Title URL */
  $handler->display->display_options['fields']['field_featured_cards_title_url']['id'] = 'field_featured_cards_title_url';
  $handler->display->display_options['fields']['field_featured_cards_title_url']['table'] = 'field_data_field_featured_cards_title_url';
  $handler->display->display_options['fields']['field_featured_cards_title_url']['field'] = 'field_featured_cards_title_url';
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
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Field collection item: Field name */
  $handler->display->display_options['filters']['field_name']['id'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['table'] = 'field_collection_item';
  $handler->display->display_options['filters']['field_name']['field'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['value'] = array(
    'field_bucket_featured_cards_coll' => 'field_bucket_featured_cards_coll',
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
  $handler->display->display_options['fields']['item_id']['separator'] = '';
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
  $handler->display->display_options['fields']['item_id']['separator'] = '';
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

  /* Display: Data export 6 */
  $handler = $view->new_display('views_data_export', 'Data export 6', 'views_data_export_6');
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '0';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['defaults']['relationships'] = FALSE;
  /* Relationship: Field collection item: Image (field_featured_card_image:fid) */
  $handler->display->display_options['relationships']['field_featured_card_image_fid']['id'] = 'field_featured_card_image_fid';
  $handler->display->display_options['relationships']['field_featured_card_image_fid']['table'] = 'field_data_field_featured_card_image';
  $handler->display->display_options['relationships']['field_featured_card_image_fid']['field'] = 'field_featured_card_image_fid';
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Field collection item: Field collection item ID */
  $handler->display->display_options['fields']['item_id']['id'] = 'item_id';
  $handler->display->display_options['fields']['item_id']['table'] = 'field_collection_item';
  $handler->display->display_options['fields']['item_id']['field'] = 'item_id';
  $handler->display->display_options['fields']['item_id']['label'] = 'ID';
  $handler->display->display_options['fields']['item_id']['separator'] = '';
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department']['id'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['relationship'] = 'field_featured_card_image_fid';
  $handler->display->display_options['fields']['field_department']['delta_offset'] = '0';
  /* Field: Field: License settings for this file */
  $handler->display->display_options['fields']['field_license']['id'] = 'field_license';
  $handler->display->display_options['fields']['field_license']['table'] = 'field_data_field_license';
  $handler->display->display_options['fields']['field_license']['field'] = 'field_license';
  $handler->display->display_options['fields']['field_license']['relationship'] = 'field_featured_card_image_fid';
  $handler->display->display_options['fields']['field_license']['label'] = 'Image License settings for this file';
  $handler->display->display_options['fields']['field_license']['type'] = 'list_key';
  /* Field: File: Alt Text */
  $handler->display->display_options['fields']['field_file_image_alt_text']['id'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['table'] = 'field_data_field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['field'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['relationship'] = 'field_featured_card_image_fid';
  $handler->display->display_options['fields']['field_file_image_alt_text']['label'] = 'Image Alt Text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['type'] = 'text_plain';
  /* Field: File: File ID */
  $handler->display->display_options['fields']['fid']['id'] = 'fid';
  $handler->display->display_options['fields']['fid']['table'] = 'file_managed';
  $handler->display->display_options['fields']['fid']['field'] = 'fid';
  $handler->display->display_options['fields']['fid']['relationship'] = 'field_featured_card_image_fid';
  /* Field: File: Path */
  $handler->display->display_options['fields']['uri']['id'] = 'uri';
  $handler->display->display_options['fields']['uri']['table'] = 'file_managed';
  $handler->display->display_options['fields']['uri']['field'] = 'uri';
  $handler->display->display_options['fields']['uri']['relationship'] = 'field_featured_card_image_fid';
  $handler->display->display_options['fields']['uri']['label'] = 'Image Path';
  /* Field: Field collection item: Description */
  $handler->display->display_options['fields']['field_featured_card_description']['id'] = 'field_featured_card_description';
  $handler->display->display_options['fields']['field_featured_card_description']['table'] = 'field_data_field_featured_card_description';
  $handler->display->display_options['fields']['field_featured_card_description']['field'] = 'field_featured_card_description';
  /* Field: Field collection item: Label */
  $handler->display->display_options['fields']['field_featured_card_label']['id'] = 'field_featured_card_label';
  $handler->display->display_options['fields']['field_featured_card_label']['table'] = 'field_data_field_featured_card_label';
  $handler->display->display_options['fields']['field_featured_card_label']['field'] = 'field_featured_card_label';
  /* Field: Field collection item: URL */
  $handler->display->display_options['fields']['field_featured_card_url']['id'] = 'field_featured_card_url';
  $handler->display->display_options['fields']['field_featured_card_url']['table'] = 'field_data_field_featured_card_url';
  $handler->display->display_options['fields']['field_featured_card_url']['field'] = 'field_featured_card_url';
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Field collection item: Field name */
  $handler->display->display_options['filters']['field_name']['id'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['table'] = 'field_collection_item';
  $handler->display->display_options['filters']['field_name']['field'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['value'] = array(
    'field_featured_cards_card' => 'field_featured_cards_card',
  );
  $handler->display->display_options['path'] = 'migration/fieldcollection/field_featured_cards_card';

  /* Display: Data export 7 */
  $handler = $view->new_display('views_data_export', 'Data export 7', 'views_data_export_7');
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
  $handler->display->display_options['fields']['item_id']['separator'] = '';
  /* Field: Field collection item: Description */
  $handler->display->display_options['fields']['field_amenities_description']['id'] = 'field_amenities_description';
  $handler->display->display_options['fields']['field_amenities_description']['table'] = 'field_data_field_amenities_description';
  $handler->display->display_options['fields']['field_amenities_description']['field'] = 'field_amenities_description';
  /* Field: Field collection item: Icon */
  $handler->display->display_options['fields']['field_amenities_icon']['id'] = 'field_amenities_icon';
  $handler->display->display_options['fields']['field_amenities_icon']['table'] = 'field_data_field_amenities_icon';
  $handler->display->display_options['fields']['field_amenities_icon']['field'] = 'field_amenities_icon';
  /* Field: Field collection item: Title */
  $handler->display->display_options['fields']['field_amenities_title']['id'] = 'field_amenities_title';
  $handler->display->display_options['fields']['field_amenities_title']['table'] = 'field_data_field_amenities_title';
  $handler->display->display_options['fields']['field_amenities_title']['field'] = 'field_amenities_title';
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Field collection item: Field name */
  $handler->display->display_options['filters']['field_name']['id'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['table'] = 'field_collection_item';
  $handler->display->display_options['filters']['field_name']['field'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['value'] = array(
    'field_location_amenities_coll' => 'field_location_amenities_coll',
  );
  $handler->display->display_options['path'] = 'migration/fieldcollection/field_location_amenities_coll';

  /* Display: Data export 8 */
  $handler = $view->new_display('views_data_export', 'Data export 8', 'views_data_export_8');
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
  $handler->display->display_options['fields']['item_id']['separator'] = '';
  /* Field: Field collection item: Date */
  $handler->display->display_options['fields']['field_office_exception_date']['id'] = 'field_office_exception_date';
  $handler->display->display_options['fields']['field_office_exception_date']['table'] = 'field_data_field_office_exception_date';
  $handler->display->display_options['fields']['field_office_exception_date']['field'] = 'field_office_exception_date';
  $handler->display->display_options['fields']['field_office_exception_date']['label'] = 'Start Date';
  $handler->display->display_options['fields']['field_office_exception_date']['type'] = 'date_plain';
  $handler->display->display_options['fields']['field_office_exception_date']['settings'] = array(
    'format_type' => 'year_month_day_time',
    'custom_date_format' => '',
    'fromto' => 'value',
    'multiple_number' => '',
    'multiple_from' => '',
    'multiple_to' => '',
    'show_remaining_days' => 0,
  );
  $handler->display->display_options['fields']['field_office_exception_date']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_office_exception_date']['separator'] = '|';
  /* Field: Field collection item: Date */
  $handler->display->display_options['fields']['field_office_exception_date_1']['id'] = 'field_office_exception_date_1';
  $handler->display->display_options['fields']['field_office_exception_date_1']['table'] = 'field_data_field_office_exception_date';
  $handler->display->display_options['fields']['field_office_exception_date_1']['field'] = 'field_office_exception_date';
  $handler->display->display_options['fields']['field_office_exception_date_1']['label'] = 'End Date';
  $handler->display->display_options['fields']['field_office_exception_date_1']['type'] = 'date_plain';
  $handler->display->display_options['fields']['field_office_exception_date_1']['settings'] = array(
    'format_type' => 'year_month_day_time',
    'custom_date_format' => '',
    'fromto' => 'value2',
    'multiple_number' => '',
    'multiple_from' => '',
    'multiple_to' => '',
    'show_remaining_days' => 0,
  );
  $handler->display->display_options['fields']['field_office_exception_date_1']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_office_exception_date_1']['separator'] = '|';
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Field collection item: Field name */
  $handler->display->display_options['filters']['field_name']['id'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['table'] = 'field_collection_item';
  $handler->display->display_options['filters']['field_name']['field'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['value'] = array(
    'field_location_exceptions_coll' => 'field_location_exceptions_coll',
  );
  $handler->display->display_options['path'] = 'migration/fieldcollection/field_location_exceptions_coll';

  /* Display: Data export 9 */
  $handler = $view->new_display('views_data_export', 'Data export 9', 'views_data_export_9');
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
  $handler->display->display_options['fields']['item_id']['separator'] = '';
  /* Field: Field collection item: Date */
  $handler->display->display_options['fields']['field_office_exception_date2']['id'] = 'field_office_exception_date2';
  $handler->display->display_options['fields']['field_office_exception_date2']['table'] = 'field_data_field_office_exception_date2';
  $handler->display->display_options['fields']['field_office_exception_date2']['field'] = 'field_office_exception_date2';
  $handler->display->display_options['fields']['field_office_exception_date2']['label'] = 'Start Date';
  $handler->display->display_options['fields']['field_office_exception_date2']['type'] = 'date_plain';
  $handler->display->display_options['fields']['field_office_exception_date2']['settings'] = array(
    'format_type' => 'year_month_day_time',
    'custom_date_format' => '',
    'fromto' => 'value',
    'multiple_number' => '',
    'multiple_from' => '',
    'multiple_to' => '',
    'show_remaining_days' => 0,
  );
  $handler->display->display_options['fields']['field_office_exception_date2']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_office_exception_date2']['separator'] = '|';
  /* Field: Field collection item: Date */
  $handler->display->display_options['fields']['field_office_exception_date2_1']['id'] = 'field_office_exception_date2_1';
  $handler->display->display_options['fields']['field_office_exception_date2_1']['table'] = 'field_data_field_office_exception_date2';
  $handler->display->display_options['fields']['field_office_exception_date2_1']['field'] = 'field_office_exception_date2';
  $handler->display->display_options['fields']['field_office_exception_date2_1']['label'] = 'End Date';
  $handler->display->display_options['fields']['field_office_exception_date2_1']['type'] = 'date_plain';
  $handler->display->display_options['fields']['field_office_exception_date2_1']['settings'] = array(
    'format_type' => 'year_month_day_time',
    'custom_date_format' => '',
    'fromto' => 'value2',
    'multiple_number' => '',
    'multiple_from' => '',
    'multiple_to' => '',
    'show_remaining_days' => 0,
  );
  $handler->display->display_options['fields']['field_office_exception_date2_1']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_office_exception_date2_1']['separator'] = '|';
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Field collection item: Field name */
  $handler->display->display_options['filters']['field_name']['id'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['table'] = 'field_collection_item';
  $handler->display->display_options['filters']['field_name']['field'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['value'] = array(
    'field_location_exceptions_coll2' => 'field_location_exceptions_coll2',
  );
  $handler->display->display_options['path'] = 'migration/fieldcollection/field_location_exceptions_coll2';

  /* Display: Data export 10 */
  $handler = $view->new_display('views_data_export', 'Data export 10', 'views_data_export_10');
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
  $handler->display->display_options['fields']['item_id']['separator'] = '';
  /* Field: Field collection item: Description */
  $handler->display->display_options['fields']['field_restrictions_description']['id'] = 'field_restrictions_description';
  $handler->display->display_options['fields']['field_restrictions_description']['table'] = 'field_data_field_restrictions_description';
  $handler->display->display_options['fields']['field_restrictions_description']['field'] = 'field_restrictions_description';
  /* Field: Field collection item: Icon */
  $handler->display->display_options['fields']['field_restrictions_icon']['id'] = 'field_restrictions_icon';
  $handler->display->display_options['fields']['field_restrictions_icon']['table'] = 'field_data_field_restrictions_icon';
  $handler->display->display_options['fields']['field_restrictions_icon']['field'] = 'field_restrictions_icon';
  /* Field: Field collection item: Title */
  $handler->display->display_options['fields']['field_restrictions_title']['id'] = 'field_restrictions_title';
  $handler->display->display_options['fields']['field_restrictions_title']['table'] = 'field_data_field_restrictions_title';
  $handler->display->display_options['fields']['field_restrictions_title']['field'] = 'field_restrictions_title';
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Field collection item: Field name */
  $handler->display->display_options['filters']['field_name']['id'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['table'] = 'field_collection_item';
  $handler->display->display_options['filters']['field_name']['field'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['value'] = array(
    'field_location_restrictions_coll' => 'field_location_restrictions_coll',
  );
  $handler->display->display_options['path'] = 'migration/fieldcollection/field_location_restrictions_coll';

  /* Display: Data export 11 */
  $handler = $view->new_display('views_data_export', 'Data export 11', 'views_data_export_11');
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
  $handler->display->display_options['defaults']['relationships'] = FALSE;
  /* Relationship: Field collection item: Image (field_outreach_stellar_image:fid) */
  $handler->display->display_options['relationships']['field_outreach_stellar_image_fid']['id'] = 'field_outreach_stellar_image_fid';
  $handler->display->display_options['relationships']['field_outreach_stellar_image_fid']['table'] = 'field_data_field_outreach_stellar_image';
  $handler->display->display_options['relationships']['field_outreach_stellar_image_fid']['field'] = 'field_outreach_stellar_image_fid';
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Field collection item: Field collection item ID */
  $handler->display->display_options['fields']['item_id']['id'] = 'item_id';
  $handler->display->display_options['fields']['item_id']['table'] = 'field_collection_item';
  $handler->display->display_options['fields']['item_id']['field'] = 'item_id';
  $handler->display->display_options['fields']['item_id']['label'] = 'ID';
  $handler->display->display_options['fields']['item_id']['separator'] = '';
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department']['id'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['relationship'] = 'field_outreach_stellar_image_fid';
  $handler->display->display_options['fields']['field_department']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_department']['alter']['text'] = '[field_department-tid] ';
  $handler->display->display_options['fields']['field_department']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_department']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_department']['separator'] = '|';
  /* Field: Field: License settings for this file */
  $handler->display->display_options['fields']['field_license']['id'] = 'field_license';
  $handler->display->display_options['fields']['field_license']['table'] = 'field_data_field_license';
  $handler->display->display_options['fields']['field_license']['field'] = 'field_license';
  $handler->display->display_options['fields']['field_license']['relationship'] = 'field_outreach_stellar_image_fid';
  $handler->display->display_options['fields']['field_license']['type'] = 'list_key';
  /* Field: File: Alt Text */
  $handler->display->display_options['fields']['field_file_image_alt_text']['id'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['table'] = 'field_data_field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['field'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['relationship'] = 'field_outreach_stellar_image_fid';
  $handler->display->display_options['fields']['field_file_image_alt_text']['type'] = 'text_plain';
  /* Field: File: File ID */
  $handler->display->display_options['fields']['fid']['id'] = 'fid';
  $handler->display->display_options['fields']['fid']['table'] = 'file_managed';
  $handler->display->display_options['fields']['fid']['field'] = 'fid';
  $handler->display->display_options['fields']['fid']['relationship'] = 'field_outreach_stellar_image_fid';
  /* Field: File: Path */
  $handler->display->display_options['fields']['uri']['id'] = 'uri';
  $handler->display->display_options['fields']['uri']['table'] = 'file_managed';
  $handler->display->display_options['fields']['uri']['field'] = 'uri';
  $handler->display->display_options['fields']['uri']['relationship'] = 'field_outreach_stellar_image_fid';
  /* Field: Field: Body */
  $handler->display->display_options['fields']['field_outreach_body']['id'] = 'field_outreach_body';
  $handler->display->display_options['fields']['field_outreach_body']['table'] = 'field_data_field_outreach_body';
  $handler->display->display_options['fields']['field_outreach_body']['field'] = 'field_outreach_body';
  /* Field: Field: Minimum Height (px) */
  $handler->display->display_options['fields']['field_outreach_minimum_height']['id'] = 'field_outreach_minimum_height';
  $handler->display->display_options['fields']['field_outreach_minimum_height']['table'] = 'field_data_field_outreach_minimum_height';
  $handler->display->display_options['fields']['field_outreach_minimum_height']['field'] = 'field_outreach_minimum_height';
  $handler->display->display_options['fields']['field_outreach_minimum_height']['type'] = 'text_plain';
  /* Field: Field collection item: Background Color */
  $handler->display->display_options['fields']['field_outreach_bg_color']['id'] = 'field_outreach_bg_color';
  $handler->display->display_options['fields']['field_outreach_bg_color']['table'] = 'field_data_field_outreach_bg_color';
  $handler->display->display_options['fields']['field_outreach_bg_color']['field'] = 'field_outreach_bg_color';
  $handler->display->display_options['fields']['field_outreach_bg_color']['type'] = 'text_plain';
  $handler->display->display_options['fields']['field_outreach_bg_color']['settings'] = array(
    'trim_length' => '600',
  );
  /* Field: Field collection item: Centered */
  $handler->display->display_options['fields']['field_outreach_centered']['id'] = 'field_outreach_centered';
  $handler->display->display_options['fields']['field_outreach_centered']['table'] = 'field_data_field_outreach_centered';
  $handler->display->display_options['fields']['field_outreach_centered']['field'] = 'field_outreach_centered';
  $handler->display->display_options['fields']['field_outreach_centered']['type'] = 'list_key';
  /* Field: Field collection item: Full Width on Mobile */
  $handler->display->display_options['fields']['field_outreach_full_width_mobile']['id'] = 'field_outreach_full_width_mobile';
  $handler->display->display_options['fields']['field_outreach_full_width_mobile']['table'] = 'field_data_field_outreach_full_width_mobile';
  $handler->display->display_options['fields']['field_outreach_full_width_mobile']['field'] = 'field_outreach_full_width_mobile';
  $handler->display->display_options['fields']['field_outreach_full_width_mobile']['type'] = 'list_key';
  /* Field: Field collection item: Image Scroll Ratio */
  $handler->display->display_options['fields']['field_outreach_scroll_ratio']['id'] = 'field_outreach_scroll_ratio';
  $handler->display->display_options['fields']['field_outreach_scroll_ratio']['table'] = 'field_data_field_outreach_scroll_ratio';
  $handler->display->display_options['fields']['field_outreach_scroll_ratio']['field'] = 'field_outreach_scroll_ratio';
  $handler->display->display_options['fields']['field_outreach_scroll_ratio']['type'] = 'list_key';
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Field collection item: Field name */
  $handler->display->display_options['filters']['field_name']['id'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['table'] = 'field_collection_item';
  $handler->display->display_options['filters']['field_name']['field'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['value'] = array(
    'field_outreach_sections_coll' => 'field_outreach_sections_coll',
  );
  $handler->display->display_options['path'] = 'migration/fieldcollection/field-outreach-sections-coll';

  /* Display: Data export 11 */
  $handler = $view->new_display('views_data_export', 'Data export 11', 'views_data_export_12');
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
  $handler->display->display_options['defaults']['relationships'] = FALSE;
  /* Relationship: Field collection item: Image (field_outreach_stellar_image:fid) */
  $handler->display->display_options['relationships']['field_outreach_stellar_image_fid']['id'] = 'field_outreach_stellar_image_fid';
  $handler->display->display_options['relationships']['field_outreach_stellar_image_fid']['table'] = 'field_data_field_outreach_stellar_image';
  $handler->display->display_options['relationships']['field_outreach_stellar_image_fid']['field'] = 'field_outreach_stellar_image_fid';
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Field collection item: Revision_id */
  $handler->display->display_options['fields']['revision_id']['id'] = 'revision_id';
  $handler->display->display_options['fields']['revision_id']['table'] = 'field_collection_item';
  $handler->display->display_options['fields']['revision_id']['field'] = 'revision_id';
  $handler->display->display_options['fields']['revision_id']['label'] = 'ID';
  $handler->display->display_options['fields']['revision_id']['separator'] = '';
  /* Field: Field: Department */
  $handler->display->display_options['fields']['field_department']['id'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['table'] = 'field_data_field_department';
  $handler->display->display_options['fields']['field_department']['field'] = 'field_department';
  $handler->display->display_options['fields']['field_department']['relationship'] = 'field_outreach_stellar_image_fid';
  $handler->display->display_options['fields']['field_department']['alter']['alter_text'] = TRUE;
  $handler->display->display_options['fields']['field_department']['alter']['text'] = '[field_department-tid] ';
  $handler->display->display_options['fields']['field_department']['type'] = 'taxonomy_term_reference_plain';
  $handler->display->display_options['fields']['field_department']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_department']['separator'] = '|';
  /* Field: Field: License settings for this file */
  $handler->display->display_options['fields']['field_license']['id'] = 'field_license';
  $handler->display->display_options['fields']['field_license']['table'] = 'field_data_field_license';
  $handler->display->display_options['fields']['field_license']['field'] = 'field_license';
  $handler->display->display_options['fields']['field_license']['relationship'] = 'field_outreach_stellar_image_fid';
  $handler->display->display_options['fields']['field_license']['type'] = 'list_key';
  /* Field: File: Alt Text */
  $handler->display->display_options['fields']['field_file_image_alt_text']['id'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['table'] = 'field_data_field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['field'] = 'field_file_image_alt_text';
  $handler->display->display_options['fields']['field_file_image_alt_text']['relationship'] = 'field_outreach_stellar_image_fid';
  $handler->display->display_options['fields']['field_file_image_alt_text']['type'] = 'text_plain';
  /* Field: File: File ID */
  $handler->display->display_options['fields']['fid']['id'] = 'fid';
  $handler->display->display_options['fields']['fid']['table'] = 'file_managed';
  $handler->display->display_options['fields']['fid']['field'] = 'fid';
  $handler->display->display_options['fields']['fid']['relationship'] = 'field_outreach_stellar_image_fid';
  /* Field: File: Path */
  $handler->display->display_options['fields']['uri']['id'] = 'uri';
  $handler->display->display_options['fields']['uri']['table'] = 'file_managed';
  $handler->display->display_options['fields']['uri']['field'] = 'uri';
  $handler->display->display_options['fields']['uri']['relationship'] = 'field_outreach_stellar_image_fid';
  /* Field: Field: Body */
  $handler->display->display_options['fields']['field_outreach_body']['id'] = 'field_outreach_body';
  $handler->display->display_options['fields']['field_outreach_body']['table'] = 'field_data_field_outreach_body';
  $handler->display->display_options['fields']['field_outreach_body']['field'] = 'field_outreach_body';
  /* Field: Field: Minimum Height (px) */
  $handler->display->display_options['fields']['field_outreach_minimum_height']['id'] = 'field_outreach_minimum_height';
  $handler->display->display_options['fields']['field_outreach_minimum_height']['table'] = 'field_data_field_outreach_minimum_height';
  $handler->display->display_options['fields']['field_outreach_minimum_height']['field'] = 'field_outreach_minimum_height';
  $handler->display->display_options['fields']['field_outreach_minimum_height']['type'] = 'text_plain';
  /* Field: Field collection item: Background Color */
  $handler->display->display_options['fields']['field_outreach_bg_color']['id'] = 'field_outreach_bg_color';
  $handler->display->display_options['fields']['field_outreach_bg_color']['table'] = 'field_data_field_outreach_bg_color';
  $handler->display->display_options['fields']['field_outreach_bg_color']['field'] = 'field_outreach_bg_color';
  $handler->display->display_options['fields']['field_outreach_bg_color']['type'] = 'text_plain';
  $handler->display->display_options['fields']['field_outreach_bg_color']['settings'] = array(
    'trim_length' => '600',
  );
  /* Field: Field collection item: Centered */
  $handler->display->display_options['fields']['field_outreach_centered']['id'] = 'field_outreach_centered';
  $handler->display->display_options['fields']['field_outreach_centered']['table'] = 'field_data_field_outreach_centered';
  $handler->display->display_options['fields']['field_outreach_centered']['field'] = 'field_outreach_centered';
  $handler->display->display_options['fields']['field_outreach_centered']['type'] = 'list_key';
  /* Field: Field collection item: Full Width on Mobile */
  $handler->display->display_options['fields']['field_outreach_full_width_mobile']['id'] = 'field_outreach_full_width_mobile';
  $handler->display->display_options['fields']['field_outreach_full_width_mobile']['table'] = 'field_data_field_outreach_full_width_mobile';
  $handler->display->display_options['fields']['field_outreach_full_width_mobile']['field'] = 'field_outreach_full_width_mobile';
  $handler->display->display_options['fields']['field_outreach_full_width_mobile']['type'] = 'list_key';
  /* Field: Field collection item: Image Scroll Ratio */
  $handler->display->display_options['fields']['field_outreach_scroll_ratio']['id'] = 'field_outreach_scroll_ratio';
  $handler->display->display_options['fields']['field_outreach_scroll_ratio']['table'] = 'field_data_field_outreach_scroll_ratio';
  $handler->display->display_options['fields']['field_outreach_scroll_ratio']['field'] = 'field_outreach_scroll_ratio';
  $handler->display->display_options['fields']['field_outreach_scroll_ratio']['type'] = 'list_key';
  /* Field: Field collection item: Adjustment Width */
  $handler->display->display_options['fields']['field_outreach_adjustment_width']['id'] = 'field_outreach_adjustment_width';
  $handler->display->display_options['fields']['field_outreach_adjustment_width']['table'] = 'field_data_field_outreach_adjustment_width';
  $handler->display->display_options['fields']['field_outreach_adjustment_width']['field'] = 'field_outreach_adjustment_width';
  $handler->display->display_options['fields']['field_outreach_adjustment_width']['type'] = 'number_unformatted';
  $handler->display->display_options['fields']['field_outreach_adjustment_width']['settings'] = array(
    'thousand_separator' => '',
    'prefix_suffix' => 1,
  );
  /* Field: Field collection item: Background-Size */
  $handler->display->display_options['fields']['field_outreach_background_size']['id'] = 'field_outreach_background_size';
  $handler->display->display_options['fields']['field_outreach_background_size']['table'] = 'field_data_field_outreach_background_size';
  $handler->display->display_options['fields']['field_outreach_background_size']['field'] = 'field_outreach_background_size';
  $handler->display->display_options['fields']['field_outreach_background_size']['type'] = 'text_plain';
  /* Field: Field collection item: Bottom Border */
  $handler->display->display_options['fields']['field_outreach_bottom_border']['id'] = 'field_outreach_bottom_border';
  $handler->display->display_options['fields']['field_outreach_bottom_border']['table'] = 'field_data_field_outreach_bottom_border';
  $handler->display->display_options['fields']['field_outreach_bottom_border']['field'] = 'field_outreach_bottom_border';
  $handler->display->display_options['fields']['field_outreach_bottom_border']['type'] = 'list_key';
  /* Field: Field collection item: Direction of Image Scroll */
  $handler->display->display_options['fields']['field_outreach_direction']['id'] = 'field_outreach_direction';
  $handler->display->display_options['fields']['field_outreach_direction']['table'] = 'field_data_field_outreach_direction';
  $handler->display->display_options['fields']['field_outreach_direction']['field'] = 'field_outreach_direction';
  $handler->display->display_options['fields']['field_outreach_direction']['type'] = 'list_key';
  /* Field: Field collection item: Full Width on Mobile */
  $handler->display->display_options['fields']['field_outreach_full_width_mobile_1']['id'] = 'field_outreach_full_width_mobile_1';
  $handler->display->display_options['fields']['field_outreach_full_width_mobile_1']['table'] = 'field_data_field_outreach_full_width_mobile';
  $handler->display->display_options['fields']['field_outreach_full_width_mobile_1']['field'] = 'field_outreach_full_width_mobile';
  $handler->display->display_options['fields']['field_outreach_full_width_mobile_1']['type'] = 'list_key';
  /* Field: Field collection item: Hide on Desktop */
  $handler->display->display_options['fields']['field_outreach_hide_on_desktop']['id'] = 'field_outreach_hide_on_desktop';
  $handler->display->display_options['fields']['field_outreach_hide_on_desktop']['table'] = 'field_data_field_outreach_hide_on_desktop';
  $handler->display->display_options['fields']['field_outreach_hide_on_desktop']['field'] = 'field_outreach_hide_on_desktop';
  $handler->display->display_options['fields']['field_outreach_hide_on_desktop']['type'] = 'list_key';
  /* Field: Field collection item: Hide on Mobile */
  $handler->display->display_options['fields']['field_outreach_hide_on_mobile']['id'] = 'field_outreach_hide_on_mobile';
  $handler->display->display_options['fields']['field_outreach_hide_on_mobile']['table'] = 'field_data_field_outreach_hide_on_mobile';
  $handler->display->display_options['fields']['field_outreach_hide_on_mobile']['field'] = 'field_outreach_hide_on_mobile';
  $handler->display->display_options['fields']['field_outreach_hide_on_mobile']['type'] = 'list_key';
  /* Field: Field collection item: Horizontal Percentage */
  $handler->display->display_options['fields']['field_outreach_horizontal']['id'] = 'field_outreach_horizontal';
  $handler->display->display_options['fields']['field_outreach_horizontal']['table'] = 'field_data_field_outreach_horizontal';
  $handler->display->display_options['fields']['field_outreach_horizontal']['field'] = 'field_outreach_horizontal';
  $handler->display->display_options['fields']['field_outreach_horizontal']['type'] = 'number_unformatted';
  $handler->display->display_options['fields']['field_outreach_horizontal']['settings'] = array(
    'thousand_separator' => '',
    'prefix_suffix' => 1,
  );
  /* Field: Field collection item: Image Height */
  $handler->display->display_options['fields']['field_outreach_size']['id'] = 'field_outreach_size';
  $handler->display->display_options['fields']['field_outreach_size']['table'] = 'field_data_field_outreach_size';
  $handler->display->display_options['fields']['field_outreach_size']['field'] = 'field_outreach_size';
  $handler->display->display_options['fields']['field_outreach_size']['type'] = 'list_key';
  /* Field: Field collection item: Mobile Size */
  $handler->display->display_options['fields']['field_outreach_adjustment_mobile']['id'] = 'field_outreach_adjustment_mobile';
  $handler->display->display_options['fields']['field_outreach_adjustment_mobile']['table'] = 'field_data_field_outreach_adjustment_mobile';
  $handler->display->display_options['fields']['field_outreach_adjustment_mobile']['field'] = 'field_outreach_adjustment_mobile';
  $handler->display->display_options['fields']['field_outreach_adjustment_mobile']['type'] = 'text_plain';
  $handler->display->display_options['fields']['field_outreach_adjustment_mobile']['settings'] = array(
    'trim_length' => '600',
  );
  /* Field: Field collection item: No Drop Shadow */
  $handler->display->display_options['fields']['field_outreach_no_font_styling']['id'] = 'field_outreach_no_font_styling';
  $handler->display->display_options['fields']['field_outreach_no_font_styling']['table'] = 'field_data_field_outreach_no_font_styling';
  $handler->display->display_options['fields']['field_outreach_no_font_styling']['field'] = 'field_outreach_no_font_styling';
  $handler->display->display_options['fields']['field_outreach_no_font_styling']['type'] = 'list_key';
  /* Field: Field collection item: No Text Styling */
  $handler->display->display_options['fields']['field_outreach_no_styling']['id'] = 'field_outreach_no_styling';
  $handler->display->display_options['fields']['field_outreach_no_styling']['table'] = 'field_data_field_outreach_no_styling';
  $handler->display->display_options['fields']['field_outreach_no_styling']['field'] = 'field_outreach_no_styling';
  $handler->display->display_options['fields']['field_outreach_no_styling']['type'] = 'list_key';
  /* Field: Field collection item: Opacity of Image */
  $handler->display->display_options['fields']['field_outreach_opacity']['id'] = 'field_outreach_opacity';
  $handler->display->display_options['fields']['field_outreach_opacity']['table'] = 'field_data_field_outreach_opacity';
  $handler->display->display_options['fields']['field_outreach_opacity']['field'] = 'field_outreach_opacity';
  $handler->display->display_options['fields']['field_outreach_opacity']['type'] = 'number_unformatted';
  $handler->display->display_options['fields']['field_outreach_opacity']['settings'] = array(
    'thousand_separator' => '',
    'decimal_separator' => '.',
    'scale' => '2',
    'prefix_suffix' => 1,
  );
  /* Field: Field collection item: Rate of Image Scroll */
  $handler->display->display_options['fields']['field_outreach_rate']['id'] = 'field_outreach_rate';
  $handler->display->display_options['fields']['field_outreach_rate']['table'] = 'field_data_field_outreach_rate';
  $handler->display->display_options['fields']['field_outreach_rate']['field'] = 'field_outreach_rate';
  $handler->display->display_options['fields']['field_outreach_rate']['type'] = 'list_key';
  /* Field: Field collection item: Repeat Image Across Page */
  $handler->display->display_options['fields']['field_outreach_repeat']['id'] = 'field_outreach_repeat';
  $handler->display->display_options['fields']['field_outreach_repeat']['table'] = 'field_data_field_outreach_repeat';
  $handler->display->display_options['fields']['field_outreach_repeat']['field'] = 'field_outreach_repeat';
  $handler->display->display_options['fields']['field_outreach_repeat']['type'] = 'list_key';
  /* Field: Field collection item: Vertical Offset */
  $handler->display->display_options['fields']['field_outreach_vertical_offset']['id'] = 'field_outreach_vertical_offset';
  $handler->display->display_options['fields']['field_outreach_vertical_offset']['table'] = 'field_data_field_outreach_vertical_offset';
  $handler->display->display_options['fields']['field_outreach_vertical_offset']['field'] = 'field_outreach_vertical_offset';
  $handler->display->display_options['fields']['field_outreach_vertical_offset']['type'] = 'number_unformatted';
  $handler->display->display_options['fields']['field_outreach_vertical_offset']['settings'] = array(
    'thousand_separator' => '',
    'prefix_suffix' => 1,
  );
  /* Field: Field collection item: Vertical Percentage */
  $handler->display->display_options['fields']['field_outreach_vertical']['id'] = 'field_outreach_vertical';
  $handler->display->display_options['fields']['field_outreach_vertical']['table'] = 'field_data_field_outreach_vertical';
  $handler->display->display_options['fields']['field_outreach_vertical']['field'] = 'field_outreach_vertical';
  $handler->display->display_options['fields']['field_outreach_vertical']['type'] = 'number_unformatted';
  $handler->display->display_options['fields']['field_outreach_vertical']['settings'] = array(
    'thousand_separator' => '',
    'prefix_suffix' => 1,
  );
  $handler->display->display_options['defaults']['filter_groups'] = FALSE;
  $handler->display->display_options['defaults']['filters'] = FALSE;
  /* Filter criterion: Field collection item: Field name */
  $handler->display->display_options['filters']['field_name']['id'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['table'] = 'field_collection_item';
  $handler->display->display_options['filters']['field_name']['field'] = 'field_name';
  $handler->display->display_options['filters']['field_name']['value'] = array(
    'field_outreach_sections_coll2' => 'field_outreach_sections_coll2',
  );
  $handler->display->display_options['path'] = 'migration/fieldcollection/field-outreach-sections-coll2';
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
  $handler->display->display_options['path'] = 'migration/taxonomy/buckets';

  /* Display: Data export */
  $handler = $view->new_display('views_data_export', 'Data export', 'views_data_export_6');
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
    'business_resources_organization' => 'business_resources_organization',
  );
  $handler->display->display_options['path'] = 'migration/taxonomy/business-resource-organization';
  $handler->display->display_options['sitename_title'] = 0;

  /* Display: Data export */
  $handler = $view->new_display('views_data_export', 'Data export', 'views_data_export_7');
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
    'business_resources_type_of_assistance' => 'business_resources_type_of_assistance',
  );
  $handler->display->display_options['path'] = 'migration/taxonomy/business-resource-assistance';
  $handler->display->display_options['sitename_title'] = 0;

  /* Display: Data export */
  $handler = $view->new_display('views_data_export', 'Data export', 'views_data_export_8');
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
    'business_resources_target_business' => 'business_resources_target_business',
  );
  $handler->display->display_options['path'] = 'migration/taxonomy/business-resource-target';
  $handler->display->display_options['sitename_title'] = 0;
  $export['taxonomy_migration'] = $view;

  return $export;
}
