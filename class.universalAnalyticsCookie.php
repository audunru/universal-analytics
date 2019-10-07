<?php

class universalAnalyticsCookie
{
    /*
    * Name: Universal Analytics Cookie Parser Class
    * Description: Parses the new format Universal Analytics cookie.
    * Developer: Matt Clarke
    * Date: January 10, 2013
    * Modified by Audun Rundberg
    */

    /**
     * Hostname to use when setting the cookie.
     *
     * @var string|null
     */
    private $cookieDomain;

    /**
     * Create a new cookie instance.
     *
     * @param string|null $cookieDomain
     */
    public function __construct($cookieDomain = null)
    {
        $this->cookieDomain = $cookieDomain;
    }

    /**
     * Get cid from the cookie.
     *
     * @return string|bool
     */
    public function getCid()
    {
        if (isset($_COOKIE['_ga'])) {
            $contents = $this->parse();

            return $contents['cid'];
        } else {
            return false;
        }
    }

    /**
     * Handle the parsing of the _ga cookie
     * This assumes the 32bit + 32bit CID format, not the new
     * UUID v4 format.
     *
     * @return array
     */
    private function parse()
    {
        list($version, $domainDepth, $cid1, $cid2) = explode('.', $_COOKIE['_ga'], 4);

        return ['version' => $version, 'domainDepth' => $domainDepth, 'cid' => $cid1.'.'.$cid2];
    }

    /**
     * Creates a new GA cookie and returns the tracking id (cid).
     *
     * @return string
     */
    public function set()
    {
        $cid1 = mt_rand(0, 2147483647);
        $cid2 = mt_rand(0, 2147483647);

        $cid = $cid1.'.'.$cid2;
        setcookie('_ga', '1.2.'.$cid, time() + 60 * 60 * 24 * 365 * 2, '/', $this->cookieDomain);

        return $cid;
    }
}
