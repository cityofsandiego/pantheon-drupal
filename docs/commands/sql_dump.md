---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/sql/SqlCommands.php
command: sql:dump
---
# sql:dump

Exports the Drupal DB as SQL using mysqldump or equivalent.

#### Examples

- <code>drush sql:dump --result-file=../18.sql</code>. Save SQL dump to the directory above Drupal root.
- <code>drush sql:dump --skip-tables-key=common</code>. Skip standard tables. See [Drush configuration](../using-drush-configuration)
- <code>drush sql:dump --extra-dump=--no-data</code>. Pass extra option to *mysqldump* command.

#### Options

- ** --result-file=RESULT-FILE**. Save to a file. The file should be relative to Drupal root. If --result-file is provided with the value 'auto', a date-based filename will be created under ~/drush-backups directory.
- ** --create-db**. Omit DROP TABLE statements. Used by Postgres and Oracle only.
- ** --data-only**. Dump data without statements to create any of the schema.
- ** --ordered-dump**. Order by primary key and add line breaks for efficient diffs. Slows down the dump. Mysql only.
- ** --gzip**. Compress the dump using the gzip program which must be in your *$PATH*.
- ** --extra=EXTRA**. Add custom arguments/options when connecting to database (used internally to list tables).
- ** --extra-dump=EXTRA-DUMP**. Add custom arguments/options to the dumping of the database (e.g. *mysqldump* command).
- ** --format[=FORMAT]**. Format the result data. Available formats: csv,json,list,null,php,print-r,string,table,tsv,var_dump,var_export,xml,yaml [default: *null*]
- ** --fields=FIELDS**. Available fields: Path (path)
- ** --field=FIELD**. Select just one field, and force format to *string*.
- ** --database[=DATABASE]**. The DB connection key if using multiple connections in settings.php. [default: *default*]
- ** --target[=TARGET]**. The name of a target within the specified database connection. [default: *default*]
- ** --db-url=DB-URL**. A Drupal 6 style database URL. For example *mysql://root:pass@localhost:port/dbname*
- ** --show-passwords**. Show password on the CLI. Useful for debugging.
- ** --skip-tables-key=SKIP-TABLES-KEY**. A key in the $skip_tables array. @see [Site aliases](../site-aliases.md)
- ** --structure-tables-key=STRUCTURE-TABLES-KEY**. A key in the $structure_tables array. @see [Site aliases](../site-aliases.md)
- ** --tables-key=TABLES-KEY**. A key in the $tables array.
- ** --skip-tables-list=SKIP-TABLES-LIST**. A comma-separated list of tables to exclude completely.
- ** --structure-tables-list=STRUCTURE-TABLES-LIST**. A comma-separated list of tables to include for structure, but not data.
- ** --tables-list=TABLES-LIST**. A comma-separated list of tables to transfer.

#### Topics

- [Output formatters and filters: control the command output](../../vendor/drush/drush/docs/output-formats-filters.md) (docs:output-formats-filters)

#### Aliases

- sql-dump

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.