---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/core/RsyncCommands.php
command: core:rsync
---
# core:rsync

Rsync Drupal code or files to/from another server using ssh.

#### Examples

- <code>drush rsync @dev @stage</code>. Rsync Drupal root from Drush alias dev to the alias stage.
- <code>drush rsync ./ @stage:%files/img</code>. Rsync all files in the current directory to the *img*directory in the file storage folder on the Drush alias stage.
- <code>drush rsync @dev @stage -- --exclude=*.sql --delete</code>. Rsync Drupal root from the Drush alias dev to the alias stage, excluding all .sql files and delete all files on the destination that are no longer on the source.
- <code>drush rsync @dev @stage --ssh-options="-o StrictHostKeyChecking=no" -- --delete</code>. Customize how rsync connects with remote host via SSH. rsync options like --delete are placed after a --.

#### Arguments

- **source**. A site alias and optional path. See rsync documentation and [Site aliases](../site-aliases.md).
- **target**. A site alias and optional path. See rsync documentation and [Site aliases](../site-aliases.md).
- **[extra]...**. Additional parameters after the ssh statement.

#### Options

- ** --exclude-paths=EXCLUDE-PATHS**. List of paths to exclude, seperated by : (Unix-based systems) or ; (Windows).
- ** --include-paths=INCLUDE-PATHS**. List of paths to include, seperated by : (Unix-based systems) or ; (Windows).
- ** --mode[=MODE]**. The unary flags to pass to rsync; --mode=rultz implies rsync -rultz. Default is -akz. [default: *akz*]
- ** --ssh-options=SSH-OPTIONS**. A string appended to ssh command during rsync, sql-sync, etc.

#### Topics

- [Creating site aliases for running Drush on remote sites.](../../vendor/drush/drush/docs/site-aliases.md) (docs:aliases)

#### Aliases

- rsync
- core-rsync

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.