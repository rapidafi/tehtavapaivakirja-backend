<?php
/* settings.php
 * Copyright (c) 2020 Rapida
 * All rights reserved.
 * Contributors:
 *  Lauri Jokipii <lauri.jokipii@rapida.fi>
 *
 * Part of any backend.
 * Centralized settings reading from ini.
 */

$settings = parse_ini_file('my_app_specific_ini', true);

$dbhost = $settings['database']['host'];
$dbport = $settings['database']['port'];
$dbname = $settings['database']['name'];
$dbschm = $settings['database']['schm'];
$dbuser = $settings['database']['user'];
$dbpass = $settings['database']['pass'];

// included file, no end tag