<?php
session_start();
require( 'koneksi.php' );
$link = koneksi_db();

$query = "SELECT lat,longitude FROM `tb_siswa` WHERE nis='112'";
$result = mysqli_query( $link, $query );


while ( $data = mysqli_fetch_assoc( $result ) ) {

	?>
	<h1>latitude</h1>
	<h2><?php echo $data['lat']; ?></h2>
	<h1>longitude</h1>
	<h2><?php echo $data['longitude']; ?></h2>
	<h1>akurasi</h1>
	
<?php
}


?>