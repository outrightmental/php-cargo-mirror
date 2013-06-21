<?php
/**
 * @author Nick Kaye <nick.c.kaye@gmail.com>
 * ©2013 Outright Mental Inc.
 * All Rights Reserved
 */

// Dependencies
require_once('protected/components/Util.php');
require_once('protected/models/Mirror.php');

// Configuration
const CARGO_USER = 'shannonholloway';

// Instantiate Mirror
$Mirror = new Mirror(
    'http://localhost/cargo-mirror/',
    'http://cargocollective.com/' . CARGO_USER . '/',
    dirname(__FILE__) . '/../',
    Util::getIfSet($_GET,'f')
);

// Failure to mirror = 404
if ($Mirror->exec())
    Util::err404();