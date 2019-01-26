<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query_update_notifikasi = "update tb_notifikasi set status=2, nuptk='" . $_SESSION[ 's_nuptk' ] . "' where id_notifikasi='" . $_POST[ 'idNotifikasi' ] . "'";
		$result_update_notifikasi = mysqli_query( $link, $query_update_notifikasi );


?>