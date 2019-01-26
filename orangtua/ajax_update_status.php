<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$nis = $_POST[ 'nis' ];
$nama = $_POST[ 'nama' ];
$kelas = $_POST[ 'kelas' ];
$perintah = $_POST[ 'perintah' ];

$sql = "select nuptk from tb_guru where kode_jabatan='KSK'";
$res = mysqli_query($link,$sql);
$data = mysqli_fetch_array($res);

if ( $perintah == "5 jadi 6" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='6' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
} else if ( $perintah == "6 jadi 5" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='5' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
	
	$query_insert_notif = "insert into tb_notifikasi values (NULL,'$nis','".$data['nuptk']."','keluar rumah',CURRENT_TIMESTAMP,'1');";
	$res_insert_notif = mysqli_query( $link, $query_insert_notif );
} else if ( $perintah == "4 jadi 6" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='6' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
} else if ( $perintah == "2 jadi 6" ) {
	$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='6' WHERE nis='$nis';";
	$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );
}
mysqli_close($link);
?>