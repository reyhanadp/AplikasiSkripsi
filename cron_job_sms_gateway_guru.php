<?php
require "sms_gateway/autoload.php";
require "koneksi.php";
$link = koneksi_db();

date_default_timezone_set('America/Los_Angeles');

use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\Model\SendMessageRequest;

// Configure client
$config = Configuration::getDefaultConfiguration();
$config->setApiKey( 'Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU0Mjc1OTI1MywiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjY0MzE0LCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.PyBLVXdPAhWPzbP4PPISIziDQXC0EMQLsmIWCAhYAL8' );
$apiClient = new ApiClient( $config );
$messageClient = new MessageApi( $apiClient );

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

$query_ambil_device = "SELECT `id_device` FROM `tb_device` WHERE `status`='aktif'";
$result_ambil_device = mysqli_query( $link, $query_ambil_device );
$data_ambil_device = mysqli_fetch_array( $result_ambil_device );

$query_guru = "SELECT nuptk, no_hp FROM `tb_guru` WHERE `no_hp` IS NOT null AND notif_sms ='ya'";
$res_guru = mysqli_query( $link, $query_guru );
$data_json = array();
while ( $data = mysqli_fetch_assoc( $res_guru ) ) {
    
	$query_notifikasi = "SELECT id_notifikasi,tb_siswa.lat,tb_siswa.longitude,tb_siswa.nama,tb_notifikasi.pesan_notif,tb_kelas.kelas,tb_kelas.tingkatan FROM `tb_notifikasi` JOIN tb_siswa ON tb_notifikasi.nis=tb_siswa.nis JOIN tb_kelas ON tb_siswa.id_kelas=tb_kelas.id_kelas WHERE id_notifikasi not in (SELECT id_notifikasi from tb_status where id_user='" . $data[ 'nuptk' ] . "') AND (pesan_notif = 'belum masuk sekolah' OR pesan_notif = 'kembali ke sekolah' OR pesan_notif = 'keluar sekolah' OR pesan_notif = 'baterai lemah sekolah' OR pesan_notif = 'keluar sekolah dan baterai lemah')";
	$result_notifikasi = mysqli_query( $link, $query_notifikasi );

	while ( $data_notifikasi = mysqli_fetch_assoc( $result_notifikasi ) ) {
	   // echo $data['nuptk'].' '.$data_notifikasi['id_notifikasi'].'<br>';
		$alamat_siswa = getaddress( $data_notifikasi[ 'lat' ], $data_notifikasi[ 'longitude' ] );
// 		echo $data_notifikasi[ 'alamat' ] = $alamat_siswa.'<br>';
        $data_notifikasi[ 'alamat' ] = $alamat_siswa;
        
		$query_insert_status = "INSERT INTO `tb_status` VALUES (NULL,'" . $data_notifikasi[ 'id_notifikasi' ] . "','" . $data[ 'nuptk' ] . "','0')";
		$result_insert_status = mysqli_query( $link, $query_insert_status );

		// Sending a SMS Message
$sendMessageRequest1 = new SendMessageRequest( [
'phoneNumber' => $data[ 'no_hp' ],
'message' => 'Pemberitahuan Sistem Pemantauan Anak

nama   : ' . $data_notifikasi[ 'nama' ] .'
Kelas  : ' . $data_notifikasi[ 'kelas' ] . ' ' . $data_notifikasi[ 'tingkatan' ] .'
Status : ' . $data_notifikasi[ 'pesan_notif' ] .'
Lokasi : ' . $data_notifikasi[ 'alamat' ] .'

www.google.com/maps/place/' . $data_notifikasi[ 'lat' ] . ',' . $data_notifikasi[ 'longitude' ],
'deviceId' => $data_ambil_device[ 'id_device' ]
] );
$sendMessages = $messageClient->sendMessages( [
$sendMessageRequest1
] );
	}

}





mysqli_close( $link );


?>