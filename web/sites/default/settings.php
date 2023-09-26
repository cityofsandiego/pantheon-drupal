<?php

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = __DIR__ . '/services.yml';

/**
 * Include the Pantheon-specific settings file.
 *
 * n.b. The settings.pantheon.php file makes some changes
 *      that affect all environments that this site
 *      exists in.  Always include this file, even in
 *      a local development environment, to ensure that
 *      the site settings remain consistent.
 */
include __DIR__ . "/settings.pantheon.php";

/**
 * Skipping permissions hardening will make scaffolding
 * work better, but will also raise a warning when you
 * install Drupal.
 *
 * https://www.drupal.org/project/drupal/issues/3091285
 */
// $settings['skip_permissions_hardening'] = TRUE;

/**
 * If there is a local settings file, then include it
 */
$local_settings = __DIR__ . "/settings.local.php";
if (file_exists($local_settings)) {
  include $local_settings;
}

$redirect_file = __DIR__ .  '/settings.redirect.php';
if(file_exists($redirect_file)) {
  include $redirect_file;
}

// Added by City of San Diego, the settings from these modules will not be exported in config
$settings['config_exclude_modules'] = [
  'devel',
  'examples',
  'if_sdmigration',
  'bean_migrate',
  'migrate',
  'migrate_drupal',
  'migrate_drupal_ui',
  'migrate_plus',
  'migrate_source_csv',
  'media_migration',
  'migrate_sandbox',
  'webform_migrate',
  'yaml_editor',
  'webprofiler',
];

