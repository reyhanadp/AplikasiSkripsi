<?php
	session_start();
	require('../koneksi.php');
	$link = koneksi_db();
	
	$sql = "SELECT nama,`lat`,`longitude` FROM `tb_siswa` WHERE `nis`='".$_POST['nis']."'";
	$res = mysqli_query($link,$sql);
	$data_lat_lng = mysqli_fetch_array($res);
	
	$data = array(
		'nama' => $data_lat_lng['nama'],
		'lat' => $data_lat_lng['lat'],
		'lng' => $data_lat_lng['longitude']
	);

	echo json_encode( $data );

?>