---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/WatchdogCommands.php
command: watchdog:tail
---
# watchdog:tail

:octicons-tag-24: 10.6+

Tail watchdog messages.

#### Examples

- <code>drush watchdog:tail</code>. Continuously tail watchdog messages.
- <code>drush watchdog:tail "cron run successful"</code>. Continously tail watchdog messages, filtering on the string *cron run successful*.
- <code>drush watchdog:tail --severity=Notice</code>. Continously tail watchdog messages, filtering severity of notice.
- <code>drush watchdog:tail --type=php</code>. Continously tail watchdog messages, filtering on type equals php.

#### Arguments

- **[substring]**. A substring to look search in error messages.

#### Options

- ** --severity=SEVERITY**. Restrict to messages of a given severity level.
- ** --type=TYPE**. Restrict to messages of a given type.
- ** --extended**. Return extended information about each message.

#### Aliases

- wd-tail
- wt
- watchdog-tail

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.