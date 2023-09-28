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
                    'X509Certificate' => 'MIIDrDCCApSgAwIBAgIGAV2m5u8BMA0GCSqGSIb3DQEBCwUAMIGWMQswCQYDVQQGEwJVUzETMBEG
A1UECAwKQ2FsaWZvcm5pYTEWMBQGA1UEBwwNU2FuIEZyYW5jaXNjbzENMAsGA1UECgwET2t0YTEU
MBIGA1UECwwLU1NPUHJvdmlkZXIxFzAVBgNVBAMMDmNpdHlvZnNhbmRpZWdvMRwwGgYJKoZIhvcN
AQkBFg1pbmZvQG9rdGEuY29tMB4XDTE3MDgwMzA3MDExOFoXDTI3MDgwMzA3MDIxN1owgZYxCzAJ
BgNVBAYTAlVTMRMwEQYDVQQIDApDYWxpZm9ybmlhMRYwFAYDVQQHDA1TYW4gRnJhbmNpc2NvMQ0w
CwYDVQQKDARPa3RhMRQwEgYDVQQLDAtTU09Qcm92aWRlcjEXMBUGA1UEAwwOY2l0eW9mc2FuZGll
Z28xHDAaBgkqhkiG9w0BCQEWDWluZm9Ab2t0YS5jb20wggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAw
ggEKAoIBAQDQ1e+fse9MBzCZhd1iaYR3Ysncnv5DGcgzJZjl0fLr5jCh+gCun0Zlvi+wxmtUHhnf
AEVS1YEf7pzCiZ4dtfyacSLgPO3sbhP3GnhAQ91vlAj1xwYNsdOssa5/A3l6fMdJV0UpZ3jPeF38
Ns/B1qL1G1UT936CkEvwQojl2MS7h/BkdfAtDZ9L+YaCQnuvbcwXC2Y1pc1VGI8PjyalOQ8jSdRs
Q4t8Jd/yQZuoO+YHAZnjq86ElGvEX8n8GP/p9g6XKVo2nPKkhDWA+d72BuOTFZCJOuuCS+jW1MTD
ZSJcLyYZwJvWVLlP9k/LAK7yF8uK04qqSlmnIbOCrOU+dep9AgMBAAEwDQYJKoZIhvcNAQELBQAD
ggEBAGrsPKJoYoNYDXKgMa+4cS7E2f8pVbWWI0Y1krib5z0e3NSYLfrKuldYCG+8vECRR6H+kpX8
+cpdU+LSfNo6cnE8qwxbdm1IsDu3GudLwVjI5JM67YYb3WVFCxfl478S44+NKcvAcofltzBPG6KB
OjbcO1G4EYGIW03X19+4kQ70Omdc2jR9MRXDrkoQVQkZkj9ei6QWzo+ANp5fwTdcJmE4ibFu4YlR
wlwghxzOPfqivEHarzqfQHYwfdznw3u3Rw7AcAx2tGwlROrccLwEzXYfCZcu3NSvSAXvqPs+QhSH
en2UT+ZJIvhnbIVxVjUkhAMPfo9hUJ3KIsUrrgQ2Xy0=',
                ),
        ),
);
