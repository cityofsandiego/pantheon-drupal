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

Node imports:
lando terminus drush mi:import sd_nodes_department -- --update --force
lando terminus drush mi:import sd_nodes_department_parent -- --update --force
lando terminus drush mi:import sd_nodes_bucket -- --update --force
lando terminus drush mi:import sd_nodes_location -- --update --force
lando terminus drush mi:import sd_nodes_slide -- --update --force
lando terminus drush mi:import sd_nodes_mayoral_artifact -- --update --force
lando terminus drush mi:import sd_nodes_outreach -- --update --force
lando terminus drush mi:import sd_nodes_hero -- --update --force

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

Field groups:
field_bucket_events_pi_coll
field_bucket_featured_cards_coll
field_bucket_featured_coll
field_dept_resources_coll
field_dept_par_social_links_coll
field_location_exceptions_coll
field_location_exceptions_coll2
field_location_amenities
field_location_restrictions
field_outreach_sections_coll

Taxonomies:
Bucket
Categories
Department
Search KeyMatch
Location
