---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/pm/SecurityUpdateCommands.php
command: pm:security
---
# pm:security

Check Drupal Composer packages for pending security updates.

This uses the [Drupal security advisories package](https://github.com/drupal-composer/drupal-security-advisories) to determine if updates
are available. An exit code of 3 indicates that the check completed, and insecure packages were found.

#### Examples

- <code>drush pm:security --format=json</code>. Get security data in JSON format.
- <code>HTTP_PROXY=tcp://localhost:8125 pm:security</code>. Proxy Guzzle requests through an http proxy.

#### Options

- ** --no-dev**. Only check production dependencies.
- ** --format=FORMAT**. Format the result data. Available formats: csv,json,list,null,php,print-r,sections,string,table,tsv,var_dump,var_export,xml,yaml [default: *table*]
- ** --fields=FIELDS**. Available fields: Name (name), Installed Version (version) [default: *name,version*]
- ** --field=FIELD**. Select just one field, and force format to *string*.
- ** --filter[=FILTER]**. Filter output based on provided expression

#### Topics

- [Output formatters and filters: control the command output](../../vendor/drush/drush/docs/output-formats-filters.md) (docs:output-formats-filters)

#### Aliases

- sec
- pm-security

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.