---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Drupal/Commands/core/ViewsCommands.php
command: views:execute
---
# views:execute

Execute a view and show a count of the results, or the rendered HTML.

#### Examples

- <code>drush views:execute my_view</code>. Show the rendered HTML for the default display for the my_view View.
- <code>drush views:execute my_view page_1 3 --count</code>. Show a count of my_view:page_1 where the first contextual filter value is 3.
- <code>drush views:execute my_view page_1 3,foo</code>. Show the rendered HTML of my_view:page_1 where the first two contextual filter values are 3 and 'foo' respectively.

#### Arguments

- **view_name**. The name of the view to execute.
- **[display]**. The display ID to execute. If none specified, the default display will be used.
- **[view_args]**. A comma delimited list of values, corresponding to contextual filters.

#### Options

- ** --count[=COUNT]**. Display a count of the results instead of each row.
- ** --show-admin-links**. Show contextual admin links in the rendered markup.

#### Aliases

- vex
- views-execute

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.