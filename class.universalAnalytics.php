<?php

class universalAnalytics
{
    /*
    * Name: Universal Analytics tracking class
    * Description: Track user behaviour using Google's measurement protocol
    * Developer: Audun Rundberg
    * Date: August 2, 2013
    */

    protected $commonParameters = [];
    protected $version = '1';
    protected $url = 'http://www.google-analytics.com/collect';

    /**
     * Inital setup of the tracking info to be submitted to Google.
     *
     * @param string $tid       The Universal Analytics tracking ID, i.e. UA-XXXXX-X
     * @param string $cid       The Client ID, which can be part of the cookie
     * @param bool   $useServer Indicates if we should use $_SERVER to set the host, path and referer parameters
     */
    public function __construct($tid, $cid, $useServer = false)
    {
        // Version (required)
        $this->commonParameters['v'] = $this->version;

        // Tracking ID (required)
        $this->commonParameters['tid'] = $tid;

        // Client ID (required)
        $this->commonParameters['cid'] = $cid;

        // Host, path and referer are not required, but we probably want
        // to set them and can do so using $_SERVER
        if ($useServer) {
            if (array_key_exists('SERVER_NAME', $_SERVER)) {
                $this->commonParameters['dh'] = $_SERVER['SERVER_NAME'];
            }
            if (array_key_exists('REQUEST_URI', $_SERVER)) {
                $this->commonParameters['dp'] = $_SERVER['REQUEST_URI'];
            }
            if (array_key_exists('HTTP_REFERER', $_SERVER)) {
                $this->commonParameters['dr'] = $_SERVER['HTTP_REFERER'];
            }
        }
    }

    /**
     * Track the event/pageview.
     *
     * The minimum requirement is to supply the "Hit type" parameter, i.e. array ('t' => 'pageview')
     * See https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#t
     *
     * @param array $parameters Values that will be sent to Google
     */
    public function track($parameters)
    {
        try {
            // Require parameter 't'
            if (is_array($parameters) and isset($parameters['t'])) {
                $parameters = array_merge($this->commonParameters, $parameters);
            } else {
                throw new Exception('Hit type parameter "t" is required');
            }

            $ch = curl_init();

            //set the url and don't output the data directly
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Add user-agent to the request
            if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
                curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            }
            //url-ify the data for the POST
            $parametersString = http_build_query($parameters);

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $parametersString);

            //execute post request
            curl_exec($ch);

            // Get info
            if ('2' != substr(curl_getinfo($ch, CURLINFO_HTTP_CODE), 0, 1)) {
                throw new Exception('HTTP status code is not 2XX. Something went wrong.');
            }

            //close connection
            curl_close($ch);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
