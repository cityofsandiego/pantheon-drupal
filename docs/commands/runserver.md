---
edit_url: https://github.com/drush-ops/drush/blob/11.x/vendor/drush/drush/src/Commands/core/RunserverCommands.php
command: runserver
---
# runserver

Runs PHP's built-in http server for development.

- Don't use this for production, it is neither scalable nor secure for this use.
- If you run multiple servers simultaneously, you will need to assign each a unique port.
- Use Ctrl-C or equivalent to stop the server when complete.

#### Examples

- <code>drush rs 8080</code>. Start a web server on 127.0.0.1, port 8080.
- <code>drush rs 10.0.0.28:80</code>. Start runserver on 10.0.0.28, port 80.
- <code>drush rs [::1]:80</code>. Start runserver on IPv6 localhost ::1, port 80.
- <code>drush rs --dns localhost:8888/user</code>. Start runserver on localhost (using rDNS to determine binding IP), port 8888, and open /user in browser.
- <code>drush rs /</code>. Start runserver on default IP/port (127.0.0.1, port 8888), and open / in browser.
- <code>drush rs :9000/admin</code>. Start runserver on 127.0.0.1, port 9000, and open /admin in browser. Note that you need a colon when you specify port and path, but no IP.
- <code>drush --quiet rs</code>. Silence logging the printing of web requests to the console.

#### Arguments

- **[uri]**. Host IP address and port number to bind to and path to open in web browser. Format is addr:port/path. Only opens a browser if a path is specified.

#### Options

- ** --default-server=DEFAULT-SERVER**. A default addr:port/path to use for any values not specified as an argument.
- ** --browser[=BROWSER]**. Open the URL in the default browser. Use --no-browser to avoid opening a browser. [default: *1*]
- ** --dns**. Resolve hostnames/IPs using DNS/rDNS (if possible) to determine binding IPs and/or human friendly hostnames for URLs and browser.
- ** --no-browser**. Negate --browser option.

#### Aliases

- rs
- serve

!!! hint "Legend"
    - An argument or option with square brackets is optional.
    - Any default value is listed at end of arg/option description.
    - An ellipsis indicates that an argument accepts multiple values separated by a space.