<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

if ( isset( $_POST[ 'jenis' ] ) ) {
		$sql = "select * from tb_jabatan";
		$res = mysqli_query( $link, $sql );
	
		$data_json = array();
		while($data = mysqli_fetch_assoc( $res )){
			$data_json[] = $data;
		}
}
echo json_encode( $data_json );

?>