---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/UserCommands.php
command: user:password
---
# user:password

Set the password for the user account with the specified name.

#### Examples

- <code>drush user:password someuser "correct horse battery staple"</code>. Set the password for the username someuser. See https://xkcd.com/936

#### Arguments

- **name**. The name of the account to modify.
- **password**. The new password for the account.

#### Aliases

- upwd
- user-password

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.