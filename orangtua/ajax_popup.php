<?php
session_start();
require "../koneksi.php";

$link = koneksi_db();

$query_notif = "SELECT id_notifikasi,nama,foto,pesan_notif FROM `tb_notifikasi` JOIN tb_siswa ON tb_notifikasi.nis=tb_siswa.nis WHERE  tb_notifikasi.status=1 and id_notifikasi not in (SELECT id_notifikasi from tb_status where id_user='" . $_SESSION[ 's_id_orangtua' ] . "') AND tb_siswa.nis in (SELECT nis FROM tb_siswa WHERE id_orangtua='" . $_SESSION[ 's_id_orangtua' ] . "')";
$result_notif = mysqli_query( $link, $query_notif );
$jumlah = mysqli_num_rows( $result_notif );
$rows = array();
$array = array();

while ( $data_notif = mysqli_fetch_array( $result_notif ) ) {
	$query_insert_status = "INSERT INTO `tb_status` VALUES (NULL,'" . $data_notif[ 'id_notifikasi' ] . "','" . $_SESSION[ 's_id_orangtua' ] . "','0')";
	$result_insert_status = mysqli_query( $link, $query_insert_status );
	$rows[] = $data_notif;
}
$array[ 'notif' ] = $rows;
$array[ 'jumlah' ] = $jumlah;
echo json_encode( $array );

mysqli_close( $link );

?>