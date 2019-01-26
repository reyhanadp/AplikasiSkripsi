<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query = "UPDATE `tb_pesan` SET `status`='1' WHERE `id_penerima`='" . $_SESSION[ 's_id_orangtua' ] . "' AND id_pengirim='".$_POST['id']."'";
$result = mysqli_query( $link, $query );

mysqli_close($link);

?>