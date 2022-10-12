---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/MigrateRunnerCommands.php
command: migrate:messages
---
# migrate:messages

:octicons-tag-24: 10.4+

View any messages associated with a migration.

#### Examples

- <code>migrate:messages article</code>. Show all messages for the *article* migration
- <code>migrate:messages article --idlist=5</code>. Show messages related to article record with source ID 5.
- <code>migrate:messages node_revision --idlist=1:2,2:3,3:5</code>. Show messages related to node revision records with source IDs [1,2], [2,3], and [3,5].
- <code>migrate:messages custom_node_revision --idlist=1:"r:1",2:"r:3"</code>. Show messages related to node revision records with source IDs [1,"r:1"], and [2,"r:3"].

#### Arguments

- **migrationId**. The ID of the migration.

#### Options

- ** --idlist=IDLIST**. Comma-separated list of IDs to import. As an ID may have more than one column, concatenate the columns with the colon ':' separator.
- ** --format=FORMAT**. Format the result data. Available formats: csv,json,list,null,php,print-r,sections,string,table,tsv,var_dump,var_export,xml,yaml [default: *table*]
- ** --fields=FIELDS**. Available fields: Level (level), Source ID(s) (source_ids), Destination ID(s) (destination_ids), Message (message), Source IDs hash (hash) [default: *level,source_ids,destination_ids,message,hash*]
- ** --field=FIELD**. Select just one field, and force format to *string*.

#### Topics

- [Defining and running migrations.](../../vendor/drush/drush/docs/migrate.md) (docs:migrate)
- [Output formatters and filters: control the command output](../../vendor/drush/drush/docs/output-formats-filters.md) (docs:output-formats-filters)

#### Aliases

- mmsg
- migrate-messages

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.