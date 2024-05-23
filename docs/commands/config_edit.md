---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/config/ConfigCommands.php
command: config:edit
---
# config:edit

Open a config file in a text editor. Edits are imported after closing editor.

#### Examples

- <code>drush config:edit image.style.large</code>. Edit the image style configurations.
- <code>drush config:edit</code>. Choose a config file to edit.
- <code>drush --bg config-edit image.style.large</code>. Return to shell prompt as soon as the editor window opens.

#### Arguments

- **config_name**. The config object name, for example *system.site*.

#### Options

- ** --editor[=EDITOR]**. A string of bash which launches user's preferred text editor. Defaults to *${VISUAL-${EDITOR-vi}}*.
- ** --bg**. Launch editor in background process.

#### Aliases

- cedit
- config-edit

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.