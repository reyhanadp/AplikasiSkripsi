<?php
require "../koneksi.php";

$link = koneksi_db();


function getaddress( $lat, $lng ) {
	$url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim( $lat ) . ',' . trim( $lng ) . '&key=AIzaSyDeSbTd4xPktRSQwbytnDN33ugM6sJrq_0';
	$json = @file_get_contents( $url );
	$data = json_decode( $json );
	$status = $data->status;
	if ( $status == "OK" ) {
		return $data->results[ 0 ]->formatted_address;
	} else {
		return false;
	}
}

//$alamat = getaddress( $_POST['lat'], $_POST['lng'] );
//getaddress( $_POST['lat'], $_POST['lng'] )
$data = array(
	'alamat' => $_POST['lat']
	
);

echo json_encode( $data );
?>