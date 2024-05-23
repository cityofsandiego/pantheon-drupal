---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/sql/SqlSyncCommands.php
command: sql:sync
---
# sql:sync

Copy DB data from a source site to a target site. Transfers data via rsync.

#### Examples

- <code>drush sql:sync @source @self</code>. Copy the database from the site with the alias 'source' to the local site.
- <code>drush sql:sync @self @target</code>. Copy the database from the local site to the site with the alias 'target'.
- <code>drush sql:sync #prod #dev</code>. Copy the database from the site in /sites/prod to the site in /sites/dev (multisite installation).

#### Arguments

- **source**. A site-alias or the name of a subdirectory within /sites whose database you want to copy from.
- **target**. A site-alias or the name of a subdirectory within /sites whose database you want to replace.

#### Options

- ** --no-dump**. Do not dump the sql database; always use an existing dump file.
- ** --no-sync**. Do not rsync the database dump file from source to target.
- ** --runner=RUNNER**. Where to run the rsync command; defaults to the local site. Can also be *source* or *target*.
- ** --create-db**. Create a new database before importing the database dump on the target machine.
- ** --db-su=DB-SU**. Account to use when creating a new database (e.g. *root*).
- ** --db-su-pw=DB-SU-PW**. Password for the db-su account.
- ** --target-dump=TARGET-DUMP**. The path for storing the sql-dump on target machine.
- ** --source-dump[=SOURCE-DUMP]**. The path for retrieving the sql-dump on source machine.
- ** --extra-dump=EXTRA-DUMP**. Add custom arguments/options to the dumping of the database (e.g. mysqldump command).
- ** --skip-tables-key=SKIP-TABLES-KEY**. A key in the $skip_tables array. @see [Site aliases](../site-aliases.md)
- ** --structure-tables-key=STRUCTURE-TABLES-KEY**. A key in the $structure_tables array. @see [Site aliases](../site-aliases.md)
- ** --tables-key=TABLES-KEY**. A key in the $tables array.
- ** --skip-tables-list=SKIP-TABLES-LIST**. A comma-separated list of tables to exclude completely.
- ** --structure-tables-list=STRUCTURE-TABLES-LIST**. A comma-separated list of tables to include for structure, but not data.
- ** --tables-list=TABLES-LIST**. A comma-separated list of tables to transfer.

#### Topics

- [Creating site aliases for running Drush on remote sites.](../../vendor/drush/drush/docs/site-aliases.md) (docs:aliases)
- [Example policy file.](https://raw.githubusercontent.com/drush-ops/drush/11.x/examples/Commands/PolicyCommands.php) (docs:policy)
- [Drush configuration.](../../vendor/drush/drush/docs/using-drush-configuration.md) (docs:configuration)
- [Extend sql-sync to allow transfer of the sql dump file via http.](https://raw.githubusercontent.com/drush-ops/drush/11.x/examples/Commands/SyncViaHttpCommands.php) (docs:example-sync-via-http)

#### Aliases

- sql-sync

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.