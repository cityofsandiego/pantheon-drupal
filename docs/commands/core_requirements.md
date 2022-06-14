---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/DrupalCommands.php
command: core:requirements
---
# core:requirements

Information about things that may be wrong in your Drupal installation.

#### Examples

- <code>drush core:requirements</code>. Show all status lines from the Status Report admin page.
- <code>drush core:requirements --severity=2</code>. Show only the red lines from the Status Report admin page.

#### Options

- ** --format[=FORMAT]**. Format the result data. Available formats: csv,json,list,null,php,print-r,sections,string,table,tsv,var_dump,var_export,xml,yaml [default: *table*]
- ** --severity[=SEVERITY]**. Only show status report messages with a severity greater than or equal to the specified value. [default: *-1*]
- ** --ignore[=IGNORE]**. Comma-separated list of requirements to remove from output. Run with --format=yaml to see key values to use.
- ** --fields=FIELDS**. Available fields: Title (title), Severity (severity), SID (sid), Description (description), Summary (value) [default: *title,severity,value*]
- ** --field=FIELD**. Select just one field, and force format to *string*.
- ** --filter[=FILTER]**. Filter output based on provided expression

#### Topics

- [Output formatters and filters: control the command output](../../vendor/drush/drush/docs/output-formats-filters.md) (docs:output-formats-filters)

#### Aliases

- status-report
- rq
- core-requirements

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.