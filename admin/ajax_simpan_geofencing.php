<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

if ( isset( $_POST[ 'jenis' ] ) ) {
		$sql_insert = "INSERT INTO `tb_geofencing`(`id_geofencing`, `id_user`, `nama`, `jenis`, `status`, `bentuk`) VALUES (NULL,'".$_SESSION['s_nuptk']."','".$_POST[ 'nama' ]."','".$_POST[ 'jenis' ]."','0','".$_POST[ 'bentuk' ]."')";
		$res_insert = mysqli_query( $link, $sql_insert );
	
		$sql_select = "SELECT id_geofencing FROM `tb_geofencing` where jenis='".$_POST[ 'jenis' ]."' ORDER BY id_geofencing DESC LIMIT 1";
		$res_select = mysqli_query($link, $sql_select);
	
		while($data = mysqli_fetch_assoc( $res_select )){
			$id_geofencing = $data['id_geofencing'];
		}
	
		$data_json = array(
			'id_geofencing' => $id_geofencing
		);
}
echo json_encode( $data_json );
mysqli_close($link);
?>