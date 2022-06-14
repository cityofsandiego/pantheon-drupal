---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/core/CacheCommands.php
command: cache:clear
---
# cache:clear

Clear a specific cache, or all Drupal caches.

#### Examples

- <code>drush cc bin</code>. Choose a bin to clear.
- <code>drush cc bin entity,bootstrap</code>. Clear the entity and bootstrap cache bins.

#### Arguments

- **type**. The particular cache to clear. Omit this argument to choose from available types.
- **[args]...**. Additional arguments as might be expected (e.g. bin name).

#### Options

- ** --cache-clear[=CACHE-CLEAR]**. Set to 0 to suppress normal cache clearing; the caller should then clear if needed. [default: *1*]
- ** --no-cache-clear**. Negate --cache-clear option.

#### Aliases

- cc
- cache-clear

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.