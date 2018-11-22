<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

if ( isset( $_POST[ 'jenis' ] ) ) {
	$sql_delete = "DELETE FROM `tb_koordinat` WHERE `id_geofencing`='" . $_POST[ 'id_geofencing' ] . "'";
	$res_delete = mysqli_query( $link, $sql_delete );

	if ( $res_delete ) {
		$data_json = array(
			'hasil' => "berhasil"
		);
	} else {
		$data_json = array(
			'hasil' => "gagal"
		);
	}
	echo json_encode( $data_json );
}


?>