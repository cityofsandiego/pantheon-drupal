---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/config/ConfigPullCommands.php
command: config:pull
---
# config:pull

Export and transfer config from one environment to another.

#### Examples

- <code>drush config:pull @prod @stage</code>. Export config from @prod and transfer to @stage.
- <code>drush config:pull @prod @self --label=vcs</code>. Export config from @prod and transfer to the *vcs* config directory of current site.
- <code>drush config:pull @prod @self:../config/sync</code>. Export config to a custom directory. Relative paths are calculated from Drupal root.

#### Arguments

- **source**. A site-alias or the name of a subdirectory within /sites whose config you want to copy from.
- **destination**. A site-alias or the name of a subdirectory within /sites whose config you want to replace.

#### Options

- ** --safe**. Validate that there are no git uncommitted changes before proceeding
- ** --label[=LABEL]**. A config directory label (i.e. a key in $config_directories array in settings.php). [default: *sync*]
- ** --runner[=RUNNER]**. Where to run the rsync command; defaults to the local site. Can also be *source* or *destination*.
- ** --format[=FORMAT]**. Format the result data. Available formats: csv,json,list,null,php,print-r,string,table,tsv,var_dump,var_export,xml,yaml [default: *null*]
- ** --fields=FIELDS**. Available fields: Path (path)
- ** --field=FIELD**. Select just one field, and force format to *string*.

#### Topics

- [Creating site aliases for running Drush on remote sites.](../../vendor/drush/drush/docs/site-aliases.md) (docs:aliases)
- [Drupal config export instructions, including customizing config by environment.](../../vendor/drush/drush/docs/config-exporting.md) (docs:config:exporting)
- [Output formatters and filters: control the command output](../../vendor/drush/drush/docs/output-formats-filters.md) (docs:output-formats-filters)

#### Aliases

- cpull
- config-pull

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.