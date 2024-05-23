---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/MigrateRunnerCommands.php
command: migrate:rollback
---
# migrate:rollback

:octicons-tag-24: 10.4+

Rollback one or more migrations.

#### Examples

- <code>migrate:rollback --all</code>. Rollback all migrations
- <code>migrate:rollback --all --no-progress</code>. Rollback all migrations but avoid the progress bar
- <code>migrate:rollback --tag=user,main_content</code>. Rollback all migrations tagged with *user* and *main_content* tags
- <code>migrate:rollback classification,article</code>. Rollback terms and nodes imported by *classification* and *article* migrations
- <code>migrate:rollback user --idlist=5</code>. Rollback imported user record with source ID 5

#### Arguments

- **[migrationIds]**. Comma-separated list of migration IDs.

#### Options

- ** --all**. Process all migrations.
- ** --tag=TAG**. A comma-separated list of migration tags to rollback
- ** --feedback=FEEDBACK**. Frequency of progress messages, in items processed
- ** --idlist=IDLIST**. Comma-separated list of IDs to rollback. As an ID may have more than one column, concatenate the columns with the colon ':' separator
- ** --progress[=PROGRESS]**. Show progress bar [default: *1*]
- ** --no-progress**. Negate --progress option.

#### Topics

- [Defining and running migrations.](../../vendor/drush/drush/docs/migrate.md) (docs:migrate)

#### Aliases

- mr
- migrate-rollback

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.