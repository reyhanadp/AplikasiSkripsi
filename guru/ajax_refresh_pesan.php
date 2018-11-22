<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query = "SELECT * FROM `tb_pesan` WHERE (`id_pengirim`='" . $_SESSION[ 's_nuptk' ] . "' AND `id_penerima`='" . $_POST[ 'id' ] . "') OR (`id_pengirim`='" . $_POST[ 'id' ] . "' AND `id_penerima`='" . $_SESSION[ 's_nuptk' ] . "') ORDER BY waktu ASC";
$result = mysqli_query( $link, $query );


while ( $data = mysqli_fetch_assoc( $result ) ) {

	if ( $data[ 'id_pengirim' ] == $_POST[ 'id' ] ) {
		?>
		<div class="msg_a"><?php echo $data['isi_pesan'];?></div>
		<?php
	} else {
		?>
		<div class="msg_b"><?php echo $data['isi_pesan'];?></div>
		<?php
	}
}


?>