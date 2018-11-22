<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query_device = "SELECT tb_device.id_device, tb_guru.nama 'nama_guru', tb_device.tipe, tb_device.nama 'nama_device', tb_device.status FROM `tb_device` JOIN tb_guru ON tb_device.nuptk=tb_guru.nuptk";
$result_device = mysqli_query( $link, $query_device );

?>
<script>
	$.ajax( {
		type: 'post',
		url: 'ajax_ambil_data_device_dari_api.php',
		async: false,
		dataType: "json",
		success: function ( data_device_api ) {
			$.ajax( {
				type: 'post',
				url: 'ajax_ambil_data_device.php',
				async: false,
				dataType: "json",
				success: function ( data_device_db ) {
					for ( var i = 0; i < data_device_api.count; i++ ) {
						var sama = 0;
						for ( var j = 0; j < data_device_db.length; j++ ) {
							if ( data_device_api.results[ i ][ "id" ] == data_device_db[ j ][ "id_device" ] ) {
								sama = 1;
							}
						}

						if ( sama == 0 ) {
							$.ajax( {
								type: 'post',
								url: 'ajax_simpan_device.php',
								async: false,
								data: {
									id: data_device_api.results[ i ][ "id" ],
									tipe: 'Android',
									nama: data_device_api.results[ i ][ "name" ],
									status: 'tidak aktif'
								},
								dataType: "json",
								success: function ( data ) {

								}
							} );
						}
					}
				}
			} );
		}
	} );
</script>
<section id="main-content">
	<section class="wrapper">
		<h3><i class="fa fa-angle-right"></i> Data Device</h3>


		<div class="row mb">

			<!-- page start-->
			<div class="content-panel">
				<div class="adv-table">

					<table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
						<thead>
							<tr>
								<th>
									<center>Id Device</center>
								</th>
								<th>
									<center>Nama Pemilik</center>
								</th>
								<th>
									<center>Tipe</center>
								</th>
								<th>
									<center>Nama Device</center>
								</th>
								<th>
									<center>Status</center>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							while ( $data_device = mysqli_fetch_array( $result_device ) ) {
								?>
							<tr class="gradeA">
								<td>
									<?php echo $data_device['id_device']; ?>
								</td>
								<td>
									<?php echo $data_device['nama_guru']; ?>
								</td>
								<td>
									<?php echo $data_device['tipe']; ?>
								</td>
								<td>
									<?php echo $data_device['nama_device']; ?>
								</td>
								<td>
									<?php echo $data_device['status']; ?>
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
		var id_device, nuptk, tipe, nama, status;
		var aData = oTable.fnGetData( nTr );
		$.ajax( {
			type: 'post',
			async: false,
			url: 'ajax_detail.php',
			data: {
				id: aData[ 1 ],
				jenis: 'device'
			},
			dataType: "json",
			success: function ( data ) {

				id_device = data.id_device;
				nuptk = data.nuptk;
				tipe = data.tipe;
				nama = data.nama;
				status = data.status;
			}
		} );
		
		var jmlDataGuru, isiGuru;
		
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
					if ( nuptk == data[ a ][ "nuptk" ] ) {
						isiGuru += '<option value="' + data[ a ][ "nuptk" ] + '" selected>';
					} else {
						isiGuru += '<option value="' + data[ a ][ "nuptk" ] + '">';
					}
					//mencetak baris baru

					isiGuru += data[ a ][ "nama" ] + '</option>';
				}
				//menayangkan jumlah data
				isiGuru += '</select>';
			}
		} );

		var onsubmit = "return confirm('Apakah anda yakin ingin menyimpan data?');";

		sOut = '<form action="proses_ubah.php?idDevice=' + id_device + '" method="post" onsubmit="' + onsubmit + '" enctype="multipart/form-data">'
		sOut += '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
		sOut += '<tr><td><b>Id Device </td><td> : ' + id_device + '</b></td></tr>';
		sOut += '<tr><td><b>Nama Pemilik </td><td> : </b> '+isiGuru+'</td></tr>';
		sOut += '<tr><td><b>Tipe </td><td> : </b><input type="text" name="tipe" class="form-control round-form" value="' + tipe + '"></td></tr>';
		sOut += '<tr><td><b>Nama Device </td><td> : </b><input type="text" name="nama_device" class="form-control round-form" value="' + nama + '"></td></tr>';
		sOut += '<tr><td><b>Status </td><td> : </b><select name="status" class="form-control round-form">';
		if ( status == "aktif" ) {
			sOut += '<option value="aktif" selected> Aktif </option>';
			sOut += '<option value="tidak aktif"> Tidak Aktif </option>';
		} else {
			sOut += '<option value="aktif"> Aktif </option>';
			sOut += '<option value="tidak aktif" selected> Tidak Aktif </option>';
		}
		sOut += '</select></td></tr>';
		sOut += '<tr><td><button type="submit" class="btn btn-round btn-primary" name="submit">Simpan</button><td></tr>'
		sOut += '</table></form>';

		return sOut;
	}
</script>