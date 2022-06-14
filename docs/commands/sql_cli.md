---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/sql/SqlCommands.php
command: sql:cli
---
# sql:cli

Open a SQL command-line interface using Drupal's credentials.

#### Examples

- <code>drush sql:cli</code>. Open a SQL command-line interface using Drupal's credentials.
- <code>drush sql:cli --extra=--progress-reports</code>. Open a SQL CLI and skip reading table information.
- <code>drush sql:cli < example.sql</code>. Import sql statements from a file into the current database.

#### Options

- ** --extra=EXTRA**. Add custom options to the connect string
- ** --database[=DATABASE]**. The DB connection key if using multiple connections in settings.php. [default: *default*]
- ** --target[=TARGET]**. The name of a target within the specified database connection. [default: *default*]
- ** --db-url=DB-URL**. A Drupal 6 style database URL. For example *mysql://root:pass@localhost:port/dbname*
- ** --show-passwords**. Show password on the CLI. Useful for debugging.

#### Aliases

- sqlc
- sql-cli

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.