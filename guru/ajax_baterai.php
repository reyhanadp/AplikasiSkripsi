<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$sql_siswa = "SELECT `nis`, `nama`, `foto`, `baterai`, `status`, jam_masuk, jam_keluar, lat, longitude, TIMESTAMPDIFF(MINUTE,update_time,now()) waktu_beda FROM `tb_siswa` join tb_kelas on tb_siswa . id_kelas = tb_kelas . id_kelas WHERE `status` != 1";
$res_siswa = mysqli_query( $link, $sql_siswa );

?>

<p class="centered"><a href="#ubah_pw" data-toggle="modal" data-id="<?php echo $_SESSION['s_nuptk'];?>"><img src="../foto/guru/<?php echo $_SESSION['s_foto']; ?>" class="img-circle" width="80"></a>
</p>
<h5 class="centered">
	<?php echo $_SESSION['s_nama']; ?>
</h5>


<?php
while ( $data_siswa = mysqli_fetch_array( $res_siswa ) ) {


	?>
<li class="mt">
	<a href="#detail_siswa" id="custId" data-toggle="modal" data-id="<?php echo $data_siswa['nis'];?>" data-latitude="<?php echo $data_siswa['lat']; ?>" data-longitude="<?php echo $data_siswa['longitude']; ?>">
		<div class="row">
			<div class="col-md-4 col-sm-4">
				<img class="img-rounded" src="../foto/siswa/<?php echo $data_siswa['foto'];?>" width="65" height="75">
			</div>
			<div class="col-md-8 col-sm-8">
				<div class="row">
					<div class="col-md-12">
						<strong>
							<?php echo $data_siswa['nama'];?>
						</strong>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<?php
						if ( $data_siswa[ 'baterai' ] == NULL ) {
							$data_siswa[ 'baterai' ] = 0;
						}
						?> Baterai
						<?php echo $data_siswa['baterai'];?>%
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<?php
						if ( $data_siswa[ 'baterai' ] == NULL ) {
							$data_siswa[ 'baterai' ] = 0;
						}

						if ( $data_siswa[ 'baterai' ] >= 0 && $data_siswa[ 'baterai' ] <= 25 ) {
							?>
						<img src="../foto/icons/25.png" alt="indikator" width="65" height="20">
						<?php
						} else if ( $data_siswa[ 'baterai' ] >= 26 && $data_siswa[ 'baterai' ] <= 50 ) {
							?>
						<img src="../foto/icons/50.png" alt="indikator" width="65" height="20">
						<?php
						} else if ( $data_siswa[ 'baterai' ] >= 51 && $data_siswa[ 'baterai' ] <= 75 ) {
							?>
						<img src="../foto/icons/75.png" alt="indikator" width="65" height="20">
						<?php
						} else if ( $data_siswa[ 'baterai' ] >= 76 && $data_siswa[ 'baterai' ] <= 100 ) {
							?>
						<img src="../foto/icons/100.png" alt="indikator" width="65" height="20">
						<?php
						}
						?>

					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<?php
						if ( $data_siswa[ 'waktu_beda' ] <= 2 ) {
							echo "GPS Siswa Aktif";
						} else if ( $data_siswa[ 'waktu_beda' ] > 2 ) {
							echo "GPS Siswa Mati";
						}
						?>
					</div>
				</div>

			</div>
		</div>
	</a>


</li>
<?php
}
mysqli_close( $link );

?>