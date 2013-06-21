<?php
/**
 * @author Nick Kaye <nick.c.kaye@gmail.com>
 * ©2013 Outright Mental Inc.
 * All Rights Reserved
 */
class Mirror
{
    /** @var String */
    private $filename;
    /** @var String */
    private $baseUrl;
    /** @var String */
    private $sourceBaseUrl;
    /** @var String */
    private $cacheBasePath;

    /**
     * Object Constructor
     * @param $baseUrl
     * @param $sourceBaseUrl
     * @param $cacheBasePath
     * @param String $filename
     */
    function __construct($baseUrl, $sourceBaseUrl, $cacheBasePath, $filename = '')
    {
        $this->baseUrl = $baseUrl;
        $this->sourceBaseUrl = $sourceBaseUrl;
        $this->cacheBasePath = $cacheBasePath;
        $this->filename = $filename;
    }

    /**
     * @return bool
     */
    public function exec()
    {
        // Cache the file
        if (!$this->download())
            return false;

        // Output
        header($this->getCacheFileHeader());
        echo $this->getCacheFileContent();

        // Success
        return true;
    }

    /**
     * @return bool
     */
    private function download()
    {
        switch ($this->getSourceFileExtension()) {
            case 'html':
            case 'htm':
            case 'css':
            case 'js':
            case '':
                $this->downloadTransmogrified();
                break;
            default:
                $this->downloadDirect();
        }
    }

    /**
     * @return bool
     */
    private function downloadDirect()
    {
        set_time_limit(0);
        $fp = fopen($this->getCacheFilePath(), 'w+');
        $ch = curl_init($this->getSourceFileUrl());
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_FILE, $fp); // write curl response to file
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch); // get curl response
        curl_close($ch);
        fclose($fp);
        // success if cache file now exists
        return file_exists($this->getCacheFilePath());
    }

    /**
     *
     */
    private function downloadTransmogrified()
    {
        file_put_contents($this->getCacheFilePath(), $this->transmogrify(file_get_contents($this->getSourceFileUrl())));
        // success if cache file now exists
        return file_exists($this->getCacheFilePath());
    }

    /**
     * @param $content
     * @return string
     */
    private function transmogrify($content)
    {
       return str_replace(
           $this->sourceBaseUrl,
           $this->baseUrl,
           $content
       );
    }

    /**
     * @return string
     */
    private function getCacheFilePath()
    {
        return $this->cacheBasePath . (strlen($this->filename) ? $this->filename : '_');
    }

    /**
     * @return string
     */
    private function getSourceFileUrl()
    {
        return $this->sourceBaseUrl . $this->filename;
    }

    /**
     * @return string
     */
    private function getSourceFileExtension()
    {
        preg_match(
            '/\.([^\.]+)$/',
            $this->filename,
            $matches);
        return strtolower(Util::getIfSet($matches, 1, ''));
    }

    /**
     * @return string
     */
    private function getCacheFileHeader()
    {
        $fi = finfo_open(FILEINFO_MIME_TYPE);
        return 'Content-Type: ' . finfo_file($fi, $this->getCacheFilePath());
    }

    /**
     * @return string
     */
    private function getCacheFileContent()
    {
        return file_get_contents($this->getCacheFilePath());
    }

}