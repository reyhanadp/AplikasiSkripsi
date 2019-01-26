<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

if ( isset( $_POST[ 'jenis' ] ) ) {
	if ( $_POST[ 'jenis' ] == "orangtua" ) {
		$jenis = $_POST[ 'jenis' ];

		$query = "SELECT * FROM `tb_geofencing` where jenis='" . $jenis . "' AND status='0' AND id_user='".$_SESSION['s_id_orangtua']."'";
		$result = mysqli_query( $link, $query );
		$i = 0;
		$data_json = array();
		while ( $data = mysqli_fetch_assoc( $result ) ) {
			$data_json[] = $data;
		}
		echo json_encode( $data_json );
	}
}
mysqli_close($link);

?>