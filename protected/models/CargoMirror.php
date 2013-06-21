<?php
/**
 * @author Nick Kaye <nick.c.kaye@gmail.com>
 * ©2013 Outright Mental Inc.
 * All Rights Reserved
 */
class CargoMirror {
    /** @var String */
    private $filename;
    /** @var Array */
    private $config;

    /**
     * Object Constructor
     * @param Array $config
     * @param String $filename
     */
    function __construct($config, $filename)
    {
        $this->config = $config;
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    function getHeader()
    {
        return 'Content-Type: text/html; charset=UTF-8';
    }

    /**
     * @return string
     */
    function getContent()
    {
        return '<html><head><title>Test</title></head><body>' . $this->filename . '</body></html>';
    }

}