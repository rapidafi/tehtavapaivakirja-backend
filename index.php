<?php
/* index.php
 * Copyright (c) 2020 Rapida
 * All rights reserved.
 * Contributors:
 *  Lauri Jokipii <lauri.jokipii@rapida.fi>
 *
 * Index script for safety.
 *
 * NB! This script is not meant to be used for anything meaningful, yet.
 */

require_once('settings.php');
require_once('auth.php');

//
//
//

require 'http_response_code.php';

$headers = array();
$headers[]='Access-Control-Allow-Headers: Content-Type';
$headers[]='Access-Control-Allow-Methods: OPTIONS, GET, PUT, POST, DELETE';
$headers[]='Access-Control-Allow-Origin: *';
$headers[]='Access-Control-Allow-Credentials: true';
$headers[]='Access-Control-Max-Age: 1728000';
if (isset($_SERVER['REQUEST_METHOD'])) {
  foreach ($headers as $header) header($header);
} else {
  echo json_encode($headers);
}
header('Content-Type: application/json; charset=utf-8');

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
if ($method=='OPTIONS') {
  http_response_code(200);
  exit;
}

// NB! No operations. Atleast not yet.
echo '{"version":"'.file_get_contents("build").'"}';
http_response_code(200);
?>