---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/StateCommands.php
command: state:delete
---
# state:delete

Delete a state entry.

#### Examples

- <code>drush state:del system.cron_last</code>. Delete state entry for system.cron_last.

#### Arguments

- **key**. The state key, for example *system.cron_last*.

#### Aliases

- sdel
- state-delete

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.