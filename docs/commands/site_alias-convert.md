---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/core/SiteCommands.php
command: site:alias-convert
---
# site:alias-convert

Convert legacy site alias files to the new yml format.

#### Examples

- <code>drush site:alias-convert</code>. Find legacy alias files and convert them to yml. You will be prompted for a destination directory.
- <code>drush site:alias-convert --simulate</code>. List the files to be converted but do not actually do anything.

#### Arguments

- **destination**. An absolute path to a directory for writing new alias files.If omitted, user will be prompted.

#### Options

- ** --format[=FORMAT]**.  [default: *yaml*]
- ** --sources=SOURCES**. A comma delimited list of paths to search. Overrides the default paths.

#### Topics

- [Creating site aliases for running Drush on remote sites.](../../vendor/drush/drush/docs/site-aliases.md) (docs:aliases)

#### Aliases

- sa-convert
- sac

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.