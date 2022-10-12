---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/UserCommands.php
command: user:unblock
---
# user:unblock

Unblock the specified user(s).

#### Examples

- <code>drush user:unblock user3</code>. Unblock the users with name user3

#### Arguments

- **[names]**. A comma delimited list of user names.

#### Options

- ** --uid=UID**. A comma delimited list of user ids to lookup (an alternative to names).
- ** --mail=MAIL**. A comma delimited list of emails to lookup (an alternative to names).

#### Aliases

- uublk
- user-unblock

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.