<?php
require "../koneksi.php";

$link = koneksi_db();

$query_guru = "select nuptk, no_hp from tb_guru where smartphone='tidak' AND no_hp is not null";
$res_guru = mysqli_query( $link, $query_guru );
$data_json = array();
while ( $data = mysqli_fetch_assoc( $res_guru ) ) {
	$data_json[] = $data;
}
echo json_encode( $data_json );



?>