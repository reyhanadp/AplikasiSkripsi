<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

if ( count( $_POST[ 'latitude' ] ) != 0 ) {
	$nama = $_POST[ 'nama' ];
	$sql_insert = "INSERT INTO `tb_geofencing`(`id_geofencing`, `id_user`, `nama`, `jenis`, `status`, `bentuk`) VALUES (NULL,'" . $_SESSION[ 's_nuptk' ] . "','$nama','sekolah','0','polygon')";
	$res_insert = mysqli_query( $link, $sql_insert );

	$sql_select = "SELECT `id_geofencing` FROM `tb_geofencing` ORDER BY id_geofencing DESC LIMIT 1";
	$res_select = mysqli_query( $link, $sql_select );
	$data_select = mysqli_fetch_array( $res_select );


	for ( $i = 0; $i < count( $_POST[ 'latitude' ] ); $i++ ) {
		$sql_insert_koordinat = "INSERT INTO `tb_koordinat`(`id_koordinat`, `id_geofencing`, `latitude`, `longitude`, `radius`) VALUES (NULL,'" . $data_select[ 'id_geofencing' ] . "','" . $_POST[ 'latitude' ][ $i ] . "','" . $_POST[ 'longitude' ][ $i ] . "',NULL)";
		$res_insert_koordinat = mysqli_query( $link, $sql_insert_koordinat );
	}
}
echo ("<script> location.href ='index.php?menu=geofencing&action=tampil';</script>");
?>