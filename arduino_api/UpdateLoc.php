<?php
if ( isset( $_GET[ 'nis' ] ) && isset($_GET[ 'lat' ]) && isset($_GET[ 'lng' ])) {
	
	require('../koneksi.php');
	$link = koneksi_db();

	$nis = $_GET[ 'nis' ];
	$longitude = $_GET[ 'lng' ];
	$lat = $_GET[ 'lat' ];

	$Sql_Query = "update tb_siswa SET longitude = '$longitude', lat = '$lat' , update_time = CURRENT_TIMESTAMP WHERE nis = '$nis';";

	$res = mysqli_query( $link, $Sql_Query );

	if ( $res ) {
		echo "Sukses";
	} else {
		echo "Invalid Query Please Try Again";
	}
	mysqli_close( $link );
} else {
	echo "Check Again";
}


?>