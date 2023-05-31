<?php

/**
 * This settings file handles redirects so that they happen before Drupal is fully booted.
 * It's Based on https://github.com/Pantheon-SE/pantheon-htaccess-rewrites/blob/master/pantheon_rewrites.php
 * 
 * Redirects can be static with the query string Or the redirect can be done via
 * a function. See The example: /OnBaseAgendaOnline/Meetings/ViewMeeting 
**/

$settings['redirects'] = [
  '/OnBaseAgendaOnline/Meetings/ViewMeeting' => 'function settings_redirect_onbase_view_meeting',
];


/**
 * Redirect Loop code. DO NOT EDIT UNLESS YOU KNOW WHAT YOU ARE DOING!
 */
// Loop through requests for partial matching
foreach ($settings['redirects'] as $source => $target) {
  $uri = $_SERVER['REQUEST_URI'];
  if (str_contains($uri, $source)) {
    if (str_starts_with($target, 'function ')) {
      // Call a function for redirect logic.
      $offset = strlen('function ');
      $function = substr($target, $offset);
      $function();
    } else {
      // Plain Redirect with query string.
      $url_args = "?" . $_SERVER['QUERY_STRING'];
      header("Location: " . $target . $url_args, TRUE,301);
      exit();
    }
  }
}

/**
 * Redirect on base mettings.
 * 
 * From RonV on 5/3/23.
 *
 * The /OnBaseAgendaOnline/Meetings/ViewMeeting page redirects old 
 * onbase.sandiego.gov links to sandiego.hylandcloud.com along with parameters.
 * Those old links can be found on web pages and PDFs. There's a rewrite rule 
 * that converts onbase.sandiego.gov to www.sandiego.gov, 
 * so 
 *   https://onbase.sandiego.gov/OnBaseAgendaOnline/Meetings/ViewMeeting?id=3895&doctype=1 
 * becomes 
 *   https://www.sandiego.gov/OnBaseAgendaOnline/Meetings/ViewMeeting?id=3895&doctype=1, 
 * 
 * which then redirects to 
 *   https://sandiego.hylandcloud.com/211agendaonlinecouncil/Meetings/ViewMeeting?id=3895&doctype=1.




City of San Diego Official Website



 * @return void
 */
function settings_redirect_onbase_view_meeting() {
  $query_parameters = $_SERVER['QUERY_STRING'];
  if (!empty($query_parameters)) {
    parse_str($query_parameters, $parameters);
  }

  $site = $parameters["site"] ?? 'council';

  // If query ID or query doctype is null, Then Just re-direct Without them.        
  if (empty($parameters["id"]) || empty($parameters["doctype"])) {
    $url = "https://sandiego.hylandcloud.com/211agendaonline" . $site;
  } else {
    $url = "https://sandiego.hylandcloud.com/211agendaonline" . $site .
      "/Meetings/ViewMeeting?id=" . $parameters["id"] . "&doctype=" . $parameters["doctype"];
  }

  header("Location: " . $url);
  exit();
}

