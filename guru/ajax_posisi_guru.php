<?php
require "../koneksi.php";

$link = koneksi_db();

$query_guru = "select latitude,longitude from tb_guru where latitude is not null";
$res_guru = mysqli_query( $link, $query_guru );
$data_json = array();
while ( $data = mysqli_fetch_assoc( $res_guru ) ) {
	$data_json[] = $data;
}
echo json_encode( $data_json );



?>