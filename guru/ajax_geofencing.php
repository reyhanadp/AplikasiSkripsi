<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query = "SELECT * FROM `tb_geofencing` where jenis='sekolah' AND status='0'";
//$query = "SELECT * FROM `tb_geofencing` where status='0'";
$result = mysqli_query( $link, $query );
$data_json = array();
while ( $data = mysqli_fetch_assoc( $result ) ) {
	$data_json[] = $data;
}
echo json_encode( $data_json );
mysqli_close($link);
?>