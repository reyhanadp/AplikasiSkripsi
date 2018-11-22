<?php
if ( isset( $_GET[ 'nis' ] ) && isset($_GET[ 'lat' ]) && isset($_GET[ 'lng' ])) {
	$nis = $_GET[ 'nis' ];
	$longitude = $_GET[ 'lng' ];
	$lat = $_GET[ 'lat' ];

	$req = curl_init();
	curl_setopt($req, CURLOPT_URL,"https://slbcsukapura.com/arduino_api/UpdateLoc.php?nis=$nis&lat=$lat&lng=$longitude");
	curl_exec($req);
} else {
	echo "Check Again";
}


?>