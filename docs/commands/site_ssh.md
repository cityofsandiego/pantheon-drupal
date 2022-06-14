---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/core/SshCommands.php
command: site:ssh
---
# site:ssh

Connect to a Drupal site's server via SSH, and optionally run a shell command.

#### Examples

- <code>drush @mysite ssh</code>. Open an interactive shell on @mysite's server.
- <code>drush @prod ssh ls /tmp</code>. Run *ls /tmp* on *@prod* site.
- <code>drush @prod ssh git pull</code>. Run *git pull* on the Drupal root directory on the *@prod* site.
- <code>drush ssh git pull</code>. Run *git pull* on the local Drupal root directory.

#### Arguments

- **[code]...**. Code which should run at remote host.

#### Options

- ** --cd=CD**. Directory to change to. Defaults to Drupal root.
- ** --tty**. Create a tty (e.g. to run an interactive program).
- ** --ssh-options=SSH-OPTIONS**. A string of extra options that will be passed to the ssh command (e.g. *-p 100*)

#### Topics

- [Creating site aliases for running Drush on remote sites.](../../vendor/drush/drush/docs/site-aliases.md) (docs:aliases)

#### Aliases

- ssh
- site-ssh

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.