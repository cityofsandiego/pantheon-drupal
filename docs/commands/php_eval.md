---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/core/PhpCommands.php
command: php:eval
---
# php:eval

Evaluate arbitrary php code after bootstrapping Drupal (if available).

#### Examples

- <code>drush php:eval '$node = \Drupal\node\Entity\Node::load(1); print $node->getTitle();'</code>. Loads node with nid 1 and then prints its title.
- <code>drush php:eval "\Drupal::service('file_system')->copy('$HOME/Pictures/image.jpg', 'public://image.jpg');"</code>. Copies a file whose path is determined by an environment's variable. Use of double quotes so the variable $HOME gets replaced by its value.
- <code>drush php:eval "node_access_rebuild();"</code>. Rebuild node access permissions.

#### Arguments

- **code**. PHP code. If shell escaping gets too tedious, consider using the php:script command.

#### Options

- ** --format[=FORMAT]**.  [default: *var_export*]

#### Aliases

- eval
- ev
- php-eval

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.