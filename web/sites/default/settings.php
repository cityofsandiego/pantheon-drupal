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
    # enable search_api server: productioo
    $config['search_api.server.production']['status'] = true;
    $config['search_api.index.production_content']['status'] = true;
    $config['search_api.index.production_remote']['status'] = true;
    # disable search_api server: test
    $config['search_api.server.test']['status'] = false;
    $config['search_api.index.content']['status'] = false;
    $config['search_api.index.remote']['status'] = false;
  } else {
    # disable search_api server: production
    $config['search_api.server.production']['status'] = false;
    $config['search_api.index.production_content']['status'] = false;
    $config['search_api.index.production_remote']['status'] = false;
    # enable search_api server: test
    $config['search_api.server.test']['status'] = true;
    $config['search_api.index.content']['status'] = true;
    $config['search_api.index.remote']['status'] = true;
  }
}

// Added by City of San Diego, the settings from these modules will not be exported in config
$settings['config_exclude_modules'] = [
  'devel',
  'config_single_export',
  'examples',
  'search_api_solr_devel',
  'webprofiler',
  'yaml_editor',
];
