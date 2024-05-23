---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/field/FieldBaseOverrideCreateCommands.php
command: field:base-override-create
---
# field:base-override-create

:octicons-tag-24: 11.0+

Create a new base field override

#### Examples

- <code>drush field:base-field-override-create</code>. Create a base field override by answering the prompts.
- <code>drush field:base-field-override-create taxonomy_term tag</code>. Create a base field override and fill in the remaining information through prompts.
- <code>drush field:base-field-override-create taxonomy_term tag --field-name=name --field-label=Label --is-required=1</code>. Create a base field override in a completely non-interactive way.

#### Arguments

- **[entityType]**. The machine name of the entity type
- **[bundle]**. The machine name of the bundle

#### Options

- ** --field-name=FIELD-NAME**. A unique machine-readable name containing letters, numbers, and underscores.
- ** --field-label=FIELD-LABEL**. The field label
- ** --field-description=FIELD-DESCRIPTION**. The field description
- ** --is-required=IS-REQUIRED**. Whether the field is required
- ** --show-machine-names[=SHOW-MACHINE-NAMES]**. Show machine names instead of labels in option lists.

#### Aliases

- bfoc

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.