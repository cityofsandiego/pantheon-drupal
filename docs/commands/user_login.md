---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/core/LoginCommands.php
command: user:login
---
# user:login

Display a one time login link for user ID 1, or another user.

#### Examples

- <code>drush user:login</code>. Open browser to homepage, logged in as uid=1.
- <code>drush user:login --name=ryan node/add/blog</code>. Open browser (if configured or detected) for a one-time login link for username ryan that redirects to node/add/blog.
- <code>drush user:login --uid=123</code>. Open browser and login as user with uid "123".
- <code>drush user:login --mail=foo@bar.com</code>. Open browser and login as user with mail "foo@bar.com".

#### Arguments

- **[path]**. Optional path to redirect to after logging in.

#### Options

- ** --name[=NAME]**. A user name to log in as.
- ** --uid[=UID]**. A uid to log in as.
- ** --mail[=MAIL]**. A user mail address to log in as.
- ** --browser[=BROWSER]**. Open the URL in the default browser. Use --no-browser to avoid opening a browser. [default: *1*]
- ** --redirect-port=REDIRECT-PORT**. A custom port for redirecting to (e.g., when running within a Vagrant environment)
- ** --no-browser**. Negate --browser option.

#### Aliases

- uli
- user-login

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.