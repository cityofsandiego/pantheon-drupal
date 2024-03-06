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

