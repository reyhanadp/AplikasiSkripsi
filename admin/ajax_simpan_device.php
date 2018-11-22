<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$sql = "INSERT INTO `tb_device`(`id_device`, `nuptk`, `tipe`, `nama`, `status`) VALUES ('".$_POST['id']."','".$_SESSION['s_nuptk']."','".$_POST['tipe']."','".$_POST['nama']."','".$_POST['status']."')";
$res = mysqli_query( $link, $sql );

?>