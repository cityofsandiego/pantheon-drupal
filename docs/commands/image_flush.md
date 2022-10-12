---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/ImageCommands.php
command: image:flush
---
# image:flush

Flush all derived images for a given style.

#### Examples

- <code>drush image:flush</code>. Pick an image style and then delete its derivatives.
- <code>drush image:flush thumbnail,large</code>. Delete all thumbnail and large derivatives.
- <code>drush image:flush --all</code>. Flush all derived images. They will be regenerated on demand.

#### Arguments

- **style_names**. A comma delimited list of image style machine names. If not provided, user may choose from a list of names.

#### Options

- ** --all**. Flush all derived images

#### Aliases

- if
- image-flush

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.