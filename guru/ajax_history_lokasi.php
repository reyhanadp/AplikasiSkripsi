<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();
$query = "SELECT * FROM `tb_history_lokasi` WHERE `waktu_update` between '" . $_POST[ 'waktu_awal' ] . "' and '" . $_POST[ 'waktu_akhir' ] . "' and nis='".$_POST['nis']."' ORDER BY waktu_update ASC";
$result = mysqli_query( $link, $query );
$data_json = array();
while ( $data = mysqli_fetch_assoc( $result ) ) {
	$data_json[] = $data;
}
echo json_encode( $data_json );

mysqli_close( $link );

?>