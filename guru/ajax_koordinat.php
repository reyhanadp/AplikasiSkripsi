<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();
if ( isset( $_POST[ 'id_geofencing' ] ) ) {
	$query = "SELECT `id_geofencing`,`latitude`,`longitude`,radius FROM `tb_koordinat` WHERE `id_geofencing`='" . $_POST[ 'id_geofencing' ] . "'";
	$result = mysqli_query( $link, $query );
	$data_json = array();
	while ( $data = mysqli_fetch_assoc( $result ) ) {
		$data_json[] = $data;
	}
	echo json_encode( $data_json );
}
mysqli_close($link);

?>