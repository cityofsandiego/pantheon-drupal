---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/help/HelpCommands.php
command: help
---
# help

Display usage details for a command.

#### Examples

- <code>drush help pm-uninstall</code>. Show help for a command.
- <code>drush help pmu</code>. Show help for a command using an alias.
- <code>drush help --format=xml</code>. Show all available commands in XML format.
- <code>drush help --format=json</code>. All available commands, in JSON format.

#### Arguments

- **[command_name]**. A command name

#### Options

- ** --format[=FORMAT]**. Format the result data. Available formats: csv,json,list,null,php,print-r,string,tsv,var_dump,var_export,xml,yaml [default: *helpcli*]
- ** --include-field-labels**. 
- ** --table-style[=TABLE-STYLE]**.  [default: *compact*]

#### Topics

- [README.md](https://raw.githubusercontent.com/drush-ops/drush/11.x/README.md) (docs:readme)

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.