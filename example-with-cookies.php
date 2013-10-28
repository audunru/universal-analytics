<?php
/*
* This example shows how to get and set the _ga cookie, track a
* pageview and an event using the Measurement Protocol.
*
* For more examples of tracking with the Measurement Protocol, see
* https://developers.google.com/analytics/devguides/collection/protocol/v1/devguide
*
* For a list of all parameters, see
* https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters
*/

require ('class.universalAnalyticsCookie.php');
require ('class.universalAnalytics.php');

// Tracking ID (required)
$tid = 'UA-20250367-2';

/*
* Get existing Client ID from the _ga cookie, or set a new cookie
* If the _ga cookie exists, that means the user has visited the
* site before. The cookie may have been set by Google Analytics
* Javascript code, or by universalAnalyticsCookie. Either way,
* we'll reuse the Client ID if we can, which means that we won't
* count the same user twice if both Javascript and server-side
* tracking is being used.
*/

$cookie = new universalAnalyticsCookie ();
if (!$cid = $cookie->getCid ()) {

	$cid = $cookie->set ();

}

// Use $_SERVER variables for host, path and referer
$useServer = true;

$ua = new universalAnalytics (
	$tid,
	$cid,
	$useServer);

/*
* Track pageview
*
* 't' is a required parameter, see
* https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#t
*
* 'dp' is the document path, see
* https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#dp
*/

$ua->track (array (
	't' => 'pageview',
	'dp' => '/example'));

/*
* Track event
*
* 'ec' is the event category, seee
* https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ec
*
* 'ea' is the event action, seee
* https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#ea
*/

$ua->track (array (
	't' => 'event',
	'ec' => 'Download',
	'ea' => '/files/example.pdf'));
?>