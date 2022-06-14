---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/core/StatusCommands.php
command: core:status
---
# core:status

An overview of the environment - Drush and Drupal.

#### Examples

- <code>drush core-status --field=files</code>. Emit just one field, not all the default fields.
- <code>drush core-status --fields=*</code>. Emit all fields, not just the default ones.

#### Arguments

- **[filter]**. A field to filter on. @deprecated - use --field option instead.

#### Options

- ** --project=PROJECT**. A comma delimited list of projects. Their paths will be added to path-aliases section.
- ** --format[=FORMAT]**. Format the result data. Available formats: csv,json,list,null,php,print-r,string,table,tsv,var_dump,var_export,xml,yaml [default: *table*]
- ** --fields=FIELDS**. Available fields: Drupal version (drupal-version), Site URI (uri), DB driver (db-driver), DB hostname (db-hostname), DB port (db-port), DB username (db-username), DB password (db-password), DB name (db-name), Database (db-status), Drupal bootstrap (bootstrap), Default theme (theme), Admin theme (admin-theme), PHP binary (php-bin), PHP config (php-conf), PHP OS (php-os), Drush script (drush-script), Drush version (drush-version), Drush temp (drush-temp), Drush configs (drush-conf), Drush aliases (drush-alias-files), Alias search paths (alias-searchpaths), Install profile (install-profile), Drupal root (root), Drupal Settings (drupal-settings-file), Site path (site-path), Site path (site), Themes path (themes), Modules path (modules), Files, Public (files), Files, Private (private), Files, Temp (temp), Drupal config (config-sync), Files, Public (files-path), Files, Temp (temp-path), Other paths (%paths) [default: drupal-version,uri,db-driver,db-hostname,db-port,db-username,db-name,db-status,bootstrap,theme,admin-theme,php-bin,php-conf,php-os,drush-script,drush-version,drush-temp,drush-conf,install-profile,root,site,files,private,temp]
- ** --field=FIELD**. Select just one field, and force format to *string*.

#### Topics

- [README.md](https://raw.githubusercontent.com/drush-ops/drush/11.x/README.md) (docs:readme)
- [Output formatters and filters: control the command output](../../vendor/drush/drush/docs/output-formats-filters.md) (docs:output-formats-filters)

#### Aliases

- status
- st
- core-status

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.