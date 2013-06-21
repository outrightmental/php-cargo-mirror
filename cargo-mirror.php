<?php
/**
 * @author Nick Kaye <nick.c.kaye@gmail.com>
 * ©2013 Outright Mental Inc.
 * All Rights Reserved
 */
$config = require_once('protected/config.php');
require_once('protected/components/Util.php');
require_once('protected/models/CargoMirror.php');

// Must have a filename
if (!isset($_GET['f']))
    Util::err404();

// Instantiate CargoMirror
$CargoMirror = new CargoMirror($config, $_GET['f']);

// Output
header($CargoMirror->getHeader());
echo $CargoMirror->getContent();
exit;