On the Drupal 7 site:
1. Disable the php filter module on the D7 site before exporting content. The inline PHP breaks the import.
2. In the views_data_export module, replace the views_data_export.theme.inc file with the modified one supplied.
3. Install and enable the d9_migration_views feature.  This supplies the views that generate the CSV files used for imports.

Taxonomy import via drush:
drush import:taxonomy departments
drush import:taxonomy categories
drush import:taxonomy search_keymatch
drush import:taxonomy location

Node imports:
drush mi:import sd_nodes_department --update --force
drush mi:import sd_nodes_department_parent --update --force

Entity creation and associations via drush:
drush import:department
drush import:department-parent

Data status:
Department nodes exported from dev 9/26/2022
Department parent nodes exported from dev 9/26/2022
field_dept_resources_coll field group exported from dev 9/26/2022
field_dept_par_social_links_coll field group exported from dev 9/26/2022
Categories vocabulary exported from dev 9/26/2022
Departments vocabulary exported from dev 9/26/2022
Keymatch vocabulary exported from dev 9/26/2022
Location vocabulary exported from dev 9/26/2022
