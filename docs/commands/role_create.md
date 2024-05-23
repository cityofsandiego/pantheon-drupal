---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/RoleCommands.php
command: role:create
---
# role:create

Create a new role.

#### Examples

- <code>drush role:create 'test role' 'Test role'</code>. Create a new role with a machine name of 'test role', and a human-readable name of 'Test role'.

#### Arguments

- **machine_name**. The symbolic machine name for the role.
- **[human_readable_name]**. A descriptive name for the role.

#### Aliases

- rcrt
- role-create

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.