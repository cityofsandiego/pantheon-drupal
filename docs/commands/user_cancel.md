---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/UserCommands.php
command: user:cancel
---
# user:cancel

Cancel user account(s) with the specified name(s).

#### Examples

- <code>drush user:cancel username</code>. Cancel the user account with the name username and anonymize all content created by that user.
- <code>drush user:cancel --delete-content username</code>. Delete the user account with the name username and delete all content created by that user.

#### Arguments

- **names**. A comma delimited list of user names.

#### Options

- ** --delete-content**. Delete the user, and all content created by the user
- ** --uid=UID**. A comma delimited list of user ids to lookup (an alternative to names).
- ** --mail=MAIL**. A comma delimited list of emails to lookup (an alternative to names).

#### Aliases

- ucan
- user-cancel

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.