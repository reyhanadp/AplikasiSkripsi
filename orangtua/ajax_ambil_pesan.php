<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query = "SELECT * FROM `tb_pesan` WHERE (`id_pengirim`='" . $_SESSION[ 's_id_orangtua' ] . "' AND `id_penerima`='" . $_POST[ 'id' ] . "') OR (`id_pengirim`='" . $_POST[ 'id' ] . "' AND `id_penerima`='" . $_SESSION[ 's_id_orangtua' ] . "') ORDER BY waktu ASC";
$result = mysqli_query( $link, $query );

$data_json = array();
while ( $data = mysqli_fetch_assoc( $result ) ) {
	$data_json[] = $data;
}
echo json_encode( $data_json );
mysqli_close($link);
?>