<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$sql_tampil_badge = "SELECT id_pesan, `id_pengirim` FROM `tb_pesan` WHERE `id_penerima`='" . $_SESSION[ 's_id_orangtua' ] . "' AND `status`='0' ORDER BY `id_pesan` DESC";
$res_tampil_badge = mysqli_query( $link, $sql_tampil_badge );

$id_pengirim = array();
$jumlah=0;
while ( $data_tampil_badge = mysqli_fetch_array( $res_tampil_badge ) ) {
	$sama = 0;
	
	for($i=0 ; $i< count($id_pengirim);$i++){
		if($data_tampil_badge[ 'id_pengirim' ] == $id_pengirim[$i]){
			$sama = 1;
			break;
		}
	}
	
	if($sama==0){
		array_push($id_pengirim,$data_tampil_badge[ 'id_pengirim' ]);
		$jumlah = $jumlah + 1;
	}
}

$data = array(
	'jumlah' => $jumlah
);

echo json_encode( $data );

mysqli_close($link);
?>