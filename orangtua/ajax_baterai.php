<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$sql_siswa = "SELECT `nis`, `nama`, `foto`, `baterai`, `status`, jam_masuk, jam_keluar, lat, longitude FROM `tb_siswa`join tb_kelas on tb_siswa . id_kelas = tb_kelas . id_kelas WHERE `status` != 1 AND id_orangtua = '".$_SESSION['s_id_orangtua']."'";
$res_siswa = mysqli_query( $link, $sql_siswa );

?>

<p class="centered"><a href="#"><img src="../foto/orangtua/<?php echo $_SESSION['s_foto']; ?>" class="img-circle" width="80"></a>
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
						<div class="progress progress-striped active">
							<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $data_siswa['baterai'];?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $data_siswa['baterai'];?>%">
								<span class="sr-only">
									<?php echo $data_siswa['baterai'];?>% Complete</span>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</a>


</li>
<?php
}
mysqli_close($link);

?>