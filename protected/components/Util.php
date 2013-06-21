<?php
/**
 * @author Nick Kaye <nick.c.kaye@gmail.com>
 * ©2013 Outright Mental Inc.
 * All Rights Reserved
 */
class Util {

    /**
     * Return 404 error and exit
     */
    static public function err404() {
        header("HTTP/1.0 404 Not Found");
        exit;
    }
}