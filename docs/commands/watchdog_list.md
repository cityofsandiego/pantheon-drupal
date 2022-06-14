---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/WatchdogCommands.php
command: watchdog:list
---
# watchdog:list

Interactively filter the watchdog message listing.

#### Examples

- <code>drush watchdog:list</code>. Prompt for message type or severity, then run watchdog-show.

#### Arguments

- **[substring]**. A substring to look search in error messages.

#### Options

- ** --format[=FORMAT]**. Format the result data. Available formats: csv,json,list,null,php,print-r,sections,string,table,tsv,var_dump,var_export,xml,yaml [default: *table*]
- ** --count[=COUNT]**. The number of messages to show. [default: *10*]
- ** --extended**. Return extended information about each message.
- ** --severity**. Restrict to messages of a given severity level.
- ** --type**. Restrict to messages of a given type.
- ** --fields=FIELDS**. Available fields: ID (wid), Type (type), Message (message), Severity (severity), Location (location), Hostname (hostname), Date (date), Username (username) [default: *wid,date,type,severity,message*]
- ** --field=FIELD**. Select just one field, and force format to *string*.

#### Topics

- [Output formatters and filters: control the command output](../../vendor/drush/drush/docs/output-formats-filters.md) (docs:output-formats-filters)

#### Aliases

- wd-list
- watchdog-list

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.