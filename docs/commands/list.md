---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/help/ListCommands.php
command: list
---
# list

List available commands.

#### Examples

- <code>drush list</code>. List all commands.
- <code>drush list --filter=devel_generate</code>. Show only commands starting with devel-
- <code>drush list --format=xml</code>. List all commands in Symfony compatible xml format.

#### Options

- ** --format[=FORMAT]**.  [default: *listcli*]
- ** --raw**. Show a simple table of command names and descriptions.
- ** --filter=FILTER**. Restrict command list to those commands defined in the specified file. Omit value to choose from a list of names.

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.