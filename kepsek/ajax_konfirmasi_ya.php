<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query_update_notifikasi = "update tb_notifikasi set status=1, nuptk='" . $_SESSION[ 's_nuptk' ] . "' where id_notifikasi='" . $_POST[ 'idNotifikasi' ] . "'";
$result_update_notifikasi = mysqli_query( $link, $query_update_notifikasi );
if ( $_POST[ 'pesan' ] != "baterai lemah" ) {
	$query_insert_laporan = "insert into tb_laporan values (NULL,'" . $_POST[ 'nis' ] . "','" . $_POST[ 'waktu' ] . "',NULL,NULL,NULL)";
	$result_insert_laporan = mysqli_query( $link, $query_insert_laporan );
}

mysqli_close($link);
?>