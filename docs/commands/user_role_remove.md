---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/UserCommands.php
command: user:role:remove
---
# user:role:remove

Remove a role from the specified user accounts.

#### Examples

- <code>drush user:remove-role "power user" user3</code>. Remove the "power user" role from user3

#### Arguments

- **role**. The name of the role to add
- **[names]**. A comma delimited list of user names.

#### Options

- ** --uid=UID**. A comma delimited list of user ids to lookup (an alternative to names).
- ** --mail=MAIL**. A comma delimited list of emails to lookup (an alternative to names).

#### Aliases

- urrol
- user-remove-role

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.