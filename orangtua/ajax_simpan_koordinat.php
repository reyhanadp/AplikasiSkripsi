<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

if ( isset( $_POST[ 'jenis' ] ) ) {
	$jenis = $_POST['jenis'];
	if($jenis == 'poly'){
		$sql_insert = "INSERT INTO `tb_koordinat`(`id_koordinat`, `id_geofencing`, `latitude`, `longitude`) VALUES (NULL,'".$_POST['id_geofencing']."','".$_POST['lat']."','".$_POST['lng']."')";
		$res_insert = mysqli_query( $link, $sql_insert );
	}else if($jenis == 'rectangle'){
		$ne_lat = $_POST['ne_lat'];
		$ne_lng = $_POST['ne_lng'];
		$sw_lat = $_POST['sw_lat'];
		$sw_lng = $_POST['sw_lng'];
		for($i = 0; $i < 4; $i++){
			if($i == 0){
				$sql_insert = "INSERT INTO `tb_koordinat`(`id_koordinat`, `id_geofencing`, `latitude`, `longitude`) VALUES (NULL,'".$_POST['id_geofencing']."','".$ne_lat."','".$sw_lng."')";
			}else if($i == 1){
				$sql_insert = "INSERT INTO `tb_koordinat`(`id_koordinat`, `id_geofencing`, `latitude`, `longitude`) VALUES (NULL,'".$_POST['id_geofencing']."','".$ne_lat."','".$ne_lng."')";
			}else if($i == 3){
				$sql_insert = "INSERT INTO `tb_koordinat`(`id_koordinat`, `id_geofencing`, `latitude`, `longitude`) VALUES (NULL,'".$_POST['id_geofencing']."','".$sw_lat."','".$sw_lng."')";
			}else if($i == 2){
				$sql_insert = "INSERT INTO `tb_koordinat`(`id_koordinat`, `id_geofencing`, `latitude`, `longitude`) VALUES (NULL,'".$_POST['id_geofencing']."','".$sw_lat."','".$ne_lng."')";
			}
			
			$res_insert = mysqli_query( $link, $sql_insert );
		}
	}
	if($res_insert){
		$data_json = array(
			'hasil' => "berhasil"
		);
	}else{
		$data_json = array(
			'hasil' => "gagal"
		);
	}
	echo json_encode( $data_json );
}
mysqli_close($link);

?>