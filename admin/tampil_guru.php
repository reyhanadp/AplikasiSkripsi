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
						<button type="button" class="btn btn-theme02" data-toggle="modal" data-target="#myModal">Tambah Data Guru</button>
					</p>
				</div>
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Tambah Data Guru</h4>
							</div>
							<form action="proses_tambah_data_guru.php" method="POST" onSubmit="return confirm('Apakah anda yakin ingin menyimpan data?');" enctype="multipart/form-data">
								<div class="modal-body">
									<div class="form-group">
										<label for="nuptk">NUPTK : </label>
										<input type="text" class="form-control" name="nuptk" required>
									</div>
									<div class="form-group">
										<label for="nip">NIP : </label>
										<input type="text" class="form-control" name="nip" required>
									</div>
									<div class="form-group">
										<label for="nama">Nama Guru : </label>
										<input type="text" class="form-control" name="nama" required>
									</div>
									<div class="form-group">
										<label for="tempat_lahir">Tempat Lahir : </label>
										<input type="text" class="form-control" name="tempat_lahir" required>
									</div>
									<div class="form-group">
										<label for="tanggal_lahir">Tanggal Lahir : </label>
										<input type="date" class="form-control" name="tanggal_lahir" required>
									</div>
									<div class="form-group">
										<label for="notif_sms">Notif SMS : </label>
										<select name="notif_sms" class="form-control">
											<option value="ya">Ya</option>
											<option value="tidak">Tidak</option>
										</select>
									</div>
									<div class="form-group">
										<label for="no_hp">Nomor Hp : </label>
										<input type="text" class="form-control" name="no_hp">
									</div>
									<div class="form-group">
										<label for="kelas">Kelas : </label>
										<select name="id_kelas" class="form-control">
											<?php
											//								$link = koneksi_db();
											$sql = "SELECT * FROM tb_kelas";
											$res = mysqli_query( $link, $sql );
											while ( $data_kelas = mysqli_fetch_array( $res ) ) {
												?>
											<option value="<?php echo $data_kelas['id_kelas']; ?>">
												<?php echo $data_kelas['kelas']." ".$data_kelas['tingkatan']; ?>
											</option>
											<?php
											}
											//								$link -> close();
											?>

										</select>
									</div>
									<div class="form-group">
										<label for="id_jabatan">Jabatan : </label>
										<select name="id_jabatan" class="form-control">
											<?php
											//								$link = koneksi_db();
											$sql = "SELECT * FROM tb_jabatan";
											$res = mysqli_query( $link, $sql );
											while ( $data_jabatan = mysqli_fetch_array( $res ) ) {
												?>
											<option value="<?php echo $data_jabatan['kode_jabatan']; ?>">
												<?php echo $data_jabatan['nama_jabatan']; ?>
											</option>
											<?php
											}
											//								$link -> close();
											?>

										</select>
									</div>
									<div class="form-group">
										<label for="password">Password : </label>
										<input type="text" class="form-control" name="password" required>
									</div>
									<div class="form-group">
										<label for="foto">Foto:</label>
										<input type="file" class="form-control" name="foto">
									</div>
									<div class="form-group">
										<label for="status">Status:</label>
										<select name="status" class="form-control">
											<option value="0">Aktif</option>
											<option value="1">Tidak Aktif</option>
										</select>

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
<script type="text/javascript">
	function fnFormatDetails( oTable, nTr ) {
		var sOut;
		var nuptk, nip, nama_guru, tempat_lahir, tgl_lahir, status_guru, kelas, tingkatan, id_jabatan, nama_jabatan, password, id_kelas, notif_sms, no_hp;
		var aData = oTable.fnGetData( nTr );
		$.ajax( {
			type: 'post',
			async: false,
			url: 'ajax_detail.php',
			data: {
				id: aData[ 1 ],
				jenis: 'guru'
			},
			dataType: "json",
			success: function ( data ) {

				nuptk = data.nuptk;
				nip = data.nip;
				nama_guru = data.nama_guru;
				tempat_lahir = data.tempat_lahir;
				tgl_lahir = data.tgl_lahir;
				status_guru = data.status_guru;
				kelas = data.kelas;
				tingkatan = data.tingkatan;
				nama_jabatan = data.nama_jabatan;
				password = data.password;
				id_kelas = data.id_kelas;
				notif_sms = data.notif_sms;
				no_hp = data.no_hp;

				if ( status_guru == 1 ) {
					status_guru = 'Tidak Aktif';
				} else {
					status_guru = 'Aktif';
				}
			}
		} );
		sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
		sOut += '<tr><td>NUPTK </td><td>: ' + nuptk + '</td></tr>';
		sOut += '<tr><td>NIP </td><td>: ' + nip + '</td></tr>';
		sOut += '<tr><td>Nama Guru </td><td> : ' + nama_guru + '</td></tr>';
		sOut += '<tr><td>Tempat Lahir </td><td> : ' + tempat_lahir + '</td></tr>';
		sOut += '<tr><td>Tanggal Lahir </td><td> : ' + tgl_lahir + '</td></tr>';
		sOut += '<tr><td>Kelas </td><td> : ' + kelas + ' ' + tingkatan + '</td></tr>';
		sOut += '<tr><td>Jabatan </td><td> : ' + nama_jabatan + '</td></tr>';
		sOut += '<tr><td>Status </td><td> : ' + status_guru + '</td></tr>';
		sOut += '<tr><td>Notifikasi SMS </td><td> : ' + notif_sms + '</td></tr>';
		sOut += '<tr><td>Nomor Hp </td><td> : ' + no_hp + '</td></tr>';
		sOut += '</table>';

		return sOut;


	}

	function fnFormatEdit( oTable, nTr ) {
		var sOut;
		var jmlDataKelas, isiKelas;
		var nuptk, nip, nama_guru, tempat_lahir, tgl_lahir, status_guru, kelas, tingkatan, kode_jabatan, nama_jabatan, password, id_kelas, notif_sms, no_hp;
		var aData = oTable.fnGetData( nTr );
		$.ajax( {
			type: 'post',
			async: false,
			url: 'ajax_detail.php',
			data: {
				id: aData[ 1 ],
				jenis: 'guru'
			},
			dataType: "json",
			success: function ( data_detail ) {

				nuptk = data_detail.nuptk;
				nip = data_detail.nip;
				nama_guru = data_detail.nama_guru;
				tempat_lahir = data_detail.tempat_lahir;
				tgl_lahir = data_detail.tgl_lahir;
				status_guru = data_detail.status_guru;
				kelas = data_detail.kelas;
				tingkatan = data_detail.tingkatan;
				kode_jabatan = data_detail.kode_jabatan;
				nama_jabatan = data_detail.nama_jabatan;
				password = data_detail.password;
				id_kelas = data_detail.id_kelas;
				notif_sms = data_detail.notif_sms;
				no_hp = data_detail.no_hp;
			}
		} );


		$.ajax( {
			type: 'post',
			async: false,
			url: 'ajax_kelas.php',
			data: {
				jenis: 'kelas'
			},
			dataType: "json",
			success: function ( data_kelas ) {
				jmlDataKelas = data_kelas.length;

				//variabel untuk menampung tabel yang akan digenerasikan
				isiKelas = '<select name="id_kelas" class="form-control round-form">';

				//perulangan untuk menayangkan data dalam tabel
				for ( var a = 0; a < jmlDataKelas; a++ ) {
					if ( id_kelas == data_kelas[ a ][ "id_kelas" ] ) {
						isiKelas += '<option value="' + data_kelas[ a ][ "id_kelas" ] + '" selected>';
					} else {
						isiKelas += '<option value="' + data_kelas[ a ][ "id_kelas" ] + '">';
					}
					//mencetak baris baru

					isiKelas += data_kelas[ a ][ "kelas" ] + ' ' + data_kelas[ a ][ "tingkatan" ] + '</option>';
				}
				//menayangkan jumlah data
				isiKelas += '</select>';
			}
		} );
		var jmlDataJabatan, isiJabatan;

		$.ajax( {
			type: 'post',
			async: false,
			url: 'ajax_jabatan.php',
			data: {
				jenis: 'jabatan'
			},
			dataType: "json",
			success: function ( data_jabatan ) {
				jmlDataJabatan = data_jabatan.length;

				//variabel untuk menampung tabel yang akan digenerasikan
				isiJabatan = '<select name="id_jabatan" class="form-control round-form">';

				//perulangan untuk menayangkan data dalam tabel
				for ( var a = 0; a < jmlDataJabatan; a++ ) {
					if ( kode_jabatan == data_jabatan[ a ][ "kode_jabatan" ] ) {
						isiJabatan += '<option value="' + data_jabatan[ a ][ "kode_jabatan" ] + '" selected>';
					} else {
						isiJabatan += '<option value="' + data_jabatan[ a ][ "kode_jabatan" ] + '">';
					}
					//mencetak baris baru

					isiJabatan += data_jabatan[ a ][ "nama_jabatan" ] + '</option>';
				}
				//menayangkan jumlah data
				isiJabatan += '</select>';
			}
		} );





		var onsubmit = "return confirm('Apakah anda yakin ingin menyimpan data?');";

		sOut = '<form action="proses_ubah.php?nuptk=' + nuptk + '" method="post" onsubmit="' + onsubmit + '" enctype="multipart/form-data">'
		sOut += '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
		sOut += '<tr><td><b>NUPTK </td><td> : ' + nuptk + '</b></td></tr>';
		sOut += '<tr><td><b>NIP </td><td> : </b><input type="text" class="form-control round-form" name="nip" value="' + nip + '"></td></tr>';
		sOut += '<tr><td><b>Nama Guru </td><td> : </b><input type="text" class="form-control round-form" name="nama" value="' + nama_guru + '"></td></tr>';
		sOut += '<tr><td><b>Tempat Lahir </td><td> : </b><input type="text" name="tempat_lahir" class="form-control round-form" value="' + tempat_lahir + '"></td></tr>';
		sOut += '<tr><td><b>Tanggal Lahir </td><td> : </b><input type="date" name="tgl_lahir" class="form-control round-form" value="' + tgl_lahir + '"></td></tr>';
		sOut += '<tr><td><b>Notifikasi SMS </td><td> : </b><select name="notif_sms" class="form-control round-form">';
		if ( notif_sms == 'ya' ) {
			sOut += '<option value="ya" selected>Ya</option>';
			sOut += '<option value="tidak">Tidak</option>';
		} else {
			sOut += '<option value="ya">Ya</option>';
			sOut += '<option value="tidak" selected>Tidak</option>';
		}

		sOut += '</select></td></tr>';
		sOut += '<tr><td><b>Nomor Hp </td><td> : </b><input type="text" name="no_hp" class="form-control round-form" value="' + no_hp + '"></td></tr>';
		sOut += '<tr><td><b>Password </td><td> : </b><input type="text" name="password" class="form-control round-form" value="' + password + '"></td></tr>';
		sOut += '<tr><td><b>Kelas </td><td> : </b>' + isiKelas + '</td></tr>';
		sOut += '<tr><td><b>Jabatan </td><td> : </b>' + isiJabatan + '</td></tr>';
		sOut += '<tr><td><b>Foto </td><td> : </b><input type="file" name="foto" class="form-control round-form"></td></tr>'
		sOut += '<tr><td><b>Status </td><td> : </b><select name="status" class="form-control round-form">';
		if ( status_guru == 1 ) {
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