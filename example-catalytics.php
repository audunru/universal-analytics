<?php
/*
* Name: Catalytics
* Description: Track cat eating habits using an RFID reader and Universal Analytics
* Developer: Audun Rundberg
* Date: August 2, 2013
*/

// Usage:
// $ cat /dev/ttyUSB0 | php example-catalytics.php
// Replace ttyUSB0 with your device

require ('class.universalAnalytics.php');

// Tracking ID
$tid = 'UA-20250367-4';

// Event to track
$ec = 'Cat';

// Action to track
$ea = 'Foodbowl';

/*
* timestamp is used to save the time each RFID tag was last scanned.
* Since the RFID reader continues to scan the RFID tag as long as it's within
* range, we have to
*/
$timestamp = array ();

// Wait this long between tracking each RFID tag
$wait = 60*5;

// Read RFID tag from STDIN and track the pageview
while ($cid = trim (fgets (STDIN))) {

	// Only track the pageview if the timestamp for the $cid has expired
	if (!isset ($timestamp[$cid]) or $timestamp[$cid] + $wait < time ()) {

		// Track the pageview
		$ua = new universalAnalytics (
			$tid,
			$cid);

		$ua->track (array (
			't' => 'event',
			'ec' => $ec,
			'ea' => $ea));

		$timestamp[$cid] = time ();

		echo "Tracked event for: $cid\n";

	}
	else {

		echo "RFID scanned, but not tracked. Timeout expires " . date ('r', $timestamp[$cid] + $wait) . "\n";

	}

}
?>