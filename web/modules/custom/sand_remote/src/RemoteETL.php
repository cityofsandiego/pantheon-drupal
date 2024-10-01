<?php

namespace Drupal\sand_remote;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\ContentEntityBase;

/**
 * Service description.
 */
class RemoteETL extends ContentEntityBase { 

  /**
   * Get the key to the field_doc_type based on field_path in external data.
   *
   * @param $path
   * @return string
   */
  public static function setDocType(EntityInterface $entity): void {
    $field_doc_set = 'field_doc_set';
    $field_doc_type = 'field_doc_type';
    if (!$entity->hasField($field_doc_set) || !$entity->hasField($field_doc_type)) {
      return;
    }
    
    switch ($entity->$field_doc_set->value) {
      case 'COVID-19 Response and Recovery Committee Meeting Agendas':
        $field_doc_type_value = 'covid';
        break;
      case 'Agency Resolutions & Ordinances':
        $field_doc_type_value = 'agency-resolutions-and-ordinances';
        break;
      case 'Active Transportation and Infrastructure Committee Meeting Actions':
      case 'Audit Committee Actions':
      case 'Audit Committee Meeting Actions':
      case 'Budget & Finance Committee Actions':
      case 'Budget and Goverment Efficiency Commitee Meeting Actions':
      case 'Budget and Government Efficiency Actions':
      case 'Budget Review Committee Meeting Actions':
      case 'Charter Review Committee Actions':
      case 'Economic Development and Intergovernmental Relations Actions':
      case 'Economic Development and Intergovernmental Relations Committee Meeting Actions':
      case 'Economic Development and Strategies Committee Actions':
      case 'Environment Actions':
      case 'Environment Committee Meeting Actions':
      case 'Fire Prevention & Recovery Committee Actions':
      case 'government efficiency committee actions':
      case 'Homeless Committee Meeting Actions':
      case 'Infrastructure Committee Meeting Actions':
      case 'Land Use and Housing Committee Actions':
      case 'Land Use & Housing Committee Actions':
      case 'Land Use & Housing Committee Meeting Actions':
      case 'Natural Resources & Culture Committee Actions':
      case 'Neighborhood Services Committee Actions':
      case 'Public Safety and Livable Neighborhoods Actions':
      case 'Public Safety and Livable Neighborhoods Committee Meeting Actions':
      case 'Rules Committee Actions':
      case 'Rules Committee Meeting Actions':
      case 'Select Committee on Homelessness Actions':
      case 'Smart Growth and Land Use Actions':
      case 'Smart Growth and Land Use Committee Meeting Actions':
        $field_doc_type_value = 'council-committees-actions';
        break;
      case 'Active Transportation and Infrastructure Committee Meeting Agendas':
      case 'Audit Committee Agendas':
      case 'Audit Committee Meeting Agendas':
      case 'Budget & Government Efficiency Committee Meeting Agendas':
      case 'Budget & Finance Committee Agendas':
      case 'Budget and Government Efficiency Agendas':
      case 'Budget and Government Efficiency Committee Meeting Agendas':
      case 'Budget Review Committee Meeting Agendas':
      case 'Charter Review Committee Agendas':
      case 'council committee agendas attachments':
      case 'Economic Development & Intergovernmental Relations Committee Agendas':
      case 'Economic Development and Intergovernmental Relations Agendas':
      case 'Economic Development and Intergovernmental Relations Committee Meeting Agendas':
      case 'Economic Development and Strategies Committee Agendas':
      case 'Environment Agendas':
      case 'Environment Committee Meeting Agendas':
      case 'Fire Prevention & Recovery Committee Agendas':
      case 'Government Efficiency Committee Agendas':
      case 'Homeless Committee Meeting Agendas':
      case 'Infrastructure Committee Meeting Agendas':
      case 'land use & housing committee agendas':
      case 'Land Use & Housing Committee Meeting Agendas':
      case 'Land Use and Housing Committee Meeting Agendas':
      case 'natural resources & culture committee agendas':
      case 'neighborhood services committee agendas':
      case 'Public Safety & Livable Neighborhoods Committee Meeting Agendas':
      case 'public safety and livable neighborhoods agendas':
      case 'Public Safety and Livable Neighborhoods Committee Meeting Agendas':
      case 'Rules Committee Agendas':
      case 'rules committee agendas':
      case 'Rules Committee Meeting  Agendas':
      case 'Rules Committee Meeting Agendas':
      case 'Select Committee on Homelessness Agendas':
      case 'Smart Growth & Land Use Committee Agendas':
      case 'smart growth and land use agendas':
      case 'Smart Growth and Land Use Committee Meeting Agendas':
        $field_doc_type_value = 'council-committees-agendas';
        break;
      case 'City Bulletin of Public Notices':
        $field_doc_type_value = 'public-notices';
        break;
      case 'Council Dockets Attachments':
      case 'Council Meeting Dockets':
      case 'Council Meeting Minutes':
      case 'Council Meeting Results':
        $field_doc_type_value = 'city-council-agendas-minutes-and-results';
        break;
      case 'Legal Opinions':
        $field_doc_type_value = 'legal-opinions';
        break;
      case 'Municipal Code supplemental':
      case 'municipal code':
      case 'municipal code history table':
        $field_doc_type_value = 'municipal-code';
        break;
      case 'Redevelopment Agency Agendas':
      case 'Redevelopment Agency Minutes':
      case 'Redevelopment Agency Reports':
        $field_doc_type_value = 'redevelopment-agency-meetings';
        break;
      case 'Reports to City Council':
      case 'reports to city council attachments':
        $field_doc_type_value = 'reports-to-city-council';
        break;
      case 'city attorney reports':
        $field_doc_type_value = 'city-attorney-reports';
        break;
      case 'council policies':
        $field_doc_type_value = 'council-policy';
        break;
      case 'council resolutions & ordinances':
        $field_doc_type_value = 'council-resolutions-and-ordinances';
        break;
      case 'memoranda of law':
        $field_doc_type_value = 'memoranda-of-law';
        break;
      case 'City Charter':
        $field_doc_type_value = 'city-charter';
        break;
      case 'Planning Commission Agendas':
        $field_doc_type_value = 'planning-commission-meeting-agendas';
        break;
      default:
        $field_doc_type_value = 'other';
    }
    $entity->$field_doc_type->setValue($field_doc_type_value);
  }

  /**
   * Get the key to the field_doc_type based on field_path in external data.
   *
   * @param $path
   * @return string
   */
  //function sand_search_get_committee_from_path(\Drupal\Core\Entity\EntityInterface $entity)
  public static function setCommittee(EntityInterface $entity): void {
    $field_path = 'field_path';
    $field_committee = 'field_committee';
    if (!$entity->hasField($field_path) || !$entity->hasField($field_committee)) {
      return;
    }

    if (strpos($entity->$field_path->value, 'cc') === 0) {
      switch ($entity->$field_path->value) {
        case 'ccagenda_covid':
        case 'ccaction_covid':
          $field_committee_value = 'covid';
          break;
        case 'ccagenda_ati':
        case 'ccaction_ati':
          $field_committee_value = 'ati';
          break;
        case 'ccagenda_audit':
        case 'ccaction_audit':
          $field_committee_value = 'audit';
          break;
        case 'ccagenda_bge':
        case 'ccaction_bge':
          $field_committee_value = 'bge';
          break;
        case 'ccagenda_brc':
        case 'ccaction_brc':
          $field_committee_value = 'brc';
          break;
        case 'ccagenda_edir':
        case 'ccaction_edir':
          $field_committee_value = 'edir';
          break;
        case 'ccagenda_enviro':
        case 'ccaction_enviro':
          $field_committee_value = 'enviro';
          break;
        case 'ccagenda_infrastructure':
        case 'ccaction_infrastructure':
          $field_committee_value = 'infrastructure';
          break;
        case 'ccagenda_psln':
        case 'ccaction_psln':
          $field_committee_value = 'psln';
          break;
        case 'ccagenda_rules_ogir':
        case 'ccaction_rules_ogir':
          $field_committee_value = 'rules-ogir';
          break;
        case 'ccagenda_fire':
        case 'ccaction_fire':
          $field_committee_value = 'fire';
          break;
        case 'ccagenda_budgetfinance':
        case 'ccaction_budgetfinance':
        case 'ccagenda_budget':
        case 'ccaction_budget':
        case 'ccagenda_finance':
        case 'ccaction_finance':
          $field_committee_value = 'budgetfinance';
          break;
        case 'ccagenda_charterrev':
        case 'ccaction_charterrev':
          $field_committee_value = 'charterrev';
          break;
        case 'ccagenda_eds':
        case 'ccaction_eds':
          $field_committee_value = 'eds';
          break;
        case 'ccagenda_geo':
        case 'ccaction_geo':
          $field_committee_value = 'geo';
          break;
        case 'ccagenda_luh':
        case 'ccaction_luh':
          $field_committee_value = 'luh';
          break;
        case 'ccagenda_sglu':
        case 'ccaction_sglu':
          $field_committee_value = 'sglu';
          break;
        case 'ccagenda_nrc':
        case 'ccaction_nrc':
          $field_committee_value = 'nrc';
          break;
        case 'ccagenda_psns':
        case 'ccaction_psns':
          $field_committee_value = 'psns';
          break;
        case 'ccagenda_homeless':
        case 'ccaction_homeless':
          $field_committee_value = 'homeless';
          break;
        default:
          $field_committee_value = 'other';
      }
      $entity->$field_committee->setValue($field_committee_value);
    }
  }
  
  public static function setDocDateYear(EntityInterface $entity): void {
    $field_doc_date_num = 'field_doc_date_num';
    $field_doc_date_year = 'field_doc_date_year';
    if (!$entity->hasField($field_doc_date_year) || !$entity->hasField($field_doc_date_year)) {
      return;
    }
    
    if (is_numeric($entity->$field_doc_date_num->value)) {
      $year = substr($entity->$field_doc_date_num->value, 0, 4);
      $entity->$field_doc_date_year->setValue($year);
    }
  }

  public static function setMuniCodeChapter(EntityInterface $entity): void {
    $field_doc_num = 'field_doc_num';
    $field_muni_code_chapter = 'field_muni_code_chapter';
    if (!$entity->hasField($field_doc_num) || !$entity->hasField($field_muni_code_chapter)) {
      return;
    }
    
    if (!empty($entity->$field_doc_num->value) && (str_starts_with($entity->$field_doc_num->value, 'Ch')) && strlen($entity->$field_doc_num->value) >= 4) {
      $entity->$field_muni_code_chapter->setValue(substr($entity->$field_doc_num->value, 0, 4));
    }
  }
}
