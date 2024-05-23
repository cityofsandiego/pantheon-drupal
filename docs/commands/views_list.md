---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/ViewsCommands.php
command: views:list
---
# views:list

Get a list of all views in the system.

#### Examples

- <code>drush vl</code>. Show a list of all available views.
- <code>drush vl --name=blog</code>. Show a list of views which names contain 'blog'.
- <code>drush vl --tags=tag1,tag2</code>. Show a list of views tagged with 'tag1' or 'tag2'.
- <code>drush vl --status=enabled</code>. Show a list of enabled views.

#### Options

- ** --name=NAME**. A string contained in the view's name to filter the results with.
- ** --tags=TAGS**. A comma-separated list of views tags by which to filter the results.
- ** --status=STATUS**. Filter views by status. Choices: enabled, disabled.
- ** --format[=FORMAT]**. Format the result data. Available formats: csv,json,list,null,php,print-r,sections,string,table,tsv,var_dump,var_export,xml,yaml [default: *table*]
- ** --fields=FIELDS**. Available fields: Machine name (machine-name), Name (label), Description (description), Status (status), Tag (tag) [default: *machine-name,label,description,status*]
- ** --field=FIELD**. Select just one field, and force format to *string*.
- ** --filter[=FILTER]**. Filter output based on provided expression

#### Topics

- [Output formatters and filters: control the command output](../../vendor/drush/drush/docs/output-formats-filters.md) (docs:output-formats-filters)

#### Aliases

- vl
- views-list

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.