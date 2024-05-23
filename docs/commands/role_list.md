---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/RoleCommands.php
command: role:list
---
# role:list

Display a list of all roles defined on the system.

If a role name is provided as an argument, then all of the permissions of
that role will be listed.  If a permission name is provided as an option,
then all of the roles that have been granted that permission will be listed.

#### Examples

- <code>drush role:list --filter='administer nodes'</code>. Display a list of roles that have the administer nodes permission assigned.

#### Options

- ** --format[=FORMAT]**. Format the result data. Available formats: csv,json,list,null,php,print-r,sections,string,table,tsv,var_dump,var_export,xml,yaml [default: *yaml*]
- ** --fields=FIELDS**. Available fields: ID (rid), Role Label (label), Permissions (perms)
- ** --field=FIELD**. Select just one field, and force format to *string*.
- ** --filter[=FILTER]**. Filter output based on provided expression

#### Topics

- [Output formatters and filters: control the command output](../../vendor/drush/drush/docs/output-formats-filters.md) (docs:output-formats-filters)

#### Aliases

- rls
- role-list

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.