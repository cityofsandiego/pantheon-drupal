---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/core/UpdateDBCommands.php
command: updatedb
---
# updatedb

Apply any database updates required (as with running update.php).

#### Options

- ** --cache-clear[=CACHE-CLEAR]**. Clear caches upon completion. [default: *1*]
- ** --post-updates[=POST-UPDATES]**. Run post updates after hook_update_n and entity updates. [default: *1*]
- ** --no-cache-clear**. Negate --cache-clear option.
- ** --no-post-updates**. Negate --post-updates option.

#### Topics

- [Deploy command for Drupal.](../../vendor/drush/drush/docs/deploycommand.md) (docs:deploy)

#### Aliases

- updb

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.