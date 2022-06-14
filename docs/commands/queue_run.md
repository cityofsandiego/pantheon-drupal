---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/QueueCommands.php
command: queue:run
---
# queue:run

Run a specific queue by name.

#### Arguments

- **name**. The name of the queue to run, as defined in either hook_queue_info or hook_cron_queue_info.

#### Options

- ** --time-limit=TIME-LIMIT**. The maximum number of seconds allowed to run the queue.
- ** --items-limit=ITEMS-LIMIT**. The maximum number of items allowed to run the queue.
- ** --lease-time=LEASE-TIME**. The maximum number of seconds that an item remains claimed.

#### Aliases

- queue-run

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.