<?php
/* auth.php
 * Copyright (c) 2020 Rapida
 * All rights reserved.
 * Contributors:
 *  Lauri Jokipii <lauri.jokipii@rapida.fi>
 *
 * Part of any backend.
 * Authentication
 * It is important and convenient that the check is against same auth as UI.
 * First we check for Basic Auth for communication between systems.
 *
 * Requires settings to be read in.
 */

$valid_user = $settings['api']['user'];
$valid_pass = $settings['api']['pass'];
$valid_passwords = array($valid_user => $valid_pass);
$valid_users = array_keys($valid_passwords);

$validated = false;

if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
  $user = $_SERVER['PHP_AUTH_USER'];
  $pass = $_SERVER['PHP_AUTH_PW'];

  $validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);
}

if (!$validated) {
  header('HTTP/1.0 401 Unauthorized');
  die ("Not authorized");
  // the same as frontend relies on!
  //require_once('/opt/simplesamlphp/lib/_autoload.php');
  //$as = new \SimpleSAML\Auth\Simple('my_app_specific_saml');
  //$as->requireAuth();
}
// If arrives here, is a valid user.

// included file, no end tag