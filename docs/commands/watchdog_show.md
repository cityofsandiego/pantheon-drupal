---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/WatchdogCommands.php
command: watchdog:show
---
# watchdog:show

Show watchdog messages.

#### Examples

- <code>drush watchdog:show</code>. Show a listing of most recent 10 messages.
- <code>drush watchdog:show "cron run successful"</code>. Show a listing of most recent 10 messages containing the string *cron run successful*.
- <code>drush watchdog:show --count=46</code>. Show a listing of most recent 46 messages.
- <code>drush watchdog:show --severity=Notice</code>. Show a listing of most recent 10 messages with a severity of notice.
- <code>drush watchdog:show --type=php</code>. Show a listing of most recent 10 messages of type php

#### Arguments

- **[substring]**. A substring to look search in error messages.

#### Options

- ** --format[=FORMAT]**. Format the result data. Available formats: csv,json,list,null,php,print-r,sections,string,table,tsv,var_dump,var_export,xml,yaml [default: *table*]
- ** --count[=COUNT]**. The number of messages to show. [default: *10*]
- ** --severity=SEVERITY**. Restrict to messages of a given severity level.
- ** --type=TYPE**. Restrict to messages of a given type.
- ** --extended**. Return extended information about each message.
- ** --fields=FIELDS**. Available fields: ID (wid), Type (type), Message (message), Severity (severity), Location (location), Hostname (hostname), Date (date), Username (username) [default: *wid,date,type,severity,message*]
- ** --field=FIELD**. Select just one field, and force format to *string*.
- ** --filter[=FILTER]**. Filter output based on provided expression

#### Topics

- [Output formatters and filters: control the command output](../../vendor/drush/drush/docs/output-formats-filters.md) (docs:output-formats-filters)

#### Aliases

- wd-show
- ws
- watchdog-show

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.