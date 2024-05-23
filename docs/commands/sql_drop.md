---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/sql/SqlCommands.php
command: sql:drop
---
# sql:drop

Drop all tables in a given database.

#### Options

- ** --database[=DATABASE]**. The DB connection key if using multiple connections in settings.php. [default: *default*]
- ** --target[=TARGET]**. The name of a target within the specified database connection. [default: *default*]
- ** --db-url=DB-URL**. A Drupal 6 style database URL. For example *mysql://root:pass@localhost:port/dbname*
- ** --show-passwords**. Show password on the CLI. Useful for debugging.

#### Topics

- [Example policy file.](https://raw.githubusercontent.com/drush-ops/drush/11.x/examples/Commands/PolicyCommands.php) (docs:policy)

#### Aliases

- sql-drop

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.