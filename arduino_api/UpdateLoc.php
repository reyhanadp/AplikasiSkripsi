<?php

require( '../koneksi.php' );
$link = koneksi_db();

$nis = $_GET[ 'nis' ];
$lng = $_GET[ 'lng' ];
$lat = $_GET[ 'lat' ];

$Sql_Query = "update tb_siswa SET longitude = '$lng', lat = '$lat' , update_time = CURRENT_TIMESTAMP WHERE nis = '$nis';";

$res = mysqli_query( $link, $Sql_Query );

if ( $res ) {
	echo "Sukses";
} else {
	echo "Invalid Query Please Try Again";
}
mysqli_close( $link );


?>