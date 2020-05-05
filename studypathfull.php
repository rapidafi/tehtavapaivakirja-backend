<?php
/* studypathfull.php
 * Copyright (c) 2020 Rapida
 * All rights reserved.
 * Contributors:
 *  Lauri Jokipii <lauri.jokipii@rapida.fi>
 */

require_once('settings.php');//->settings,db*
require_once('auth.php');

try {
  $dbh = new PDO("pgsql: host=$dbhost; port=$dbport; dbname=$dbname", $dbuser, $dbpass);
} catch (PDOException $e) {
  die("Something went wrong while connecting to database: " . $e->getMessage() );
}

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

$request = array();
if (isset($_SERVER['PATH_INFO'])) {
  $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
}
$input = json_decode(file_get_contents('php://input'));
$jsonstr = json_encode($input);

$key = null;
if (count($request)>=1) {
  $key = array_shift($request);
  if (isset($key) && !$key) { #empty string basically
    unset($key);
  }
}

// create SQL based on HTTP method
switch ($method) {
  case 'GET':
    // for listing all latest data
    $sql = "
      select s.id
      ,s.content
      ,(select array_to_json(array_agg(t))
        from (
          select m.id,m.content
          ,(select array_to_json(array_agg(u))
                  from (
                    select a.id,a.content
                    from $dbschm.assignment a
                    where a.module_id = m.id
                  ) u
                ) as assignments
          from $dbschm.module m
          where m.studypath_id = s.id
        ) t
      ) modules
      from $dbschm.studypath s
    ";
    if (isset($key)) {
      $sql.= " WHERE id=?";
    } else {
      echo "[";
    }
    // excecute SQL statement
    $sth = $dbh->prepare($sql,array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    if (isset($key)) {
      $sth->bindParam(1, $key);
    }
    $sth->execute();
    $num = 0;
    while (($row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) !== FALSE) {
      if ($num++ > 0) { echo ","; }
      echo "{\"id\":".$row["id"];
      echo ",\"content\":".$row["content"];
      echo ",\"modules\":".$row["modules"];
      echo "}";
    }
    if (!isset($key)) {
      echo "]";
    }
    break;
  case 'PUT':
  case 'POST':
  case 'DELETE':
    http_response_code(405);
    break;
}

// clean up & close
$sth = null;
$dbh = null;
?>