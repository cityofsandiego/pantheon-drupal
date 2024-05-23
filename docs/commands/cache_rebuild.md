---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/core/CacheCommands.php
command: cache:rebuild
---
# cache:rebuild

Rebuild a Drupal 8 site.

This is a copy of core/rebuild.php. Additionally
it also clears Drush cache and Drupal's render cache.

#### Options

- ** --cache-clear[=CACHE-CLEAR]**. Set to 0 to suppress normal cache clearing; the caller should then clear if needed. [default: *1*]
- ** --no-cache-clear**. Negate --cache-clear option.

#### Aliases

- cr
- rebuild
- cache-rebuild

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.