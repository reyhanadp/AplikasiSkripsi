<?php
session_start();
require "../koneksi.php";

$link = koneksi_db();

$query_notif = "SELECT id_notifikasi,tb_siswa.nama,tb_siswa.foto,pesan_notif FROM `tb_notifikasi` JOIN tb_siswa ON tb_notifikasi.nis=tb_siswa.nis WHERE id_notifikasi not in (SELECT id_notifikasi from tb_status where id_user='" . $_SESSION[ 's_nuptk' ] . "') AND (pesan_notif = 'belum masuk sekolah' OR pesan_notif = 'kembali ke sekolah' OR pesan_notif = 'keluar sekolah' OR pesan_notif = 'baterai lemah sekolah' OR pesan_notif = 'keluar sekolah dan baterai lemah')";
$result_notif = mysqli_query( $link, $query_notif );
$jumlah = mysqli_num_rows( $result_notif );
$rows = array();
$array = array();
while ( $data_notif = mysqli_fetch_array( $result_notif ) ) {
	$query_insert_status = "INSERT INTO `tb_status` VALUES (NULL,'" . $data_notif[ 'id_notifikasi' ] . "','" . $_SESSION[ 's_nuptk' ] . "','0')";
	$result_insert_status = mysqli_query( $link, $query_insert_status );
	$rows[] = $data_notif;
}
$array[ 'notif' ] = $rows;
$array[ 'jumlah' ] = $jumlah;
echo json_encode( $array );

mysqli_close($link);

?>