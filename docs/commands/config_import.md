---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/config/ConfigImportCommands.php
command: config:import
---
# config:import

Import config from a config directory.

#### Options

- ** --source=SOURCE**. An arbitrary directory that holds the configuration files.
- ** --partial**. Allows for partial config imports from the source directory. Only updates and new configs will be processed with this flag (missing configs will not be deleted). No config transformation happens.
- ** --diff**. Show preview as a diff.

#### Topics

- [Deploy command for Drupal.](../../vendor/drush/drush/docs/deploycommand.md) (docs:deploy)

#### Aliases

- cim
- config-import

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.