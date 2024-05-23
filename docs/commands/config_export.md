---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/config/ConfigExportCommands.php
command: config:export
---
# config:export

Export Drupal configuration to a directory.

#### Examples

- <code>drush config:export</code>. Export configuration files to the site's config directory.
- <code>drush config:export --destination</code>. Export configuration; Save files in a backup directory named config-export.

#### Options

- ** --add**. Run `git add -p` after exporting. This lets you choose which config changes to sync for commit.
- ** --commit**. Run `git add -A` and `git commit` after exporting. This commits everything that was exported without prompting.
- ** --message=MESSAGE**. Commit comment for the exported configuration. Optional; may only be used with --commit.
- ** --destination[=DESTINATION]**. An arbitrary directory that should receive the exported files. A backup directory is used when no value is provided.
- ** --diff**. Show preview as a diff, instead of a change list.
- ** --format[=FORMAT]**. 

#### Aliases

- cex
- config-export

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.