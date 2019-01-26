<?php
session_start();
require "../koneksi.php";

$link = koneksi_db();

function getaddress( $lat, $lng ) {
	$url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim( $lat ) . ',' . trim( $lng ) . '&key=AIzaSyDeSbTd4xPktRSQwbytnDN33ugM6sJrq_0';
	$json = @file_get_contents( $url );
	$data = json_decode( $json );
	$status = $data->status;
	if ( $status == "OK" ) {
		return $data->results[ 0 ]->formatted_address;
	} else {
		return false;
	}
}

$query = "SELECT id_notifikasi,tb_siswa.lat,tb_siswa.longitude,tb_siswa.nama,tb_notifikasi.pesan_notif,tb_kelas.kelas,tb_kelas.tingkatan FROM `tb_notifikasi` JOIN tb_siswa ON tb_notifikasi.nis=tb_siswa.nis JOIN tb_kelas ON tb_siswa.id_kelas=tb_kelas.id_kelas WHERE id_notifikasi not in (SELECT id_notifikasi from tb_status where id_user='" . $_POST['nuptk']. "') AND pesan_notif!='keluar rumah'";
$result = mysqli_query( $link, $query );
$data_json = array();
while ( $data = mysqli_fetch_assoc( $result ) ) {
	$alamat_siswa = getaddress( $data['lat'], $data['longitude'] );
	$data['alamat'] = $alamat_siswa;
	$data_json[] = $data;
}
echo json_encode( $data_json );



?>