---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/RoleCommands.php
command: role:perm:remove
---
# role:perm:remove

Remove specified permission(s) from a role.

#### Examples

- <code>drush role:remove-perm anonymous 'post comments,access content'</code>. Remove 2 permissions from anon users.

#### Arguments

- **machine_name**. The role to modify.
- **permissions**. The list of permission to grant, delimited by commas.

#### Aliases

- rmp
- role-remove-perm

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.