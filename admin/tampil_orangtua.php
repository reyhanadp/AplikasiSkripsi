<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query_orangtua = "select id_orangtua,nama,no_telp,foto from tb_orangtua";
$result_orangtua = mysqli_query( $link, $query_orangtua );

?>
<section id="main-content">
	<section class="wrapper">
		<h3><i class="fa fa-angle-right"></i> Data Orangtua</h3>


		<div class="row mb">

			<!-- page start-->
			<div class="content-panel">
				<!--				<div class="row mb">-->
				<div class="col-md-12">
					<p>
						<button type="button" class="btn btn-theme02" data-toggle="modal" data-target="#myModal">Tambah Data Orangtua</button>
					</p>
				</div>
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Tambah Data Orangtua</h4>
							</div>
							<form action="proses_tambah_data_orangtua.php" method="POST" onSubmit="return confirm('Apakah anda yakin ingin menyimpan data?');" enctype="multipart/form-data">
							<div class="modal-body">
								<div class="form-group">
									<label for="id_orangtua">Id Orangtua : </label>
									<input type="text" class="form-control" name="id_orangtua" required>
								</div>
								<div class="form-group">
									<label for="nama">Nama Orangtua : </label>
									<input type="text" class="form-control" name="nama" required>
								</div>
								<div class="form-group">
									<label for="no_telp">Nomor Telepon : </label>
									<input type="text" class="form-control" name="no_telp" required>
								</div>
								<div class="form-group">
									<label for="password">Password : </label>
									<input type="text" class="form-control" name="password" required>
								</div>
								<div class="form-group">
									<label for="alamat">Alamat :</label>
									<textarea class="form-control" rows="3" name="alamat"></textarea>
								</div>
								<div class="form-group">
									<label for="foto">Foto:</label>
									<input type="file" class="form-control" name="foto">
								</div>
							</div>
							<div class="modal-footer">
								<button type="reset" class="btn btn-default">Reset</button>
								<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
							</div>
							</form>
						</div>
					</div>
				</div>


				<!--				</div>-->
				<div class="adv-table">

					<table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
						<thead>
							<tr>
								<th>
									<center>Id Orangtua</center>
								</th>
								<th>
									<center>Nama Orangtua</center>
								</th>
								<th>
									<center>No Telepon</center>
								</th>
								<th>
									<center>Foto</center>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							while ( $data_orangtua = mysqli_fetch_array( $result_orangtua ) ) {
								?>
							<tr class="gradeA">
								<td>
									<?php echo $data_orangtua['id_orangtua']; ?>
								</td>
								<td>
									<?php echo $data_orangtua['nama']; ?>
								</td>
								<td>
									<?php echo $data_orangtua['no_telp']; ?>
								</td>
								<td class="center"><img class="img-rounded" src="../foto/orangtua/<?php echo $data_orangtua['foto']; ?>" width="75" height="75">
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
<script type="text/javascript">
	function fnFormatDetails( oTable, nTr ) {
		var sOut;
		var id_orangtua, nama_orangtua, alamat, no_telp, password, status;
		var aData = oTable.fnGetData( nTr );
		$.ajax( {
			type: 'post',
			async: false,
			url: 'ajax_detail.php',
			data: {
				id: aData[ 1 ],
				jenis: 'orangtua'
			},
			dataType: "json",
			success: function ( data ) {
				
				id_orangtua = data.id_orangtua;
				nama_orangtua = data.nama_orangtua;
				alamat = data.alamat;
				no_telp = data.no_telp;
				password = data.password;
				status = data.status;
				
				if ( status == 1 ) {
					status = 'Tidak Aktif';
				} else {
					status = 'Aktif';
				}
			}
		} );
		sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
		sOut += '<tr><td>Id Orangtua </td><td>: ' + id_orangtua + '</td></tr>';
		sOut += '<tr><td>Nama Orangtua </td><td>: ' + nama_orangtua + '</td></tr>';
		sOut += '<tr><td>Alamat </td><td> : ' + alamat + '</td></tr>';
		sOut += '<tr><td>No Telepon </td><td> : ' + no_telp + '</td></tr>';
		sOut += '<tr><td>Password </td><td> : ' + password + '</td></tr>';
		sOut += '<tr><td>Status </td><td> : ' + status + '</td></tr>';
		sOut += '</table>';

		return sOut;


	}

	function fnFormatEdit( oTable, nTr ) {
		var sOut;
		var id_orangtua, nama_orangtua, alamat, no_telp, password, status;
		var aData = oTable.fnGetData( nTr );
		$.ajax( {
			type: 'post',
			async: false,
			url: 'ajax_detail.php',
			data: {
				id: aData[ 1 ],
				jenis: 'orangtua'
			},
			dataType: "json",
			success: function ( data ) {
				
				id_orangtua = data.id_orangtua;
				nama_orangtua = data.nama_orangtua;
				alamat = data.alamat;
				no_telp = data.no_telp;
				password = data.password;
				status = data.status;
				
				if ( status == 1 ) {
					status = 'Tidak Aktif';
				} else {
					status = 'Aktif';
				}
			}
		} );

		var onsubmit = "return confirm('Apakah anda yakin ingin menyimpan data?');";

		sOut = '<form action="proses_ubah.php?idOrangtua=' + id_orangtua + '" method="post" onsubmit="' + onsubmit + '" enctype="multipart/form-data">'
		sOut += '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
		sOut += '<tr><td><b>Id Orangtua </td><td> : ' + id_orangtua + '</b></td></tr>';
		sOut += '<tr><td><b>Nama Orangtua </td><td> : </b><input type="text" class="form-control round-form" name="nama" value="' + nama_orangtua + '"></td></tr>';
		sOut += '<tr><td><b>Alamat </td><td> : </b><textarea rows="3" name="alamat" class="form-control">' + alamat + '</textarea></td></tr>';
		sOut += '<tr><td><b>No Telepon </td><td> : </b><input type="text" name="no_telp" class="form-control round-form" value="' + no_telp + '"></td></tr>';
		sOut += '<tr><td><b>Password </td><td> : </b><input type="text" name="password" class="form-control round-form" value="' + password + '"></td></tr>';
		sOut += '<tr><td><b>Foto </td><td> : </b><input type="file" name="foto" class="form-control round-form"></td></tr>'
		sOut += '<tr><td><b>Status </td><td> : </b><select name="status" class="form-control round-form">';
		if ( status == 1 ) {
			sOut += '<option value="0"> Aktif </option>';
			sOut += '<option value="1" selected> Tidak Aktif </option>';
		} else {
			sOut += '<option value="0" selected> Aktif </option>';
			sOut += '<option value="1"> Tidak Aktif </option>';
		}
		sOut += '</select></td></tr>';
		sOut += '<tr><td><button type="submit" class="btn btn-round btn-primary" name="submit">Simpan</button><td></tr>'
		sOut += '</table></form>';

		return sOut;
	}
</script>