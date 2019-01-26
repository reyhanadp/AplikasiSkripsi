<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$nis = $_POST[ 'nis' ];
$nama = $_POST[ 'nama' ];
$kelas = $_POST[ 'kelas' ];
$perintah = $_POST[ 'perintah' ];

if ( $perintah == "0 jadi 4" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='4' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
	
	$query_insert_notif = "insert into tb_notifikasi values (NULL,'$nis',NULL,'keluar sekolah dan baterai lemah',CURRENT_TIMESTAMP,'0');";
	$res_insert_notif = mysqli_query( $link, $query_insert_notif );
} else if ( $perintah == "0 jadi 2" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='2' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
	
	$query_insert_notif = "insert into tb_notifikasi values (NULL,'$nis',NULL,'keluar sekolah',CURRENT_TIMESTAMP,'0');";
	$res_insert_notif = mysqli_query( $link, $query_insert_notif );
} else if ( $perintah == "0 jadi 3" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='3' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );

	$query_insert_notif = "insert into tb_notifikasi values (NULL,'$nis',NULL,'baterai lemah',CURRENT_TIMESTAMP,'0');";
	$res_insert_notif = mysqli_query( $link, $query_insert_notif );
} else if ( $perintah == "0 jadi 5" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='5' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
} else if ( $perintah == "2 jadi 4" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='4' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
	
	$query_insert_notif = "insert into tb_notifikasi values (NULL,'$nis',NULL,'baterai lemah',CURRENT_TIMESTAMP,'0');";
	$res_insert_notif = mysqli_query( $link, $query_insert_notif );
} else if ( $perintah == "2 jadi 3" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='3' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
	
	$query_insert_notif = "insert into tb_notifikasi values (NULL,'$nis',NULL,'baterai lemah',CURRENT_TIMESTAMP,'0');";
	$res_insert_notif = mysqli_query( $link, $query_insert_notif );
} else if ( $perintah == "2 jadi 0" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='0' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
} else if( $perintah == "2 jadi 5"){
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='5' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
} else if ( $perintah == "3 jadi 4" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='4' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
	
	$query_insert_notif = "insert into tb_notifikasi values (NULL,'$nis',NULL,'keluar sekolah',CURRENT_TIMESTAMP,'0');";
	$res_insert_notif = mysqli_query( $link, $query_insert_notif );
} else if ( $perintah == "3 jadi 2" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='2' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
} else if ( $perintah == "3 jadi 0" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='0' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
} else if ( $perintah == "3 jadi 5" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='5' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
} else if ( $perintah == "4 jadi 2" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='2' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
} else if ( $perintah == "4 jadi 3" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='3' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
} else if ( $perintah == "4 jadi 5" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='5' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
} else if ( $perintah == "4 jadi 0" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='0' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
} else if ( $perintah == "5 jadi 3" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='3' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
	
	$query_insert_notif = "insert into tb_notifikasi values (NULL,'$nis',NULL,'baterai lemah',CURRENT_TIMESTAMP,'0');";
	$res_insert_notif = mysqli_query( $link, $query_insert_notif );
} else if ( $perintah == "5 jadi 0" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='0' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
} else if ( $perintah == "6 jadi 3" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='3' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
	
	$query_insert_notif = "insert into tb_notifikasi values (NULL,'$nis',NULL,'baterai lemah',CURRENT_TIMESTAMP,'0');";
	$res_insert_notif = mysqli_query( $link, $query_insert_notif );
} else if ( $perintah == "6 jadi 0" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='0' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
}
mysqli_close($link);
?>