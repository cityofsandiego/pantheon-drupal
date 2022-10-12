---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/EntityCommands.php
command: entity:delete
---
# entity:delete

Delete content entities.

To delete configuration entities, see config:delete command.

#### Examples

- <code>drush entity:delete node --bundle=article</code>. Delete all article entities.
- <code>drush entity:delete shortcut</code>. Delete all shortcut entities.
- <code>drush entity:delete node 22,24</code>. Delete nodes 22 and 24.
- <code>drush entity:delete node --exclude=9,14,81</code>. Delete all nodes except node 9, 14 and 81.
- <code>drush entity:delete user</code>. Delete all users except uid=1.
- <code>drush entity:delete node --chunks=5</code>. Delete all node entities in steps of 5.

#### Arguments

- **entity_type**. An entity machine name.
- **[ids]**. A comma delimited list of Ids.

#### Options

- ** --bundle=BUNDLE**. Restrict deletion to the specified bundle. Ignored when ids is specified.
- ** --exclude=EXCLUDE**. Exclude certain entities from deletion. Ignored when ids is specified.
- ** --chunks[=CHUNKS]**. Define how many entities will be deleted in the same step. [default: *50*]

#### Aliases

- edel
- entity-delete

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.