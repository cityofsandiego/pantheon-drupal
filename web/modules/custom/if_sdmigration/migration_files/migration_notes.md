On the Drupal 7 site:
1. Disable the php filter module on the D7 site before exporting content. The inline PHP breaks the import.
2. In the views_data_export module, replace the views_data_export.theme.inc file with the modified one supplied.
3. Install and enable the d9_migration_views feature.  This supplies the views that generate the CSV files used for imports.

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

Entity creation and associations via drush:
lando terminus drush import:department
lando terminus drush import:department-parent
lando terminus drush import:bucket

Data status: 9/26/2022
Nodes:
Bucket
Department
Department parent
Location
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
Taxonomies:
Bucket
Categories
Department
Search KeyMatch
Location
