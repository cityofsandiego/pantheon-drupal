---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/core/PhpCommands.php
command: php:script
---
# php:script

Run php a script after a full Drupal bootstrap.

A useful alternative to eval command when your php is lengthy or you
can't be bothered to figure out bash quoting. If you plan to share a
script with others, consider making a full Drush command instead, since
that's more self-documenting.  Drush provides commandline options to the
script via a variable called *$extra*.

#### Examples

- <code>drush php:script example --script-path=/path/to/scripts:/another/path</code>. Run a script named example.php from specified paths
- <code>drush php:script -</code>. Run PHP code from standard input.
- <code>drush php:script</code>. List all available scripts.
- <code>drush php:script foo -- apple --cider</code>. Run foo.php script with argument *apple* and option *cider*. Note the *--* separator.

#### Arguments

- **[extra]...**. 

#### Options

- ** --format[=FORMAT]**.  [default: *var_export*]
- ** --script-path=SCRIPT-PATH**. Additional paths to search for scripts, separated by : (Unix-based systems) or ; (Windows).

#### Topics

- [An example Drush script.](https://raw.githubusercontent.com/drush-ops/drush/11.x/examples/helloworld.script) (docs:script)

#### Aliases

- scr
- php-script

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.