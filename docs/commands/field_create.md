---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/field/FieldCreateCommands.php
command: field:create
---
# field:create

:octicons-tag-24: 11.0+

Create a new field

#### Examples

- <code>drush field:create</code>. Create a field by answering the prompts.
- <code>drush field-create taxonomy_term tag</code>. Create a field and fill in the remaining information through prompts.
- <code>drush field-create taxonomy_term tag --field-name=field_tag_label --field-label=Label --field-type=string --field-widget=string_textfield --is-required=1 --cardinality=2</code>. Create a field in a completely non-interactive way.

#### Arguments

- **[entityType]**. The machine name of the entity type
- **[bundle]**. The machine name of the bundle

#### Options

- ** --field-name=FIELD-NAME**. A unique machine-readable name containing letters, numbers, and underscores.
- ** --field-label=FIELD-LABEL**. The field label
- ** --field-description[=FIELD-DESCRIPTION]**. Instructions to present to the user below this field on the editing form.
- ** --field-type=FIELD-TYPE**. The field type
- ** --field-widget=FIELD-WIDGET**. The field widget
- ** --is-required[=IS-REQUIRED]**. Whether the field is required
- ** --is-translatable[=IS-TRANSLATABLE]**. Whether the field is translatable
- ** --cardinality=CARDINALITY**. The allowed number of values
- ** --target-type[=TARGET-TYPE]**. The target entity type. Only necessary for entity reference fields.
- ** --target-bundle[=TARGET-BUNDLE]**. The target bundle(s). Only necessary for entity reference fields.
- ** --show-machine-names[=SHOW-MACHINE-NAMES]**. Show machine names instead of labels in option lists.
- ** --existing-field-name[=EXISTING-FIELD-NAME]**. The name of an existing field you want to re-use. Only used in non-interactive context.
- ** --existing**. Re-use an existing field.
- ** --link-type=LINK-TYPE**. Allowed link type.
- ** --allow-link-text=ALLOW-LINK-TEXT**. Allow link text.

#### Aliases

- field-create
- fc

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.