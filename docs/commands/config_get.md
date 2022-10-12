---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/config/ConfigCommands.php
command: config:get
---
# config:get

Display a config value, or a whole configuration object.

#### Examples

- <code>drush config:get system.site</code>. Displays the system.site config.
- <code>drush config:get system.site page.front</code>. Gets system.site:page.front value.

#### Arguments

- **config_name**. The config object name, for example *system.site*.
- **[key]**. The config key, for example *page.front*. Optional.

#### Options

- ** --format[=FORMAT]**.  [default: *yaml*]
- ** --source[=SOURCE]**. The config storage source to read. Additional labels may be defined in settings.php. [default: *active*]
- ** --include-overridden**. Apply module and settings.php overrides to values.

#### Aliases

- cget
- config-get

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.