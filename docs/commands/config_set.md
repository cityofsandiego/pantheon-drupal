---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/config/ConfigCommands.php
command: config:set
---
# config:set

Save a config value directly. Does not perform a config import.

#### Examples

- <code>drush config:set system.site name MySite</code>. Sets a value for the key *name* of *system.site* config object.
- <code>drush config:set system.site page.front '/path/to/page'</code>. Sets the given URL path as value for the config item with key *page.front* of *system.site* config object.
- <code>drush config:set system.site '[]'</code>. Sets the given key to an empty array.
- <code>drush config:set --input-format=yaml user.role.authenticated permissions [foo,bar]</code>. Use a sequence as value for the key *permissions* of *user.role.authenticated* config object.
- <code>drush config:set --input-format=yaml system.site page {403: '403', front: home}</code>. Use a mapping as value for the key *page* of *system.site* config object.
- <code>drush config:set --input-format=yaml user.role.authenticated ? "{label: 'Auth user', weight: 5}"</code>. Update two top level keys (label, weight) in the *system.site* config object.

#### Arguments

- **config_name**. The config object name, for example *system.site*.
- **key**. The config key, for example *page.front*. Use *?* if you are updating multiple top-level keys.
- **value**. The value to assign to the config key. Use *-* to read from Stdin.

#### Options

- ** --input-format[=INPUT-FORMAT]**. Format to parse the object. Recognized values: *string*, *yaml*. Since JSON is a subset of YAML, $value may be in JSON format. [default: *string*]

#### Aliases

- cset
- config-set

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.