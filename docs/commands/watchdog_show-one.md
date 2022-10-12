---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/WatchdogCommands.php
command: watchdog:show-one
---
# watchdog:show-one

Show one log record by ID.

#### Arguments

- **id**. Watchdog Id

#### Options

- ** --format[=FORMAT]**. Format the result data. Available formats: csv,json,list,null,php,print-r,string,table,tsv,var_dump,var_export,xml,yaml [default: *yaml*]
- ** --fields=FIELDS**. Limit output to only the listed elements. Name top-level elements by key, e.g. "--fields=name,date", or use dot notation to select a nested element, e.g. "--fields=a.b.c as example".
- ** --field=FIELD**. Select just one field, and force format to *string*.

#### Aliases

- wd-one
- watchdog-show-one

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.