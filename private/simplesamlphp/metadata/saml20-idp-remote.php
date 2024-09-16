<?php

/**
 * SAML 2.0 remote IdP metadata for SimpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote
 */

$baseDir = dirname(dirname(__FILE__));
require $baseDir . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR .  'sandiego_envs.php';

$metadata[$envs[$_SERVER['HTTP_HOST']]['endpoint']] = array (
    'entityid' => $envs[$_SERVER['HTTP_HOST']]['endpoint'],
    'contacts' =>
        array (
        ),
    'metadata-set' => 'saml20-idp-remote',
    'SingleSignOnService' =>
        array (
            0 =>
                array (
                    'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
                    'Location' => $envs[$_SERVER['HTTP_HOST']]['location'],
                ),
            1 =>
                array (
                    'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
                    'Location' => $envs[$_SERVER['HTTP_HOST']]['location'],
                ),
        ),
    'SingleLogoutService' => [],
    'ArtifactResolutionService' => [],
    'NameIDFormats' =>
        array (
            0 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
            1 => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
        ),
    'keys' =>
        array (
            0 =>
                array (
                    'encryption' => false,
                    'signing' => true,
                    'type' => 'X509Certificate',
                    'X509Certificate' => $envs[$_SERVER['HTTP_HOST']]['X509Certificate'], 
                ),
        ),
);
