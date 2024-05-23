---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/LocaleCommands.php
command: locale:import
---
# locale:import

Imports to a gettext translation file.

#### Examples

- <code>drush locale-import nl drupal-8.4.2.nl.po</code>. Import the Dutch drupal core translation.
- <code>drush locale-import --type=customized nl drupal-8.4.2.nl.po</code>. Import the Dutch drupal core translation. Treat imported strings as custom translations.
- <code>drush locale-import --override=none nl drupal-8.4.2.nl.po</code>. Import the Dutch drupal core translation. Don't overwrite existing translations. Only append new translations.
- <code>drush locale-import --override=not-customized nl drupal-8.4.2.nl.po</code>. Import the Dutch drupal core translation. Only override non-customized translations, customized translations are kept.
- <code>drush locale-import nl custom-translations.po --type=customized --override=all</code>. Import customized Dutch translations and override any existing translation.

#### Arguments

- **langcode**. The language code of the imported translations.
- **file**. Path and file name of the gettext file.

#### Options

- ** --type[=TYPE]**. The type of translations to be imported. Recognized values: *customized*, *not-customized* [default: *not-customized*]
- ** --override=OVERRIDE**. Whether and how imported strings will override existing translations. Defaults to the Import behavior configured in the admin interface. Recognized values: *none*, *customized*, *not-customized*, *all*,
- ** --autocreate-language**. Create the language in addition to import.

#### Aliases

- locale-import

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.