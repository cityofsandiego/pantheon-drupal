---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/ImageCommands.php
command: image:derive
---
# image:derive

Create an image derivative.

#### Examples

- <code>drush image:derive thumbnail core/themes/bartik/screenshot.png</code>. Save thumbnail sized derivative of logo image.

#### Arguments

- **style_name**. An image style machine name.
- **source**. Path to a source image. Optionally prepend stream wrapper scheme.

#### Aliases

- id
- image-derive

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.