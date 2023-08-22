<?php

namespace Drupal\sand_info\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Returns responses for Sand info routes.
 */
class SandInfoController extends ControllerBase
{

    /**
     * Builds the response.
     */
    public function build()
    {
        $migration_types = [
            'application',
            'blog',
            'date',
            'department',
            'department_document',
            'department_parent',
            'event',
            'events',
            'hero',
            'page',
            'sand_gallery',
            'speaker_slips',
            'surplus_property',
            'webform',
        ];

        $build['content'] = [
            '#type' => 'item',
            '#markup' => $this->t('It works!'),
        ];


        $header[] = ['Name', 'Machine', 'Not In D7', 'Required', 'Type'];

        $entityFieldManager = \Drupal::service('entity_field.manager');
        $entity_type = 'node';

        $types = \Drupal::entityTypeManager()
            ->getStorage('node_type')
            ->loadMultiple();
        $bundles = [];
        foreach ($types as $type) {
            $bundles[] = $type->id();
        }

        foreach ($bundles as $bundle) {
            
            if (!in_array($bundle, $migration_types)) {
                continue;
            }

            $fields_d7 = $this->get_d7_fields($bundle);
            $fields = $entityFieldManager->getFieldDefinitions($entity_type, $bundle);
            $rows = [];
            /** @var BaseFieldDefinition $field */
            foreach ($fields as $field) {
                $field_name = $field->getName();
                if (in_array($field_name, $fields_d7)) {
                    $in_d7 = '';
                } else {
                    $in_d7 = 'Not in D7';
                }
                if ($field_name === 'body' || str_starts_with($field_name, 'field_') && $field_name !== 'field_d7_nid' ) {
                    $rows[] = [$field->getLabel(), $field_name, $in_d7, $field->isRequired() ? 'Y' : '', $field->getType()];
                }
            }
            asort($rows);

            $build['table_' . $bundle . '_head'] = [
                '#markup' => "<h2>$bundle</h2>"
                ];
            $build['table_' . $bundle . '_table'] = [
                '#type' => 'table',
                '#header' => $header,
                '#rows' => $rows,
                '#empty' => t('No content has been found.'),
            ];
        }


      $list = \Drupal::service('entity_type.repository')->getEntityTypeLabels();

      $build['entity_type_header'] = [
        '#markup' => '<h2>List of all entity types</h2>',
      ];
      $keys = array_keys($list);
      asort($keys);
      foreach ($keys as $key) {
        $build['entity_type_' . $key] = [
          '#markup' => $key . '<br>',
        ];
      }

      return $build;
    }
    
    private function get_d7_fields($bundle) {
        $type['application'] =
            [
                'body',
                'field_edit_notes',
                'field_search_keymatch',
            ];
        $type['blog'] =
            [
                'body',
                'field_add_updated_tag',
                'field_blog_other_homepages',
                'field_blog_promote_to_home',
                'field_blog_top_content',
                'field_blog_website_url',
                'field_category',
                'field_department',
                'field_edit_notes',
                'field_image',
                'field_keywords',
                'field_other_description',
                'field_other_keywords',
                'field_promote_to_city_home',
                'field_search_keymatch',
                'field_sub_heading',
            ];
        $type['date'] =
            [
                'body',
                'field_date_date',
                'field_date_type',
                'field_department',
                'field_event_date',
            ];
        $type['department'] =
            [
                'body',
                'field_add_updated_tag',
                'field_additional_content',
                'field_category',
                'field_department',
                'field_department_notifications_f',
                'field_dept_card_teaser_only',
                'field_dept_card_teaser_order',
                'field_edit_notes',
                'field_image',
                'field_other_description',
                'field_other_keywords',
                'field_promote_to_city_home',
                'field_search_keymatch',
                'field_subtitle',
            ];
        $type['department_document'] =
            [
                'body',
                'field_attachment',
                'field_category',
                'field_department',
                'field_dept_doc_icon',
                'field_dept_doc_id',
                'field_dept_doc_keywords',
                'field_dept_doc_url',
                'field_display_body',
                'field_edit_notes',
                'field_promote_to_city_home',
                'field_replace_body_text_with_att',
                'field_search_keymatch',
            ];
        $type['department_parent'] =
            [
                'body',
                'field_additional_content',
                'field_category',
                'field_department',
                'field_dept_feature_alt_text',
                'field_dept_news_alt_text',
                'field_dept_par_feature_video_img',
                'field_dept_par_featured_content',
                'field_dept_par_graphic_cta',
                'field_dept_par_hide_news_feed',
                'field_dept_par_show_top_slider',
                'field_dept_par_single_line_title',
                'field_dept_par_top_content_row',
                'field_edit_notes',
                'field_image',
                'field_intro',
                'field_search_keymatch',
            ];
        $type['event'] =
            [
                'body',
                'field_department',
                'field_edit_notes',
                'field_event_activity_desc',
                'field_event_activity_seq_num',
                'field_event_activity_type_cd',
                'field_event_activity_type_nm',
                'field_event_activity_url',
                'field_event_color',
                'field_event_cost_txt',
                'field_event_date',
                'field_event_do_not_show_map',
                'field_event_end_time_valid_ind',
                'field_event_expected_attendance',
                'field_event_expected_participant',
                'field_event_host_nm',
                'field_event_location',
                'field_event_location_txt',
                'field_event_management_cd',
                'field_event_media_contact_txt',
                'field_event_no_show_add_to_cal',
                'field_event_no_show_social_media',
                'field_event_no_show_time',
                'field_event_non_public_contact',
                'field_event_organizer_nm',
                'field_event_pin_address',
                'field_event_public_contact_txt',
                'field_event_public_visibility',
                'field_event_seq_num',
                'field_event_setup_dt',
                'field_event_setup_end_time_ind',
                'field_event_setup_start_time_ind',
                'field_event_start_time_valid_ind',
                'field_event_subtitle',
                'field_event_type',
                'field_event_vendor_contact_txt',
                'field_image',
                'field_image_text',
                'field_images',
                'field_search_keymatch',
                'field_type_of_event',
            ];
        $type['hero'] =
            [
                'field_department',
                'field_hero_caption',
                'field_hero_frontpage',
                'field_hero_image',
                'field_hero_image_by',
                'field_hero_image_by_prefix',
                'field_hero_sitewide',
                'field_hero_time_of_day',
                'field_vimeo_url',
            ];
        $type['page'] =
            [
                'body',
                'field_image',
                'field_link',
                'field_search_keymatch',
                'field_sub_heading', 
            ];
        $type['sand_gallery'] =
            [
                'body',
                'field_additional_content',
                'field_body_bottom',
                'field_department',
                'field_intro',
                'field_sand_gallery_display',
                'field_sand_gallery_display_as',
                'field_sand_gallery_folderimage',
                'field_sand_gallery_items',
                'field_sand_gallery_no_events',
                'field_sand_gallery_sidebar_title',
                'field_search_keymatch',
            ];
        $type['speaker_slips'] =
            [
                'body',
                'field_doc_date',
                'field_document_url',
                'field_r_object_id',
            ];
        $type['surplus_property'] =
            [
                'body',
                'field_surplus_claim_date',
                'field_surplus_claimant',
                'field_surplus_claimant_dept',
                'field_surplus_claimed',
                'field_surplus_contact_email',
                'field_surplus_image',
                'field_surplus_internal_comments',
                'field_surplus_originating_dept',
                'field_surplus_quality',
            ];
        $type['webform'] =
            [
                'body',
                'field_additional_content',
                'field_department',
                'field_exhibit_attachments',
                'field_search_keymatch',
            ];

        if (isset($type[$bundle])) {
            return $type[$bundle];
        } else {
            return [];
        }
            
    }

}
