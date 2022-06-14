---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/StateCommands.php
command: state:set
---
# state:set

Set a state value.

#### Examples

- <code>drush sset system.maintenance_mode 1 --input-format=integer</code>. Put site into Maintenance mode.
- <code>drush state:set system.cron_last 1406682882 --input-format=integer</code>. Sets a timestamp for last cron run.
- <code>php -r "print json_encode(array(\'drupal\', \'simpletest\'));"  | drush state-set --input-format=json foo.name -</code>. Set a key to a complex value (e.g. array)

#### Arguments

- **key**. The state key, for example: *system.cron_last*.
- **value**. The value to assign to the state key. Use *-* to read from Stdin.

#### Options

- ** --input-format[=INPUT-FORMAT]**. Type for the value. Other recognized values: string, integer, float, boolean, json, yaml. [default: *auto*]

#### Aliases

- sset
- state-set

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.