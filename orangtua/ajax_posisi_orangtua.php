<?php
require "../koneksi.php";

$link = koneksi_db();

$query_guru = "select latitude,longitude from tb_orangtua where latitude is not null AND id_orangtua='".$_SESSION['s_id_orangtua']."'";
$res_guru = mysqli_query( $link, $query_guru );
$data_json = array();
while ( $data = mysqli_fetch_assoc( $res_guru ) ) {
	$data_json[] = $data;
}
echo json_encode( $data_json );

mysqli_close($link);

?>