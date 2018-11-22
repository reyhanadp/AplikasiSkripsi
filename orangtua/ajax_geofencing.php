<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query = "SELECT * FROM `tb_geofencing` where jenis='orangtua' AND status='0' AND id_user='".$_SESSION['s_id_orangtua']."'";
$result = mysqli_query( $link, $query );
$data_json = array();
while ( $data = mysqli_fetch_assoc( $result ) ) {
	$data_json[] = $data;
}
echo json_encode( $data_json );
mysqli_close($link);
?>