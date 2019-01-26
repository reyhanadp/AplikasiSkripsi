<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

if ( isset( $_POST[ 'jenis' ] ) ) {
	$sql_update = "UPDATE `tb_geofencing` SET `status`='1' WHERE `id_geofencing`='" . $_POST[ 'id_geofencing' ] . "'";
	$res_update = mysqli_query( $link, $sql_update );

	if ( $res_update ) {
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

mysqli_close($link);
?>