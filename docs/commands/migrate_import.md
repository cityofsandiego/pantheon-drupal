---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/MigrateRunnerCommands.php
command: migrate:import
---
# migrate:import

:octicons-tag-24: 10.4+

Perform one or more migration processes.

#### Examples

- <code>migrate:import --all</code>. Perform all migrations
- <code>migrate:import --all --no-progress</code>. Perform all migrations but avoid the progress bar
- <code>migrate:import --tag=user,main_content</code>. Import all migrations tagged with *user* and *main_content* tags
- <code>migrate:import classification,article</code>. Import new terms and nodes using migration *classification* and *article*
- <code>migrate:import user --limit=2</code>. Import no more than 2 users using the *user* migration
- <code>migrate:import user --idlist=5</code>. Import the user record with source ID 5
- <code>migrate:import node_revision --idlist=1:2,2:3,3:5</code>. Import the node revision record with source IDs [1,2], [2,3], and [3,5]
- <code>migrate:import user --limit=50 --feedback=20</code>. Import 50 users and show process message every 20th record
- <code>migrate:import --all --delete</code>. Perform all migrations and delete the destination items that are missing from source

#### Arguments

- **[migrationIds]**. Comma-separated list of migration IDs.

#### Options

- ** --all**. Process all migrations.
- ** --tag=TAG**. A comma-separated list of migration tags to import
- ** --limit=LIMIT**. Limit on the number of items to process in each migration
- ** --feedback=FEEDBACK**. Frequency of progress messages, in items processed
- ** --idlist=IDLIST**. Comma-separated list of IDs to import. As an ID may have more than one column, concatenate the columns with the colon ':' separator
- ** --update**. In addition to processing unprocessed items from the source, update previously-imported items with the current data
- ** --force**. Force an operation to run, even if all dependencies are not satisfied
- ** --execute-dependencies**. Execute all dependent migrations first.
- ** --timestamp**. Show progress ending timestamp in progress messages
- ** --total**. Show total processed item number in progress messages
- ** --progress[=PROGRESS]**. Show progress bar [default: *1*]
- ** --delete**. Delete destination records missed from the source. Not compatible with --limit and --idlist options, and high_water_property source configuration key.
- ** --no-progress**. Negate --progress option.

#### Topics

- [Defining and running migrations.](../../vendor/drush/drush/docs/migrate.md) (docs:migrate)

#### Aliases

- mim
- migrate-import

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.