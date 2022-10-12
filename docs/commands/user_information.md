---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/UserCommands.php
command: user:information
---
# user:information

Print information about the specified user(s).

#### Examples

- <code>drush user:information someguy,somegal</code>. Display information about the someguy and somegal user accounts.
- <code>drush user:information --mail=someguy@somegal.com</code>. Display information for a given email account.
- <code>drush user:information --uid=5</code>. Display information for a given user id.
- <code>drush uinf --uid=$(drush sqlq "SELECT GROUP_CONCAT(entity_id) FROM user__roles WHERE roles_target_id = 'administrator'")</code>. Display information for all administrators.

#### Arguments

- **[names]**. A comma delimited list of user names.

#### Options

- ** --format[=FORMAT]**. Format the result data. Available formats: csv,json,list,null,php,print-r,sections,string,table,tsv,var_dump,var_export,xml,yaml [default: *table*]
- ** --uid=UID**. A comma delimited list of user ids to lookup (an alternative to names).
- ** --mail=MAIL**. A comma delimited list of emails to lookup (an alternative to names).
- ** --fields=FIELDS**. Available fields: User ID (uid), User name (name), Password (pass), User mail (mail), User theme (theme), Signature (signature), Signature format (signature_format), User created (user_created), Created (created), User last access (user_access), Last access (access), User last login (user_login), Last login (login), User status (user_status), Status (status), Time zone (timezone), User picture (picture), Initial user mail (init), User roles (roles), Group Audience (group_audience), Language code (langcode), Uuid (uuid) [default: *uid,name,mail,roles,user_status*]
- ** --field=FIELD**. Select just one field, and force format to *string*.
- ** --filter[=FILTER]**. Filter output based on provided expression

#### Topics

- [Output formatters and filters: control the command output](../../vendor/drush/drush/docs/output-formats-filters.md) (docs:output-formats-filters)

#### Aliases

- uinf
- user-information

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.