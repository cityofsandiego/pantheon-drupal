---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/sql/SqlCommands.php
command: sql:query
---
# sql:query

Execute a query against a database.

#### Examples

- <code>drush sql:query "SELECT * FROM users WHERE uid=1"</code>. Browse user record. Table prefixes, if used, must be added to table names by hand.
- <code>drush sql:query --db-prefix "SELECT * FROM {users}"</code>. Browse user record. Table prefixes are honored. Caution: All curly-braces will be stripped.
- <code>$(drush sql:connect) < example.sql</code>. Import sql statements from a file into the current database.
- <code>drush sql:query --file=example.sql</code>. Alternate way to import sql statements from a file.
- <code>drush ev "return db_query('SELECT * FROM users')->fetchAll()" --format=json</code>. Get data back in JSON format. See https://github.com/drush-ops/drush/issues/3071#issuecomment-347929777.
- <code>`drush sql:connect` -e "select * from users limit 5;"</code>. Results are formatted in a pretty table with borders and column headers.

#### Arguments

- **[query]**. An SQL query. Ignored if --file is provided.

#### Options

- ** --result-file[=RESULT-FILE]**. Save to a file. The file should be relative to Drupal root.
- ** --file=FILE**. Path to a file containing the SQL to be run. Gzip files are accepted.
- ** --file-delete**. Delete the --file after running it.
- ** --extra=EXTRA**. Add custom options to the connect string (e.g. --extra=--skip-column-names)
- ** --db-prefix**. Enable replacement of braces in your query.
- ** --database[=DATABASE]**. The DB connection key if using multiple connections in settings.php. [default: *default*]
- ** --target[=TARGET]**. The name of a target within the specified database connection. [default: *default*]
- ** --db-url=DB-URL**. A Drupal 6 style database URL. For example *mysql://root:pass@localhost:port/dbname*
- ** --show-passwords**. Show password on the CLI. Useful for debugging.

#### Aliases

- sqlq
- sql-query

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.