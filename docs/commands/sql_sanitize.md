---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/sql/SanitizeCommands.php
command: sql:sanitize
---
# sql:sanitize

Sanitize the database by removing or obfuscating user data.

Commandfiles may add custom operations by implementing:

- `@hook on-event sql-sanitize-confirms`. Display summary to user before confirmation.
- `@hook post-command sql-sanitize`. Run queries or call APIs to perform sanitizing

Several working commandfiles may be found at https://github.com/drush-ops/drush/tree/11.x/src/Drupal/Commands/sql

#### Examples

- <code>drush sql:sanitize --sanitize-password=no</code>. Sanitize database without modifying any passwords.
- <code>drush sql:sanitize --allowlist-fields=field_biography,field_phone_number</code>. Sanitizes database but exempts two user fields from modification.

#### Options

- ** --whitelist-fields[=WHITELIST-FIELDS]**. Deprecated. Use allowlist-fields instead.
- ** --allowlist-fields[=ALLOWLIST-FIELDS]**. A comma delimited list of fields exempt from sanitization.
- ** --sanitize-email[=SANITIZE-EMAIL]**. The pattern for test email addresses in the sanitization operation, or *no* to keep email addresses unchanged. May contain replacement patterns *%uid*, *%mail* or *%name*. [default: *user+%uid@localhost.localdomain*]
- ** --sanitize-password[=SANITIZE-PASSWORD]**. By default, passwords are randomized. Specify *no* to disable that. Specify any other value to set all passwords to that value.

#### Topics

- [Drush hooks.](../../vendor/drush/drush/docs/hooks.md) (docs:hooks)

#### Aliases

- sqlsan
- sql-sanitize

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.