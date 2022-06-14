---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/core/EditCommands.php
command: core:edit
---
# core:edit

Edit drush.yml, site alias, and Drupal settings.php files.

#### Examples

- <code>drush core:config</code>. Pick from a list of config/alias/settings files. Open selected in editor.
- <code>drush --bg core-config</code>. Return to shell prompt as soon as the editor window opens.
- <code>drush core:config etc</code>. Edit the global configuration file.
- <code>drush core:config demo.alia</code>. Edit a particular alias file.
- <code>drush core:config sett</code>. Edit settings.php for the current Drupal site.
- <code>drush core:config --choice=2</code>. Edit the second file in the choice list.

#### Arguments

- **[filter]**. A substring for filtering the list of files. Omit this argument to choose from loaded files.

#### Options

- ** --editor[=EDITOR]**. A string of bash which launches user's preferred text editor. Defaults to *${VISUAL-${EDITOR-vi}}*.
- ** --bg**. Launch editor in background process.

#### Aliases

- conf
- config
- core-edit

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.