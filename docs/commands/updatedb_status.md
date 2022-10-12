---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/core/UpdateDBCommands.php
command: updatedb:status
---
# updatedb:status

List any pending database updates.

#### Options

- ** --format[=FORMAT]**. Format the result data. Available formats: csv,json,list,null,php,print-r,sections,string,table,tsv,var_dump,var_export,xml,yaml [default: *table*]
- ** --post-updates[=POST-UPDATES]**. Show post updates. [default: *1*]
- ** --no-post-updates**. Negate --post-updates option.
- ** --fields=FIELDS**. Available fields: Module (module), Update ID (update_id), Description (description), Type (type) [default: *module,update_id,type,description*]
- ** --field=FIELD**. Select just one field, and force format to *string*.
- ** --filter[=FILTER]**. Filter output based on provided expression

#### Topics

- [Output formatters and filters: control the command output](../../vendor/drush/drush/docs/output-formats-filters.md) (docs:output-formats-filters)

#### Aliases

- updbst
- updatedb-status

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.