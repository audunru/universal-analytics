<?php
	
class uuidv4 {
	static function generate () {
		// Returns a random UUID
		// By Andrew Moore
		// http://www.php.net/manual/en/function.uniqid.php#94959

		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand ( 0, 0xffff ), mt_rand( 0, 0xffff ),

			// 16 bits for "time_mid"
			mt_rand ( 0, 0xffff ),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand ( 0, 0x0fff ) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand ( 0, 0x3fff ) | 0x8000,

			// 48 bits for "node"
			mt_rand ( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
		);
	}
	static function generateFromString ($string) {
		// Returns a UUID based on the input string
		// The same string will always return the same UUID
		// Obviously there's a potential for collisions here

		$uuid = sha1 ($string);
		return preg_replace ("/^(.{8})(.{4}).(.{3}).(.{3})(.{12}).*$/", '$1-$2-4$3-8$4-$5', $uuid);

	}
}
	
?>