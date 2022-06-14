---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/core/CacheCommands.php
command: cache:tags
---
# cache:tags

Invalidate by cache tags.

#### Examples

- <code>drush cache:tag node:12,user:4</code>. Purge content associated with two cache tags.

#### Arguments

- **tags**. A comma delimited list of cache tags to clear.

#### Aliases

- ct

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.