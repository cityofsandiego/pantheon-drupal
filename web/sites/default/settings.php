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

$local_site_file = __DIR__ .  '/settings.localsite.php';
if(file_exists($local_site_file)) {
  include $local_site_file;
}

/**
 * Skipping permissions hardening will make scaffolding
 * work better, but will also raise a warning when you
 * install Drupal.
 *
 * https://www.drupal.org/project/drupal/issues/3091285
 */
// $settings['skip_permissions_hardening'] = TRUE;

$redirect_file = __DIR__ .  '/settings.redirect.php';
if(file_exists($redirect_file)) {
  include $redirect_file;
}

$redis_file = __DIR__ .  '/settings.redis.php';
if(file_exists($redis_file)) {
    include $redis_file;
}

// Place for settings for the live environment
// Note: if NOT pantheon ENV then make changes to your settings.local.php
if (defined('PANTHEON_ENVIRONMENT')) {
  if (PANTHEON_ENVIRONMENT == 'live') {
    // Do not reroute email on Live
    $conf['reroute_email_enable'] = 0;
    // Set env color
    $config['environment_indicator.indicator']['bg_color'] = '#AE4343';
    $config['environment_indicator.indicator']['fg_color'] = 'black';
    $config['environment_indicator.indicator']['name'] = 'Prod';
    // enable search_api server: production and indexes and read-only to false
    $config['search_api.server.production']['status'] = true;
    $config['search_api.index.content']['status'] = true;
    $config['search_api.index.remote']['status'] = true;
    $config['search_api.index.content']['read_only'] = false;
    $config['search_api.index.remote']['read_only'] = false;
  } else {
    // read-only
    $config['search_api.index.content']['read_only'] = true;
    $config['search_api.index.remote']['read_only'] = true;
  }
} else {
  // env indicator for local
  $config['environment_indicator.indicator']['bg_color'] = '#307249'; #local
  $config['environment_indicator.indicator']['fg_color'] = 'black';
  $config['environment_indicator.indicator']['name'] = 'Local';
  // read-only
  $config['search_api.index.content']['read_only'] = true;
  $config['search_api.index.remote']['read_only'] = true;
}

// TEST Env
if (defined('PANTHEON_ENVIRONMENT')) {
  if (PANTHEON_ENVIRONMENT == 'test') {
     $config['environment_indicator.indicator']['bg_color'] = '#AEA75D';
     $config['environment_indicator.indicator']['fg_color'] = 'black';
     $config['environment_indicator.indicator']['name'] = 'Test';
  }
}

// DEV Env
if (defined('PANTHEON_ENVIRONMENT')) {
  if (PANTHEON_ENVIRONMENT == 'dev') {
     $config['environment_indicator.indicator']['bg_color'] = '#72AD89';
     $config['environment_indicator.indicator']['fg_color'] = 'black';
     $config['environment_indicator.indicator']['name'] = 'Dev';
  }
}

// Activate the proper config-splits based on the pantheon or local environment.
// In your local you should have a file called settings.localsite.php
if (defined('PANTHEON_ENVIRONMENT') && isset($_ENV['PANTHEON_SITE_NAME'])) {
  switch ($_ENV['PANTHEON_SITE_NAME']) {
    case 'sandgov':
      switch ($_ENV['PANTHEON_SITE_NAME']) {
        case 'DEV':
          $config["config_split.config_split.config_sandgov"]["status"] = TRUE;
          break;
        case 'TEST':
          $config["config_split.config_split.config_sandgov"]["status"] = TRUE;
          break;
        default:
          $config["config_split.config_split.config_sandgov"]["status"] = TRUE;
          break;
      }
      break;
    case 'insidesd':
      switch ($_ENV['PANTHEON_SITE_NAME']) {
        case 'DEV':
          $config["config_split.config_split.config_insidesd"]["status"] = TRUE;
          break;
        case 'TEST':
          $config["config_split.config_split.config_insidesd"]["status"] = TRUE;
          break;
        default:
          $config["config_split.config_split.config_insidesd"]["status"] = TRUE;
          break;
      }
      break;
    case 'citynet':
      // Activate citynet split
      switch ($_ENV['PANTHEON_SITE_NAME']) {
        case 'DEV':
          break;
        case 'TEST':
          break;
        default:
          break;
      }
      break;
  }
} else {
  if (!defined('LOCALSITE')) {
    echo "ERROR - Local site must have a settings.localsite.php to set the constant LOCALSITE like: define('LOCALSITE', 'sandgov');";
    exit(1);
  }
  switch (LOCALSITE) {
    case 'sandgov':
      $config["config_split.config_split.config_sandgov"]["status"] = TRUE;
      break;
    case 'insidesd':
      $config["config_split.config_split.config_insidesd"]["status"] = TRUE;
      break;
    case 'citynet':
      break;
    default:
      echo "ERROR - check your settings.localsite.php to make sure it is configured correctly like: define('LOCALSITE', 'sandgov');";
      echo LOCALSITE;
      exit(2);
      break;
  }
}

// Added by City of San Diego, the settings from these modules will not be exported in config
$settings['config_exclude_modules'] = [
  'devel',
  'examples',
  'search_api_solr_devel',
  'upgrade_status',
  'webprofiler',
  'yaml_editor',
];

/**
 * If there is a local settings file, then include it
 */
$local_settings = __DIR__ . "/settings.local.php";
if (file_exists($local_settings)) {
  include $local_settings;
}

