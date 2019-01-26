<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();
$i = 0;
if ( isset( $_GET[ 'nis' ] ) ) {
	$nis = $_GET[ 'nis' ];
	$sql_siswa = "select * from tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas=tb_kelas.id_kelas where tb_siswa.nis='$nis' AND tb_siswa.lat IS NOT NULL";

} else {
	$sql_siswa = "select TIME_FORMAT(now(), '%H:%i:%s') waktu,tb_siswa.nama,tb_siswa.baterai,tb_siswa.nis,tb_siswa.lat,tb_siswa.longitude,tb_siswa.foto,tb_siswa.status,tb_kelas.kelas,tb_kelas.jam_masuk,tb_kelas.jam_keluar from tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas=tb_kelas.id_kelas where tb_siswa.lat IS NOT NULL AND tb_siswa.status != 1";
}
$res_siswa = mysqli_query( $link, $sql_siswa );
?>
<markers>
	<?php

	while ( $data_siswa = mysqli_fetch_array( $res_siswa ) ) {
		?>
	<marker nama="<?php echo $data_siswa['nama']; ?>" nis="<?php echo $data_siswa['nis']; ?>" lat="<?php echo $data_siswa['lat']; ?>" lng="<?php echo $data_siswa['longitude']; ?>" foto="<?php echo $data_siswa['foto']; ?>" jumlah="<?php echo $i; ?>" status="<?php echo $data_siswa['status']; ?>" kelas="<?php echo $data_siswa['kelas']; ?>" baterai="<?php echo $data_siswa['baterai']; ?>"/>
	<?php
	$i++;
	}
	mysqli_close($link);
	?>
</markers>