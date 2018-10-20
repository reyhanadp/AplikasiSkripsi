<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query_guru = "select nuptk,nama,tb_jabatan.nama_jabatan,foto from tb_guru join tb_jabatan on tb_guru.kode_jabatan = tb_jabatan.kode_jabatan";
$result_guru = mysqli_query( $link, $query_guru );

?>
<section id="main-content">
	<section class="wrapper">
		<h3><i class="fa fa-angle-right"></i> Data Guru</h3>


		<div class="row mb">

			<!-- page start-->
			<div class="content-panel">
				<!--				<div class="row mb">-->
				<div class="col-md-12">
					<p>
						<button type="button" class="btn btn-theme02">Tambah Data Guru</button>
					</p>
				</div>


				<!--				</div>-->
				<div class="adv-table">

					<table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
						<thead>
							<tr>
								<th>
									<center>NUPTK</center>
								</th>
								<th>
									<center>Nama Guru</center>
								</th>
								<th>
									<center>Jabatan</center>
								</th>
								<th>
									<center>Foto</center>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							while ( $data_guru = mysqli_fetch_array( $result_guru ) ) {
								?>
							<tr class="gradeA">
								<td>
									<?php echo $data_guru['nuptk']; ?>
								</td>
								<td>
									<?php echo $data_guru['nama']; ?>
								</td>
								<td>
									<?php echo $data_guru['nama_jabatan']; ?>
								</td>
								<td class="center"><img class="img-rounded" src="../foto/guru/<?php echo $data_guru['foto']; ?>" width="75" height="75">
								</td>
							</tr>
							<?php
							}
							?>

						</tbody>
					</table>
				</div>
			</div>
			<!-- page end-->
		</div>
		<!-- /row -->
	</section>
</section>
