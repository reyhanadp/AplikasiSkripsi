<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$sql_tampil_badge = "SELECT id_status FROM `tb_status` WHERE `status`=0 AND `id_user`='" . $_SESSION[ 's_nuptk' ] . "'";
$res_tampil_badge = mysqli_query( $link, $sql_tampil_badge );
$jumlah = mysqli_num_rows( $res_tampil_badge );

$data = array(
	'jumlah' => $jumlah
);

echo json_encode( $data );
mysqli_close($link);

?>