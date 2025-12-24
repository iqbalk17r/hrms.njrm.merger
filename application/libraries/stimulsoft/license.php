<?php

// You can check the user authorization to send a license key only if the result is positive.
//echo dirname(__FILE__) ."\license.key";
if (file_exists(dirname(__FILE__) ."\license.key")) {
	$license = file_get_contents(dirname(__FILE__) ."\license.key");
	return $license;
}

?>
