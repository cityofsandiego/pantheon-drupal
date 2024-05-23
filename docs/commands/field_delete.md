---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/field/FieldDeleteCommands.php
command: field:delete
---
# field:delete

:octicons-tag-24: 11.0+

Delete a field

#### Examples

- <code>drush field:delete</code>. Delete a field by answering the prompts.
- <code>drush field-delete taxonomy_term tag</code>. Delete a field and fill in the remaining information through prompts.
- <code>drush field-delete taxonomy_term tag --field-name=field_tag_label</code>. Delete a field in a non-interactive way.

#### Arguments

- **[entityType]**. The machine name of the entity type
- **[bundle]**. The machine name of the bundle

#### Options

- ** --field-name=FIELD-NAME**. The machine name of the field
- ** --show-machine-names[=SHOW-MACHINE-NAMES]**. Show machine names instead of labels in option lists.

#### Aliases

- field-delete
- fd

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.