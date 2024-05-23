# Sand Diego Examples and WebTeam development

## This module
Trys to provide code examples of things we use or have discovered. 
Instead of just googling the information, this provides proven examples
in our system.

## Custom Module Documenation
Documentation for each custom module is in the module's directory.
It is in README.md. This is also available through the GUI via the
custom module "sand_help" and can be viewed on /admin/modules


There are examples of useful drush commands and other things in this README file.

## Configuration

### import
If there is configuration that you want to re-import from a module's
install directory then you can use drush to re-import that config.
Note that a "drush cr" will not re-import in Drupal. 

>Example:
>
>`drush cim --partial --source=modules/custom/sand_if_weather/config/install`
> 
### export
To export all config to the default directory you can use the GUI or drush
>```drush cex```
