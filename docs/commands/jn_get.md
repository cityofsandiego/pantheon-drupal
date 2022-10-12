---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/JsonapiCommands.php
command: jn:get
---
# jn:get

Execute a JSONAPI request.

#### Examples

- <code>drush jn:get jsonapi/node/article</code>. Get a list of articles back as JSON.
- <code>drush jn:get jsonapi/node/article | jq</code>. Pretty print JSON by piping to jq. See https://stedolan.github.io/jq/ for lots more jq features.

#### Arguments

- **url**. The JSONAPI URL to request.

#### Options

- ** --format[=FORMAT]**. Format the result data. Available formats: csv,json,list,null,php,print-r,tsv,var_dump,var_export,xml,yaml [default: *json*]
- ** --fields=FIELDS**. Limit output to only the listed elements. Name top-level elements by key, e.g. "--fields=name,date", or use dot notation to select a nested element, e.g. "--fields=a.b.c as example".
- ** --field=FIELD**. Select just one field, and force format to *string*.

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.