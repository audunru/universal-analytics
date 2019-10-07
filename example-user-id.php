<?php
/*
* This example shows how to track a pageview with a custom Client ID
*
* You can use this with something like hcitool (a Bluetooth command line tool for Linux)
* to scan for nearby Bluetooth devices and track them using Universal Analytics
*
* For more examples of tracking with the Measurement Protocol, see
* https://developers.google.com/analytics/devguides/collection/protocol/v1/devguide
*
* For a list of all parameters, see
* https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters
*/

require 'class.universalAnalytics.php';
require 'class.uuidv4.php';

// Tracking ID (required)
$tid = 'UA-20250367-4';

while ($string = trim(fgets(STDIN))) {
    /*
    * Client ID (required)
    *
    * Since we're not getting the Client ID from the _ga cookie, we have
    * to generate it ourselves.
    *
    * Our source for the Client ID is STDIN, so whatever is read from STDIN
    * will be turned into a Client ID by the generateFromString function
    */

    $cid = uuidv4::generateFromString($string);

    $ua = new universalAnalytics(
        $tid,
        $cid);

    /*
    * Track pageview
    *
    * 't' is a required parameter, see
    * https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#t
    *
    * 'dh' is the host, see
    * https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#dh
    *
    * 'dp' is the page path, see
    * https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#dp
    */

    $ua->track([
        't'     => 'pageview',
        'dh'    => 'localhost',
        'dp'    => '/butikker/hamar/kvittering',
        'uid'   => $string,
        'cs'    => 'Hamar',
        'cm'    => 'offline',
        'pa'    => 'purchase', // Enhanced Ecommerce Action
        'ti'    => rand(), // Transaction ID
        'ta'    => 'Hamar', // Name of store
        'tr'    => 200, // Revenue
        'tt'    => 0, // Tax
        'ts'    => 0, // Shipping
        'pr1nm' => 'Banan', // Product name
        'pr1id' => 2437694, // Product ID
        'pr1pr' => 200, // Product price
        'pr1br' => 'BAMA', // Product Brand
        'pr1ca' => 'Frukt og grønnsaker/Frukt', // Product Category
        'pr1va' => 'Vanlig', // Product Variant
        'pr1qt' => 1, ]); // Product Quantity
    echo 'Tracked pageview for Client ID '.$cid.' and User ID '.$string."\n";
}
