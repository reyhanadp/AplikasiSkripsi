<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$sql_update_status = "UPDATE `tb_status` SET `status`='1' WHERE `id_user`='".$_SESSION['s_id_orangtua']."'";
$res_update_status = mysqli_query($link,$sql_update_status);

$query_ambil_konfirmasi = "select tb_notifikasi.nis, nama, foto , kelas, tingkatan, tb_notifikasi.status, tb_notifikasi.pesan_notif, id_notifikasi, tb_notifikasi.nuptk, waktu, tb_siswa.lat, tb_siswa.longitude from tb_notifikasi join tb_siswa on tb_notifikasi.nis=tb_siswa.nis JOIN tb_kelas on tb_siswa.id_kelas=tb_kelas.id_kelas where tb_siswa.id_orangtua='".$_SESSION['s_id_orangtua']."' AND tb_notifikasi.status=1 ORDER BY tb_notifikasi.id_notifikasi DESC";
$result_ambil_konfirmasi = mysqli_query( $link, $query_ambil_konfirmasi );
while ( $data_ambil_konfirmasi = mysqli_fetch_array( $result_ambil_konfirmasi ) ) {

	$query_ambil_waktu_ketemu = "select * from tb_notifikasi join tb_laporan on tb_notifikasi.waktu=tb_laporan.waktu_kabur where tb_laporan.waktu_kabur='" . $data_ambil_konfirmasi[ 'waktu' ] . "' and tb_notifikasi.nis=(select nis from tb_siswa where id_orangtua='".$_SESSION['s_id_orangtua']."') ORDER BY id_laporan";
	$result_ambil_waktu_ketemu = mysqli_query( $link, $query_ambil_waktu_ketemu );
	$ketemu_waktu = mysqli_num_rows( $result_ambil_waktu_ketemu );
	$data_ambil_waktu_ketemu = mysqli_fetch_array( $result_ambil_waktu_ketemu );
	?>
	<table class="table table-bordered">
		<tr>
			<td class="col-md-10">
				<div class="row">
					<div class="col-md-2">
						<img class="img-rounded" src="../foto/siswa/<?php echo $data_ambil_konfirmasi['foto']; ?>" width="50" height="50">
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12">
								<b>
									<?php echo $data_ambil_konfirmasi['nama']; ?>
								</b>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<?php echo "Kelas : ".$data_ambil_konfirmasi['kelas']." ".$data_ambil_konfirmasi['tingkatan']; ?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<?php echo $data_ambil_konfirmasi['pesan_notif']; ?>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<?php
						if ( $data_ambil_konfirmasi[ 'status' ] == 1 && $data_ambil_waktu_ketemu[ 'waktu_ketemu' ] == NULL ) {
							$query_ambil_nama_guru = "select * from tb_guru where nuptk='" . $data_ambil_konfirmasi[ 'nuptk' ] . "'";
							$result_ambil_nama_guru = mysqli_query( $link, $query_ambil_nama_guru );
							$data_ambil_nama_guru = mysqli_fetch_array( $result_ambil_nama_guru );
							?>
						<div class="row">
							<div class="col-md-12">
								<center>Telah dikonfirmasi oleh
									<b>
										<?php echo $data_ambil_nama_guru['nama']; ?>
									</b>
								</center>
							</div>
							<?php
							if ( $data_ambil_konfirmasi[ 'pesan_notif' ] != "baterai lemah" ) {

							}
							?>
						</div>
						<?php

						} else if ( $data_ambil_konfirmasi[ 'status' ] == 1 && $data_ambil_waktu_ketemu[ 'waktu_ketemu' ] != NULL ) {
							$query_ambil_nama_guru = "select * from tb_guru where nuptk='" . $data_ambil_konfirmasi[ 'nuptk' ] . "'";
							$result_ambil_nama_guru = mysqli_query( $link, $query_ambil_nama_guru );
							$data_ambil_nama_guru = mysqli_fetch_array( $result_ambil_nama_guru );
							?>
						<div class="row">
							<div class="col-md-12">
								<center>Telah ditemukan oleh
									<b>
										<?php echo $data_ambil_nama_guru['nama']; ?>
									</b>
								</center>
							</div>
						</div>
						<?php
						}
						?>
					</div>
				</div>
			</td>
		</tr>
	</table>
	<?php

}
mysqli_close($link);


?>