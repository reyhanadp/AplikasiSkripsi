<?php
require "../koneksi.php";

$link = koneksi_db();

$latitude_siswa = $_POST[ 'lat_murid' ];
$longitude_siswa = $_POST[ 'longitude_murid' ];

$query_guru = "select latitude,longitude from tb_guru where latitude is not null";
$res_guru = mysqli_query( $link, $query_guru );
$jml_guru = mysqli_num_rows( $res_guru );
$array = array();
$cek_jarak = 0;
while ( $data_guru = mysqli_fetch_array( $res_guru ) ) {

	$dataJson = file_get_contents( "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=" . $data_guru[ 'latitude' ] . "," . $data_guru[ 'longitude' ] . "&destinations=" . $latitude_siswa . "," . $longitude_siswa . "&key=%20AIzaSyCWpwVwu1hO6TJW1H8x_zlhrLfbSbQ2r3o" );
	
	$data = json_decode( $dataJson, true );
	$nilaiJarak = $data[ 'rows' ][ 0 ][ 'elements' ][ 0 ][ 'distance' ][ 'value' ];

	$data = array(
		'nilaiJarak' => $nilaiJarak
	);
	$jarak[] = $nilaiJarak;
	if ( $nilaiJarak > 10 ) {
		$cek_jarak = 1;
		break;
	} else {
		$cek_jarak = 0;
	}
}

$array[ 'cek_jarak' ] = $cek_jarak;
echo json_encode( $array );



?>