<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();
$nis = $_POST[ 'nis' ];
$query = "SELECT * FROM tb_siswa WHERE nis = '$nis'";
$res = mysqli_query( $link, $query );
$data = mysqli_fetch_assoc( $res );


?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<center>
		<h4 class="modal-title">Detail Siswa</h4>
	</center>
</div>
<div class="modal-body">


	<table width="100%" class="table table-striped table-bordered table-hover">
		<tr>
			<td colspan="2">
				<center>
					<img src="../foto/siswa/<?php echo $data['foto']; ?>" class="img-rounded" width="200" height="220">
				</center>
			</td>
		</tr>
		<tr>
			<td class="col-md-4"><strong>NIS</strong></td>
			<td class="col-md-8" id="nis">
				<?php echo $data['nis']; ?>
			</td>
		</tr>
		<tr>
			<td><strong>Nama Siswa</strong></td>
			<td>
				<?php echo $data['nama']; ?>
			</td>
		</tr>
		<tr>
			<td><strong>Alamat</strong></td>
			<td>
				<?php echo $data['alamat']; ?>
			</td>
		</tr>
		<tr>
			<td><strong>Kelas</strong></td>
			<td>
				<?php 
					$sql_kelas = "select * from tb_kelas where id_kelas='".$data['id_kelas']."'";
					$res_kelas = mysqli_query($link,$sql_kelas);
					$data_kelas = mysqli_fetch_array($res_kelas);
					echo $data_kelas['kelas']." ".$data_kelas['tingkatan']; ?>
			</td>
		</tr>
		<tr>
			<td><strong>Orangtua</strong></td>
			<td>
				<?php 
					$sql_orangtua = "select nama from tb_orangtua where id_orangtua='".$data['id_orangtua']."'";
					$res_orangtua = mysqli_query($link,$sql_orangtua);
					$data_orangtua = mysqli_fetch_array($res_orangtua);
					echo $data_orangtua['nama']; ?>
			</td>
		</tr>
		<tr>
			<td><strong>Guru</strong></td>
			<td>
				<?php 
					$sql_guru = "select nama from tb_guru where nuptk='".$data['nuptk']."'";
					$res_guru = mysqli_query($link,$sql_guru);
					$data_guru = mysqli_fetch_array($res_guru);
					echo $data_guru['nama']; ?>
			</td>
		</tr>
		<tr>
			<td><strong>Lokasi Terakhir</strong></td>
			<td id="lokasi_terakhir">
			</td>
		</tr>
		<tr>
			<td><strong>Baterai</strong></td>
			<td>
				<?php
				echo $data[ 'baterai' ] . "%";
				?>
			</td>
		</tr>
		<tr>
			<td><strong>Update Terakhir</strong></td>
			<td>
				<?php
				echo $data[ 'update_time' ];
				?>
			</td>
		</tr>
	</table>
</div>
<div class="modal-footer">
	<form action="index.php" target="_blank" method="get" enctype="multipart/form-data">
			<input type="text" hidden name="nis" value="<?php echo $_POST['nis']; ?>">
			<button type="submit" class="form-control btn-default">Lihat History Anak</button>
		</form>
</div>