---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/RoleCommands.php
command: role:perm:add
---
# role:perm:add

Grant specified permission(s) to a role.

#### Examples

- <code>drush role:perm:add anonymous 'post comments'</code>. Allow anon users to post comments.
- <code>drush role:perm:add anonymous 'post comments,access content'</code>. Allow anon users to post comments and access content.

#### Arguments

- **machine_name**. The role to modify.
- **permissions**. The list of permission to grant, delimited by commas.

#### Aliases

- rap
- role-add-perm

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.