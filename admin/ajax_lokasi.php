<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

if ( isset( $_POST[ 'jenis' ] ) ) {
	if ( $_POST[ 'jenis' ] == "sekolah" ) {
		$jenis = $_POST[ 'jenis' ];
		$id_geofencing = $_POST['id_geofencing'];

		$query = "SELECT tb_koordinat.id_geofencing,tb_koordinat.latitude,tb_koordinat.longitude,tb_koordinat.jenis FROM `tb_geofencing` JOIN tb_koordinat on tb_geofencing.id_geofencing=tb_koordinat.id_geofencing where tb_geofencing.jenis='" . $jenis . "' and tb_koordinat.id_geofencing='".$id_geofencing."'";
		$result = mysqli_query( $link, $query );
		$i = 0;
		$data_json = array();
		while ( $data = mysqli_fetch_assoc( $result ) ) {
			$data_json[] = $data;
		}
		echo json_encode( $data_json );
	}
}


?>