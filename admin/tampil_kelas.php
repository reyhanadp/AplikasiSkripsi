<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query_kelas = "select id_kelas,kelas,tingkatan, DATE_FORMAT(jam_masuk, '%H:%i') 'jam_masuk',DATE_FORMAT(jam_keluar, '%H:%i') 'jam_keluar' from tb_kelas";
$result_kelas = mysqli_query( $link, $query_kelas );

?>
<section id="main-content">
	<section class="wrapper">
		<h3><i class="fa fa-angle-right"></i> Data Kelas</h3>


		<div class="row mb">

			<!-- page start-->
			<div class="content-panel">
				<!--				<div class="row mb">-->
				<div class="col-md-12">
					<p>
						<button type="button" class="btn btn-theme02" data-toggle="modal" data-target="#myModal">Tambah Data Kelas</button>
					</p>
				</div>
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Tambah Data Kelas</h4>
							</div>
							<form action="proses_tambah_data_kelas.php" method="POST" onSubmit="return confirm('Apakah anda yakin ingin menyimpan data?');" enctype="multipart/form-data">
							<div class="modal-body">
								<div class="form-group">
									<label for="kelas">Kelas : </label>
									<input type="text" class="form-control" name="kelas" required>
								</div>
								<div class="form-group">
									<label for="tingkatan">Tingkatan : </label>
									<select name="tingkatan" class="form-control">
									<option value="SDLB">SDLB</option>
										<option value="SMPLB">SMPLB</option>
										<option value="SMALB">SMALB</option>
									</select>
								</div>
								<div class="form-group">
									<label for="jam_masuk">Jam Masuk : </label>
									<input type="time" class="form-control" name="jam_masuk" required>
								</div>
								<div class="form-group">
									<label for="jam_keluar">Jam Keluar : </label>
									<input type="time" class="form-control" name="jam_keluar" required>
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
									<center>Id Kelas</center>
								</th>
								<th>
									<center>Kelas</center>
								</th>
								<th>
									<center>Tingkatan</center>
								</th>
								<th>
									<center>Jam Masuk</center>
								</th>
								<th>
									<center>Jam Keluar</center>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							while ( $data_kelas = mysqli_fetch_array( $result_kelas ) ) {
								?>
							<tr class="gradeA">
								<td>
									<?php echo $data_kelas['id_kelas']; ?>
								</td>
								<td>
									<?php echo $data_kelas['kelas']; ?>
								</td>
								<td>
									<?php echo $data_kelas['tingkatan']; ?>
								</td>
								<td>
									<?php echo $data_kelas['jam_masuk']; ?>
								</td>
								<td>
									<?php echo $data_kelas['jam_keluar']; ?>
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
	function fnFormatEdit( oTable, nTr ) {
		var sOut;
		var id_kelas,kelas,tingkatan,jam_masuk,jam_keluar;
		var aData = oTable.fnGetData( nTr );
		$.ajax( {
			type: 'post',
			async: false,
			url: 'ajax_detail.php',
			data: {
				id: aData[ 1 ],
				jenis: 'kelas'
			},
			dataType: "json",
			success: function ( data ) {
				
				id_kelas = data.id_kelas;
				kelas = data.kelas;
				tingkatan = data.tingkatan;
				jam_masuk = data.jam_masuk;
				jam_keluar = data.jam_keluar;
			}
		} );

		var onsubmit = "return confirm('Apakah anda yakin ingin menyimpan data?');";

		sOut = '<form action="proses_ubah.php?idKelas=' + id_kelas + '" method="post" onsubmit="' + onsubmit + '" enctype="multipart/form-data">'
		sOut += '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
		sOut += '<tr><td><b>Id Kelas </td><td> : ' + id_kelas + '</b></td></tr>';
		sOut += '<tr><td><b>Kelas </td><td> : </b><input type="text" class="form-control round-form" name="kelas" value="' + kelas + '"></td></tr>';
		sOut += '<tr><td><b>Tingkatan </td><td> : </b><select name="tingkatan" class="form-control round-form">';
		if ( tingkatan == 'SDLB' ) {
			sOut += '<option value="SDLB" selected> SDLB </option>';
			sOut += '<option value="SMPLB"> SMPLB </option>';
			sOut += '<option value="SMALB"> SMALB </option>';
		} else if ( tingkatan == 'SMPLB' ){
			sOut += '<option value="SDLB"> SDLB </option>';
			sOut += '<option value="SMPLB" selected> SMPLB </option>';
			sOut += '<option value="SMALB"> SMALB </option>';
		} else if ( tingkatan == 'SMALB' ){
			sOut += '<option value="SDLB"> SDLB </option>';
			sOut += '<option value="SMPLB"> SMPLB </option>';
			sOut += '<option value="SMALB" selected> SMALB </option>';
		}
		sOut += '</select></td></tr>';
		sOut += '<tr><td><b>Jam Masuk </td><td> : </b><input type="time" class="form-control round-form" name="jam_masuk" value="' + jam_masuk + '"></td></tr>';
		sOut += '<tr><td><b>Jam Keluar </td><td> : </b><input type="time" class="form-control round-form" name="jam_keluar" value="' + jam_keluar + '"></td></tr>';
		sOut += '<tr><td><button type="submit" class="btn btn-round btn-primary" name="submit">Simpan</button><td></tr>'
		sOut += '</table></form>';

		return sOut;
	}
</script>