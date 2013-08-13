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

require ('class.universalAnalytics.php');
require ('class.uuidv4.php');

// Tracking ID (required)
$tid = 'UA-114193-17';

while ($string = trim (fgets (STDIN))) {

	/*
	* Client ID (required)
	*
	* Since we're not getting the Client ID from the _ga cookie, we have
	* to generate it ourselves.
	* 
	* Our source for the Client ID is STDIN, so whatever is read from STDIN
	* will be turned into a Client ID by the generateFromString function
	*/

	$cid = uuidv4::generateFromString ($string);

	$ua = new universalAnalytics (
		$tid,
		$cid);

	/*
	* Track pageview
	* 'dh' is not required, but tracking pageviews doesn't work without a host, see
	* https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#t
	*
	* 't' is a required parameter, see
	* https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#t
	*
	* 'dp' is the document path, see
	* https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#dp
	*/

	$ua->track (array (
		'dh' => 'localhost',
		't' => 'pageview',
		'dp' => '/store'));
		
	echo 'Tracked pageview for ' . $cid . "\n";
}

?>