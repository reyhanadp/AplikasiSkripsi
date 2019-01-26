<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query = "INSERT INTO `tb_pesan`(`id_pesan`, `id_pengirim`, `id_penerima`, `isi_pesan`, `waktu`, `status`) VALUES (NULL,'" . $_SESSION[ 's_nuptk' ] . "','" . $_POST[ 'id' ] . "','" . $_POST[ 'pesan' ] . "',CURRENT_TIMESTAMP,'0')";
$result = mysqli_query( $link, $query );

if ( $result ) {
	$data_json = array(
		'sukses' => 'berhasil'
	);
} else {
	$data_json = array(
		'sukses' => 'tidak berhasil'
	);

}
echo json_encode( $data_json );
mysqli_close($link);
?>