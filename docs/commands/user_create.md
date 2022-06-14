---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/UserCommands.php
command: user:create
---
# user:create

Create a user account.

#### Examples

- <code>drush user:create newuser --mail="person@example.com" --password="letmein"</code>. Create a new user account with the name newuser, the email address person@example.com, and the password letmein

#### Arguments

- **name**. The name of the account to add

#### Options

- ** --password=PASSWORD**. The password for the new account
- ** --mail=MAIL**. The email address for the new account

#### Aliases

- ucrt
- user-create

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.