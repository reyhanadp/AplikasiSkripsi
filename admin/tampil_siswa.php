<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query = "select nis,nama,kelas,tingkatan,foto from tb_siswa join tb_kelas on tb_siswa.id_kelas=tb_kelas.id_kelas";
$result = mysqli_query( $link, $query );

?>
<section id="main-content">
	<section class="wrapper">
		<h3><i class="fa fa-angle-right"></i> Data Siswa</h3>


		<div class="row mb">

			<!-- page start-->
			<div class="content-panel">
				<!--				<div class="row mb">-->

				<div class="col-md-12">
					<p>
						<button type="button" class="btn btn-theme02" data-toggle="modal" href="#myModal">Tambah Data Siswa</button>
					</p>
				</div>




				<!--				</div>-->
				<div class="adv-table">

					<table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
						<thead>
							<tr>
								<th>
									<center>NIS</center>
								</th>
								<th>
									<center>Nama Siswa</center>
								</th>
								<th>
									<center>Kelas</center>
								</th>
								<th>
									<center>Foto</center>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							while ( $data = mysqli_fetch_array( $result ) ) {
								?>
							<tr class="gradeA">
								<td>
									<?php echo $data['nis']; ?>
								</td>
								<td>
									<?php echo $data['nama']; ?>
								</td>
								<td>
									<?php echo $data['kelas'].' '.$data['tingkatan']; ?>
								</td>
								<td class="center"><img class="img-rounded" src="../foto/siswa/<?php echo $data['foto']; ?>" width="75" height="75">
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
		var nis, nama_siswa, alamat, tempat_lahir, tgl_lahir, status, nama_orangtua, kelas, tingkatan,nuptk,nama_guru;
		var aData = oTable.fnGetData( nTr );
		$.ajax( {
			type: 'post',
			async: false,
			url: 'ajax_detail.php',
			data: {
				id: aData[ 1 ],
				jenis: 'siswa'
			},
			dataType: "json",
			success: function ( data ) {
				nis = data.nis;
				nama_siswa = data.nama_siswa;
				alamat = data.alamat_siswa;
				tempat_lahir = data.tempat_lahir;
				tgl_lahir = data.tgl_lahir;
				status = data.status_siswa;
				nama_orangtua = data.nama_orangtua;
				kelas = data.kelas;
				tingkatan = data.tingkatan;
				nuptk = data.nuptk;
				nama_guru = data.nama_guru;
				
				if(status==4){
					status='Siswa Alumni';
				}else{
					status='Siswa Aktif';
				}
			}
		} );
		sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
		sOut += '<tr><td>NIS </td><td>: ' + nis + '</td></tr>';
		sOut += '<tr><td>Nama Siswa </td><td>: ' + nama_siswa + '</td></tr>';
		sOut += '<tr><td>Alamat </td><td> : ' + alamat + '</td></tr>';
		sOut += '<tr><td>Tempat Lahir </td><td> : ' + tempat_lahir + '</td></tr>';
		sOut += '<tr><td>Tanggal Lahir </td><td> : ' + tgl_lahir + '</td></tr>';
		sOut += '<tr><td>Nama Orangtua </td><td> : ' + nama_orangtua + '</td></tr>';
		sOut += '<tr><td>Kelas </td><td> : ' + kelas + ' ' + tingkatan + '</td></tr>';
		sOut += '<tr><td>Guru </td><td> : ' + nama_guru + '</td></tr>';
		sOut += '<tr><td>Status </td><td> : ' + status + '</td></tr>';
		sOut += '</table>';

		return sOut;


	}

	function fnFormatEdit( oTable, nTr ) {
		var sOut;
		var nis, nama_siswa, alamat, tempat_lahir, tgl_lahir, status, nama_orangtua, kelas, tingkatan,id_kelas,password,id_orangtua, nuptk;
		var jmlDataKelas, isiKelas;
		var aData = oTable.fnGetData( nTr );
		$.ajax( {
			type: 'post',
			async: false,
			url: 'ajax_detail.php',
			data: {
				id: aData[ 1 ],
				jenis: 'siswa'
			},
			dataType: "json",
			success: function ( data ) {
				nis = data.nis;
				nama_siswa = data.nama_siswa;
				alamat = data.alamat_siswa;
				tempat_lahir = data.tempat_lahir;
				tgl_lahir = data.tgl_lahir;
				status = data.status_siswa;
				nama_orangtua = data.nama_orangtua;
				kelas = data.kelas;
				tingkatan = data.tingkatan;
				password = data.password;
				id_kelas = data.id_kelas;
				id_orangtua = data.id_orangtua;
				nuptk = data.nuptk;
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
			success: function ( data ) {
				jmlDataKelas = data.length;

				//variabel untuk menampung tabel yang akan digenerasikan
				isiKelas = '<select name="id_kelas" class="form-control round-form">';

				//perulangan untuk menayangkan data dalam tabel
				for ( var a = 0; a < jmlDataKelas; a++ ) {
					if(id_kelas == data[a]["id_kelas"] ){
						isiKelas += '<option value="'+data[a]["id_kelas"]+'" selected>';
					}else{
						isiKelas += '<option value="'+data[a]["id_kelas"]+'">';
					}
					//mencetak baris baru
					
					isiKelas += data[a]["kelas"]+' '+data[a]["tingkatan"]+'</option>';
				}
				//menayangkan jumlah data
				isiKelas += '</select>';
			}
		} );
		
		var jmlDataOrangtua,isiOrangtua;
		
		$.ajax( {
			type: 'post',
			async: false,
			url: 'ajax_orangtua.php',
			data: {
				jenis: 'orangtua'
			},
			dataType: "json",
			success: function ( data ) {
				jmlDataOrangtua = data.length;

				//variabel untuk menampung tabel yang akan digenerasikan
				isiOrangtua = '<select name="id_orangtua" class="form-control round-form">';

				//perulangan untuk menayangkan data dalam tabel
				for ( var a = 0; a < jmlDataOrangtua; a++ ) {
					if(id_orangtua == data[a]["id_orangtua"] ){
						isiOrangtua += '<option value="'+data[a]["id_orangtua"]+'" selected>';
					}else{
						isiOrangtua += '<option value="'+data[a]["id_orangtua"]+'">';
					}
					//mencetak baris baru
					
					isiOrangtua += data[a]["nama"]+'</option>';
				}
				//menayangkan jumlah data
				isiOrangtua += '</select>';
			}
		} );
		
		var jmlDataGuru,isiGuru;
		
		$.ajax( {
			type: 'post',
			async: false,
			url: 'ajax_guru.php',
			data: {
				jenis: 'guru'
			},
			dataType: "json",
			success: function ( data ) {
				jmlDataGuru = data.length;

				//variabel untuk menampung tabel yang akan digenerasikan
				isiGuru = '<select name="nuptk" class="form-control round-form">';

				//perulangan untuk menayangkan data dalam tabel
				for ( var a = 0; a < jmlDataGuru; a++ ) {
					if(nuptk == data[a]["nuptk"] ){
						isiGuru += '<option value="'+data[a]["nuptk"]+'" selected>';
					}else{
						isiGuru += '<option value="'+data[a]["nuptk"]+'">';
					}
					//mencetak baris baru
					
					isiGuru += data[a]["nama"]+'</option>';
				}
				//menayangkan jumlah data
				isiGuru += '</select>';
			}
		} );
		var onsubmit = "return confirm('Apakah anda yakin ingin menyimpan data?');";
		
		sOut = '<form action="proses_ubah.php?nis='+nis+'" method="post" onsubmit="'+onsubmit+'" enctype="multipart/form-data">'
		sOut += '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
		sOut += '<tr><td><b>NIS </td><td> : ' + nis + '</b></td></tr>';
		sOut += '<tr><td><b>Nama Siswa </td><td> : </b><input type="text" class="form-control round-form" name="nama" value="' + nama_siswa + '"></td></tr>';
		sOut += '<tr><td><b>Alamat </td><td> : </b><textarea rows="3" name="alamat" class="form-control">' + alamat + '</textarea></td></tr>';
		sOut += '<tr><td><b>Tempat Lahir </td><td> : </b><input type="text" name="tempat_lahir" class="form-control round-form" value="' + tempat_lahir + '"></td></tr>';
		sOut += '<tr><td><b>Tanggal Lahir </td><td> : </b><input type="date" name="tgl_lahir" class="form-control round-form" value="' + tgl_lahir + '"></td></tr>';
		sOut += '<tr><td><b>Password </td><td> : </b><input type="text" name="password" class="form-control round-form" value="' + password + '"></td></tr>';
		sOut += '<tr><td><b>Nama Orangtua </td><td> : </b>' + isiOrangtua + '</td></tr>';
		sOut += '<tr><td><b>Kelas </td><td> : </b>' + isiKelas + '</td></tr>';
		sOut += '<tr><td><b>Guru </td><td> : </b>' + isiGuru + '</td></tr>';
		sOut += '<tr><td><b>Foto </td><td> : </b><input type="file" name="foto" class="form-control round-form"></td></tr>'
		sOut += '<tr><td><b>Status </td><td> : </b><select name="status" class="form-control round-form">';
		if(status == 1){
			sOut += '<option value="0"> Siswa Aktif </option>';
			sOut += '<option value="1" selected> Siswa Alumni </option>';
		}else{
			sOut += '<option value="0" selected> Siswa Aktif </option>';
			sOut += '<option value="1"> Siswa Alumni </option>';
		}
		sOut += '</select></td></tr>';
		sOut += '<tr><td><button type="submit" class="btn btn-round btn-primary" name="submit">Simpan</button><td></tr>'
		sOut += '</table></form>';

		return sOut;
	}
</script>

