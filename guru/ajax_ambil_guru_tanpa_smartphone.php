<?php
session_start();
require "../koneksi.php";

$link = koneksi_db();

$query_guru = "SELECT nuptk, no_hp FROM `tb_guru` WHERE `no_hp` IS NOT null AND notif_sms ='ya' AND nuptk!='".$_SESSION['s_nuptk']."'";
$res_guru = mysqli_query( $link, $query_guru );
$data_json = array();
while ( $data = mysqli_fetch_assoc( $res_guru ) ) {
	$data_json[] = $data;
}
echo json_encode( $data_json );

mysqli_close($link);


?>