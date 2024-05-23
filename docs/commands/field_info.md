---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/field/FieldInfoCommands.php
command: field:info
---
# field:info

:octicons-tag-24: 11.0+

List all configurable fields of an entity bundle

#### Examples

- <code>drush field-info taxonomy_term tag</code>. List all fields.
- <code>drush field:info</code>. List all fields and fill in the remaining information through prompts.

#### Arguments

- **[entityType]**. The machine name of the entity type
- **[bundle]**. The machine name of the bundle

#### Options

- ** --format[=FORMAT]**. Format the result data. Available formats: csv,json,list,null,php,print-r,sections,string,table,tsv,var_dump,var_export,xml,yaml [default: *table*]
- ** --show-machine-names**. Show machine names instead of labels in option lists.
- ** --fields=FIELDS**. Available fields: Label (label), Description (description), Field name (field_name), Field type (field_type), Required (required), Translatable (translatable), Cardinality (cardinality), Default value (default_value), Default value callback (default_value_callback), Allowed values (allowed_values), Allowed values function (allowed_values_function), Selection handler (handler), Target bundles (target_bundles) [default: *field_name,required,field_type,cardinality*]
- ** --field=FIELD**. Select just one field, and force format to *string*.
- ** --filter[=FILTER]**. Filter output based on provided expression

#### Topics

- [Output formatters and filters: control the command output](../../vendor/drush/drush/docs/output-formats-filters.md) (docs:output-formats-filters)

#### Aliases

- field-info
- fi

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.