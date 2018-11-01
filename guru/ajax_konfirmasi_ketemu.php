<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query_update_laporan = "update tb_laporan set waktu_ketemu=CURRENT_TIMESTAMP , lat='" . $_POST[ 'lat' ] . "', longtitude='" . $_POST[ 'longitude' ] . "' where waktu_kabur='" . $_POST[ 'waktu' ] . "'";
		$result_update_laporan = mysqli_query( $link, $query_update_laporan );


?>