---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/TwigCommands.php
command: twig:unused
---
# twig:unused

Find potentially unused Twig templates.

Immediately before running this command, web crawl your entire web site. Or
use your Production PHPStorage dir for comparison.

#### Examples

- <code>drush twig:unused --field=template /var/www/mass.local/docroot/modules/custom,/var/www/mass.local/docroot/themes/custom</code>. Output a simple list of potentially unused templates.

#### Arguments

- **searchpaths**. A comma delimited list of paths to recursively search

#### Options

- ** --format=FORMAT**. Format the result data. Available formats: csv,json,list,null,php,print-r,sections,string,table,tsv,var_dump,var_export,xml,yaml [default: *table*]
- ** --fields=FIELDS**. Available fields: Template (template), Compiled (compiled) [default: *template,compiled*]
- ** --field=FIELD**. Select just one field, and force format to *string*.
- ** --filter[=FILTER]**. Filter output based on provided expression

#### Topics

- [Output formatters and filters: control the command output](../../vendor/drush/drush/docs/output-formats-filters.md) (docs:output-formats-filters)

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.