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
lando terminus drush mi:import sd_nodes_event -- --update --force
lando terminus drush mi:import sd_nodes_gallery -- --update --force
lando terminus drush mi:import sd_nodes_digital_archives_photos -- --update --force
lando terminus drush mi:import sd_nodes_article -- --update --force
lando terminus drush mi:import sd_bean -- --update --force
lando terminus drush mi:import sd_nodes_resource -- --update --force
lando terminus drush mi:import sd_nodes_application -- --update --force
lando terminus drush mi:import sd_nodes_webform -- --update --force

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
lando terminus drush import:event
lando terminus drush import:gallery
lando terminus drush import:digital_archives_photos 
lando terminus drush import:article
lando terminus drush import:resource 
lando terminus drush import:webform

Node data status:
6/22/2023 (DB backup from 9:30am EDT)
Bucket
Business Resource
Date
Mayoral artifacts
Registration
Application**
Article**
Digital Archives Photos**
Department document**
Department parent**
External data**
Reusable Component (bean custom blocks)**
Sidebar Block Context (contexts)**
Hero*
Slide*
Gallery*
Location*
Resource*

**3/2/2023
Blog
Department
Outreach2 Article
Outreach2
Outreach
Event
Webform (nodes, not webforms themselves)

Field groups:
field_bucket_events_pi_coll
field_bucket_featured_cards_coll
field_bucket_featured_coll
field_dept_resources_coll (updated 3/2)
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

D7 DB import command:
/usr/bin/mysql --max_allowed_packet=1000M --database=pantheon --user=pantheon --password=pantheon --host=127.0.0.1 --port=32976 < /home/andrew/Sites/SAND/sand01/sdgov_live_2023-06-22T13-30-07_UTC_database_split/sdgov_live_2023-06-22T13-30-07_UTC_database_00.sql
