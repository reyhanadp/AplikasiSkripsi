<?php
session_start();
require '../sms_gateway/autoload.php';
require "../koneksi.php";
$link = koneksi_db();

$query_insert_status = "INSERT INTO `tb_status` VALUES (NULL,'" . $_POST[ 'id_notifikasi' ] . "','" . $_SESSION[ 's_nuptk' ] . "','1')";
$result_insert_status = mysqli_query( $link, $query_insert_status );

$query_ambil_device = "SELECT `id_device` FROM `tb_device` WHERE `status`='aktif'";
$result_ambil_device = mysqli_query($link,$query_ambil_device);
$data_ambil_device = mysqli_fetch_array($result_ambil_device);

use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\Model\SendMessageRequest;

// Configure client
$config = Configuration::getDefaultConfiguration();
$config->setApiKey('Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU0Mjc1OTI1MywiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjY0MzE0LCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.PyBLVXdPAhWPzbP4PPISIziDQXC0EMQLsmIWCAhYAL8');
$apiClient = new ApiClient($config);
$messageClient = new MessageApi($apiClient);

// Sending a SMS Message
$sendMessageRequest1 = new SendMessageRequest([
    'phoneNumber' => $_POST['no_hp'],
    'message' => 'nama : '.$_POST['nama_siswa'].'
Kelas : '.$_POST['kelas'].' '.$_POST['tingkatan'].'
Status : '.$_POST['pesan'].'
Lokasi : '.$_POST['lokasi'],
    'deviceId' => $data_ambil_device['id_device']
]);
$sendMessages = $messageClient->sendMessages([
    $sendMessageRequest1
]);


?>