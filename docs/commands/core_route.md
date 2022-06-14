---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/DrupalCommands.php
command: core:route
---
# core:route

:octicons-tag-24: 10.5+

View information about all routes or one route.

#### Examples

- <code>drush route</code>. View all routes.
- <code>drush route --name=update.status</code>. View details about the *update.status* route.
- <code>drush route --path=/user/1</code>. View details about the *entity.user.canonical* route.

#### Options

- ** --name=NAME**. A route name.
- ** --path=PATH**. An internal path.
- ** --format[=FORMAT]**.  [default: *yaml*]

#### Aliases

- route

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.