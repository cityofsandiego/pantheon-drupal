---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/MigrateRunnerCommands.php
command: migrate:status
---
# migrate:status

:octicons-tag-24: 10.4+

List all migrations with current status.

#### Examples

- <code>migrate:status</code>. Retrieve status for all migrations
- <code>migrate:status --tag</code>. Retrieve status for all migrations, grouped by tag
- <code>migrate:status --tag=user,main_content</code>. Retrieve status for all migrations tagged with *user* or *main_content*
- <code>migrate:status classification,article</code>. Retrieve status for specific migrations
- <code>migrate:status --field=id</code>. Retrieve a raw list of migration IDs.
- <code>ms --fields=id,status --format=json</code>. Retrieve a Json serialized list of migrations, each item containing only the migration ID and its status.

#### Arguments

- **[migrationIds]**. Restrict to a comma-separated list of migrations. Optional.

#### Options

- ** --tag=TAG**. A comma-separated list of migration tags to list. If only *--tag* is provided, all tagged migrations will be listed, grouped by tags.
- ** --names-only**. [Deprecated, use --field=id instead] Only return names, not all the details (faster).
- ** --format=FORMAT**. Format the result data. Available formats: csv,json,list,null,php,print-r,sections,string,table,tsv,var_dump,var_export,xml,yaml [default: *table*]
- ** --fields=FIELDS**. Available fields: Migration ID (id), Status (status), Total (total), Imported (imported), Needing update (needing_update), Unprocessed (unprocessed), Last Imported (last_imported) [default: *id,status,total,imported,unprocessed,last_imported*]
- ** --field=FIELD**. Select just one field, and force format to *string*.
- ** --filter[=FILTER]**. Filter output based on provided expression

#### Topics

- [Defining and running migrations.](../../vendor/drush/drush/docs/migrate.md) (docs:migrate)
- [Output formatters and filters: control the command output](../../vendor/drush/drush/docs/output-formats-filters.md) (docs:output-formats-filters)

#### Aliases

- ms
- migrate-status

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.