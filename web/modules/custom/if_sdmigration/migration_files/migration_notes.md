On the Drupal 7 site:
1. Disable the php filter module on the D7 site before exporting content. The inline PHP breaks the import.
2. In the views_data_export module, replace the views_data_export.theme.inc file with the modified one supplied.
3. Install and enable the d9_migration_views feature.  This supplies the views that generate the CSV files used for imports.
4. Raw database table (CSV files) include blocks/contexts.csv, menu_custom.csv, and menu_links.csv.

Taxonomy import via drush:
lando terminus drush import:taxonomy department
lando terminus drush import:taxonomy categories
lando terminus drush import:taxonomy search_keymatch
lando terminus drush import:taxonomy location
lando terminus drush import:taxonomy bucket
lando terminus drush import:taxonomy business_resources_organization
lando terminus drush import:taxonomy business_resources_target_bus
lando terminus drush import:taxonomy business_resources_type_assist
lando terminus drush import:taxonomy event
lando terminus drush import:taxonomy registration

Node imports:
lando terminus drush mi:import sd_nodes_department -- --update --force
lando terminus drush mi:import sd_nodes_department_parent -- --update --force
lando terminus drush mi:import sd_nodes_bucket -- --update --force
lando terminus drush mi:import sd_nodes_location -- --update --force
lando terminus drush mi:import sd_nodes_slide -- --update --force
lando terminus drush mi:import sd_nodes_mayoral_artifact -- --update --force
lando terminus drush mi:import sd_nodes_outreach -- --update --force
lando terminus drush mi:import sd_nodes_hero -- --update --force
lando terminus drush mi:import sd_nodes_outreach2 -- --update --force
lando terminus drush mi:import sd_nodes_department_document -- --update --force
lando terminus drush mi:import sd_nodes_blog -- --update --force
lando terminus drush mi:import sd_nodes_outreach2_article -- --update --force
lando terminus drush mi:import sd_nodes_business_resource -- --update --force
lando terminus drush mi:import sd_nodes_registration -- --update --force

Menu import:
lando terminus drush import:menus

Entity creation and associations:
lando terminus drush import:department
lando terminus drush import:department-parent
lando terminus drush import:bucket
lando terminus drush import:location
lando terminus drush import:mayoral-artifact
lando terminus drush import:outreach
lando terminus drush import:reusable-components
lando terminus drush import:hero
lando terminus drush import:outreach2
lando terminus drush import:department_document
lando terminus drush import:external_data 
  * Note: this does entirety of external_data node import; need to specify specific file.  Split into 12 CSV files.
lando terminus drush import:blog
lando terminus drush import:outreach2_article
lando terminus drush import:business_resource
lando terminus drush import:registration

Fix class names/HTML content cleanup:
lando terminus drush import:class-fixes

Data status: 9/26/2022

Nodes:
Bucket
Department
Department parent
Location
Slide
Mayoral artifacts
Outreach
Hero
Outreach2
Department document
External data
Date (Manually entered nodes as there were few and it was quicker to do so.)

Data status: 2/6/2023

Nodes:
Blog
Outreach2 Article
Business Resource
Digital Archives Photos
Event
Gallery
Registration

Field groups:
field_bucket_events_pi_coll
field_bucket_featured_cards_coll
field_bucket_featured_coll
field_dept_resources_coll
field_dept_par_social_links_coll
field_location_exceptions_coll
field_location_exceptions_coll2
field_location_amenities_coll
field_location_restrictions_coll
field_outreach_sections_coll
field_outreach_sections_coll2

Taxonomies:
Bucket
Categories
Department
Search KeyMatch
Location
Business Resources Organization
Business Resources Target Business
Business Resources Type of Assistance
Registration
Event
