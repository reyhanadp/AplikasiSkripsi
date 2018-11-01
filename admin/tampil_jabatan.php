<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query_jabatan = "select * from tb_jabatan";
$result_jabatan = mysqli_query( $link, $query_jabatan );

?>
<section id="main-content">
	<section class="wrapper">
		<h3><i class="fa fa-angle-right"></i> Data Jabatan</h3>


		<div class="row mb">

			<!-- page start-->
			<div class="content-panel">
				<!--				<div class="row mb">-->
				<div class="col-md-12">
					<p>
						<button type="button" class="btn btn-theme02" data-toggle="modal" data-target="#myModal">Tambah Data Jabatan</button>
					</p>
				</div>
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Tambah Data Jabatan</h4>
							</div>
							<form action="proses_tambah_data_jabatan.php" method="POST" onSubmit="return confirm('Apakah anda yakin ingin menyimpan data?');" enctype="multipart/form-data">
							<div class="modal-body">
								<div class="form-group">
									<label for="kode_jabatan">Kode Jabatan : </label>
									<input type="text" class="form-control" name="kode_jabatan" required>
								</div>
								<div class="form-group">
									<label for="nama">Nama Jabatan : </label>
									<input type="text" class="form-control" name="nama" required>
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
									<center>Kode Jabatan</center>
								</th>
								<th>
									<center>Nama Jabatan</center>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							while ( $data_jabatan = mysqli_fetch_array( $result_jabatan ) ) {
								?>
							<tr class="gradeA">
								<td>
									<?php echo $data_jabatan['kode_jabatan']; ?>
								</td>
								<td>
									<?php echo $data_jabatan['nama_jabatan']; ?>
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
		var kode_jabatan,nama_jabatan;
		var aData = oTable.fnGetData( nTr );
		$.ajax( {
			type: 'post',
			async: false,
			url: 'ajax_detail.php',
			data: {
				id: aData[ 1 ],
				jenis: 'jabatan'
			},
			dataType: "json",
			success: function ( data ) {
				
				kode_jabatan = data.kode_jabatan;
				nama_jabatan = data.nama_jabatan;
			}
		} );

		var onsubmit = "return confirm('Apakah anda yakin ingin menyimpan data?');";

		sOut = '<form action="proses_ubah.php?kodeJabatan=' + kode_jabatan + '" method="post" onsubmit="' + onsubmit + '" enctype="multipart/form-data">'
		sOut += '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
		sOut += '<tr><td><b>Kode Jabatan </td><td> : ' + kode_jabatan + '</b></td></tr>';
		sOut += '<tr><td><b>Nama Jabatan </td><td> : </b><input type="text" class="form-control round-form" name="nama" value="' + nama_jabatan + '"></td></tr>';
		sOut += '<tr><td><button type="submit" class="btn btn-round btn-primary" name="submit">Simpan</button><td></tr>'
		sOut += '</table></form>';

		return sOut;
	}
</script>