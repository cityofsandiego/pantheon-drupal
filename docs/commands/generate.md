---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/generate/GenerateCommands.php
command: generate
---
# generate

Generate boilerplate code for modules/plugins/services etc.

Drush asks questions so that the generated code is as polished as possible. After
generating, Drush lists the files that were created.

#### Examples

- <code>drush generate</code>. Pick from available generators and then run it.
- <code>drush generate drush-command-file</code>. Generate a Drush commandfile for your module.
- <code>drush generate controller --answer=Example --answer=example</code>. Generate a controller class and pre-fill the first two questions in the wizard.
- <code>drush generate controller -vvv --dry-run</code>. Learn all the potential answers so you can re-run with several --answer options.

#### Arguments

- **[generator]**. A generator name. Omit to pick from available Generators.

#### Options

- ** --answer=ANSWER**. Answer to generator question.
- ** --destination=DESTINATION**. Absolute path to a base directory for file writing.
- ** --dry-run**. Output the generated code but not save it to file system.

#### Topics

- [Instructions on creating your own Drush Generators.](../../vendor/drush/drush/docs/generators.md) (docs:generators)

#### Aliases

- gen

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.