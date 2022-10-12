---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/QueueCommands.php
command: queue:delete
---
# queue:delete

Delete all items in a specific queue.

#### Arguments

- **name**. The name of the queue to run, as defined in either hook_queue_info or hook_cron_queue_info.

#### Aliases

- queue-delete

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.