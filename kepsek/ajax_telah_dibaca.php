<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query = "UPDATE `tb_pesan` SET `status`='1' WHERE `id_penerima`='" . $_SESSION[ 's_nuptk' ] . "'";
$result = mysqli_query( $link, $query );

mysqli_close($link);

?>