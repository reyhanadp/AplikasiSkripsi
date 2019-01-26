<?php
session_start();
include "../koneksi.php";
$link = koneksi_db();
if ( isset( $_POST[ 'submit' ] ) ) {

	if ( isset( $_GET[ 'nis' ] ) ) {


		$nis = $_GET[ 'nis' ];

		$sql_ambil_foto = "select foto from tb_siswa where nis='$nis';";
		$res_ambil_foto = mysqli_query( $link, $sql_ambil_foto );
		$data_ambil_foto = mysqli_fetch_array( $res_ambil_foto );

		$nama_siswa = $_POST[ 'nama' ];
		$alamat = $_POST[ 'alamat' ];
		$password = $_POST[ 'password' ];
		$tempat_lahir = $_POST[ 'tempat_lahir' ];
		$tgl_lahir = $_POST[ 'tgl_lahir' ];
		$id_kelas = $_POST[ 'id_kelas' ];
		$id_orangtua = $_POST[ 'id_orangtua' ];
		$status = $_POST[ 'status' ];
		$nuptk = $_POST[ 'nuptk' ];

		$time = time();
		$nama = $_FILES[ 'foto' ][ 'name' ];
		$error = $_FILES[ 'foto' ][ 'error' ];
		$size = $_FILES[ 'foto' ][ 'size' ];
		$tmp_name = $_FILES[ 'foto' ][ 'tmp_name' ];
		$type = $_FILES[ 'foto' ][ 'type' ];
		$format = pathinfo( $nama, PATHINFO_EXTENSION );

		if ( $error == 0 || $error == 4 ) {
			if ( $size < 5000000 ) {
				if ( $format == "jpg" || $format == "png" || $format == "jpeg" || $format == "JPG" || $format == "PNG" || $format == "JPEG" || $format == "" ) {

					if ( $error == 4 ) {
						$sql = "UPDATE `tb_siswa` SET `nama`='$nama_siswa',`alamat`='$alamat',`password`='$password',`tempat_lahir`='$tempat_lahir',`tgl_lahir`='$tgl_lahir',`id_kelas`='$id_kelas',`id_orangtua`='$id_orangtua',status = '$status',nuptk='$nuptk' WHERE nis='" . $nis . "'";
					} else {
						$format2 = "." . $format;
						$namafile = "../foto/siswa/" . $nama;
						$namafile = str_replace( $format2, "", $namafile );
						$namafile = $namafile . "_" . $time . $format2;
						move_uploaded_file( $tmp_name, $namafile );
						$nama1 = str_replace( $format2, "", $nama );
						$nama1 = $nama1 . "_" . $time . $format2;

						if ( $data_ambil_foto[ 'foto' ] != "foto-default.jpg" ) {
							if ( file_exists( "../foto/siswa/" . $data_ambil_foto[ 'foto' ] ) ) {
								unlink( "../foto/siswa/" . $data_ambil_foto[ 'foto' ] );
							}
						}

						$sql = "UPDATE `tb_siswa` SET `nama`='$nama_siswa',`alamat`='$alamat',`password`='$password',`tempat_lahir`='$tempat_lahir',`tgl_lahir`='$tgl_lahir',`id_kelas`='$id_kelas',`id_orangtua`='$id_orangtua',status = '$status', foto = '$nama1',nuptk='$nuptk' WHERE nis='" . $_GET[ 'nis' ] . "'";

					}

					$res = mysqli_query( $link, $sql );


					if ( $res ) {
						$_SESSION[ 's_pesan' ] = "Data Berhasil Diubah!"
						?>
						<script language="javascript">
							document.location.href = "index.php?menu=siswa&action=tampil";
						</script>
						<?php
					} else {
						$_SESSION[ 's_pesan' ] = "Data Gagal Diubah!"
						?>
						<script language="javascript">
							document.location.href = "index.php?menu=siswa&action=tampil";
						</script>
						<?php
					}
					$link->close();

				} else {
					$_SESSION[ 's_pesan' ] = "format harus berbentuk JPG/PNG/JPEG";
					?>
					<script language="javascript">
						document.location.href = "index.php?menu=siswa&action=tampil";
					</script>
					<?php
				}
			} else {
				$_SESSION[ 's_pesan' ] = "size file terlalu besar";
				?>
				<script language="javascript">
					document.location.href = "index.php?menu=siswa&action=tampil";
				</script>
				<?php
			}
		} else {
			$_SESSION[ 's_pesan' ] = "ada error";

			?>
			<script language="javascript">
				document.location.href = "index.php?menu=siswa&action=tampil";
			</script>
			<?php
		}
	} else if ( isset( $_GET[ 'nuptk' ] ) ) {
		$nuptk = $_GET[ 'nuptk' ];

		$sql_ambil_foto = "select foto from tb_guru where nuptk='$nuptk';";
		$res_ambil_foto = mysqli_query( $link, $sql_ambil_foto );
		$data_ambil_foto = mysqli_fetch_array( $res_ambil_foto );

		$nama_guru = $_POST[ 'nama' ];
		$nip = $_POST[ 'nip' ];
		$password = $_POST[ 'password' ];
		$tempat_lahir = $_POST[ 'tempat_lahir' ];
		$tgl_lahir = $_POST[ 'tgl_lahir' ];
		$id_kelas = $_POST[ 'id_kelas' ];
		$id_jabatan = $_POST[ 'id_jabatan' ];
		$status = $_POST[ 'status' ];
		$notif_sms = $_POST['notif_sms'];
		$no_hp = $_POST['no_hp'];

		$time = time();
		$nama = $_FILES[ 'foto' ][ 'name' ];
		$error = $_FILES[ 'foto' ][ 'error' ];
		$size = $_FILES[ 'foto' ][ 'size' ];
		$tmp_name = $_FILES[ 'foto' ][ 'tmp_name' ];
		$type = $_FILES[ 'foto' ][ 'type' ];
		$format = pathinfo( $nama, PATHINFO_EXTENSION );

		if ( $error == 0 || $error == 4 ) {
			if ( $size < 5000000 ) {
				if ( $format == "jpg" || $format == "png" || $format == "jpeg" || $format == "JPG" || $format == "PNG" || $format == "JPEG" || $format == "" ) {

					if ( $error == 4 ) {
						$sql = "UPDATE `tb_guru` SET nip='$nip',`nama`='$nama_guru',`password`='$password',`tempat_lahir`='$tempat_lahir',`tgl_lahir`='$tgl_lahir',`id_kelas`='$id_kelas',`kode_jabatan`='$id_jabatan',status = '$status', notif_sms = '$notif_sms', no_hp='$no_hp' WHERE nuptk='" . $nuptk . "'";
					} else {
						$format2 = "." . $format;
						$namafile = "../foto/guru/" . $nama;
						$namafile = str_replace( $format2, "", $namafile );
						$namafile = $namafile . "_" . $time . $format2;
						move_uploaded_file( $tmp_name, $namafile );
						$nama1 = str_replace( $format2, "", $nama );
						$nama1 = $nama1 . "_" . $time . $format2;

						if ( $data_ambil_foto[ 'foto' ] != "foto-default.jpg" ) {
							if ( file_exists( "../foto/guru/" . $data_ambil_foto[ 'foto' ] ) ) {
								unlink( "../foto/guru/" . $data_ambil_foto[ 'foto' ] );
							}
						}

						$sql = "UPDATE `tb_guru` SET nip='$nip',`nama`='$nama_guru',`password`='$password',`tempat_lahir`='$tempat_lahir',`tgl_lahir`='$tgl_lahir',`id_kelas`='$id_kelas',`kode_jabatan`='$id_jabatan',status = '$status', foto = '$nama1', notif_sms = '$notif_sms', no_hp='$no_hp' WHERE nuptk='" . $nuptk . "'";
					}

					$res = mysqli_query( $link, $sql );


					if ( $res ) {
						$_SESSION[ 's_pesan' ] = "Data Berhasil Diubah!"
						?>
						<script language="javascript">
							document.location.href = "index.php?menu=guru&action=tampil";
						</script>
						<?php
					} else {
						$_SESSION[ 's_pesan' ] = "Data Gagal Diubah!"
						?>
						<script language="javascript">
							document.location.href = "index.php?menu=guru&action=tampil";
						</script>
						<?php
					}
					$link->close();

				} else {
					$_SESSION[ 's_pesan' ] = "format harus berbentuk JPG/PNG/JPEG";
					?>
					<script language="javascript">
						document.location.href = "index.php?menu=guru&action=tampil";
					</script>
					<?php
				}
			} else {
				$_SESSION[ 's_pesan' ] = "size file terlalu besar";
				?>
				<script language="javascript">
					document.location.href = "index.php?menu=guru&action=tampil";
				</script>
				<?php
			}
		} else {
			$_SESSION[ 's_pesan' ] = "ada error";

			?>
			<script language="javascript">
				document.location.href = "index.php?menu=guru&action=tampil";
			</script>
			<?php
		}
	} else if ( isset( $_GET[ 'idOrangtua' ] ) ) {
		$id_orangtua = $_GET[ 'idOrangtua' ];

		$sql_ambil_foto = "select foto from tb_orangtua where id_orangtua='$id_orangtua';";
		$res_ambil_foto = mysqli_query( $link, $sql_ambil_foto );
		$data_ambil_foto = mysqli_fetch_array( $res_ambil_foto );

		$nama_orangtua = $_POST[ 'nama' ];
		$alamat = $_POST[ 'alamat' ];
		$password = $_POST[ 'password' ];
		$status = $_POST[ 'status' ];
		$smartphone = $_POST['smartphone'];
		$no_hp = $_POST['no_hp'];

		$time = time();
		$nama = $_FILES[ 'foto' ][ 'name' ];
		$error = $_FILES[ 'foto' ][ 'error' ];
		$size = $_FILES[ 'foto' ][ 'size' ];
		$tmp_name = $_FILES[ 'foto' ][ 'tmp_name' ];
		$type = $_FILES[ 'foto' ][ 'type' ];
		$format = pathinfo( $nama, PATHINFO_EXTENSION );

		if ( $error == 0 || $error == 4 ) {
			if ( $size < 5000000 ) {
				if ( $format == "jpg" || $format == "png" || $format == "jpeg" || $format == "JPG" || $format == "PNG" || $format == "JPEG" || $format == "" ) {

					if ( $error == 4 ) {
						$sql = "UPDATE `tb_orangtua` SET `nama`='$nama_orangtua',`alamat`='$alamat',`password`='$password',`status`='$status', smartphone = '$smartphone', no_hp='$no_hp' WHERE id_orangtua='$id_orangtua'";
					} else {
						$format2 = "." . $format;
						$namafile = "../foto/orangtua/" . $nama;
						$namafile = str_replace( $format2, "", $namafile );
						$namafile = $namafile . "_" . $time . $format2;
						move_uploaded_file( $tmp_name, $namafile );
						$nama1 = str_replace( $format2, "", $nama );
						$nama1 = $nama1 . "_" . $time . $format2;

						if ( $data_ambil_foto[ 'foto' ] != "foto-default.jpg" ) {
							if ( file_exists( "../foto/orangtua/" . $data_ambil_foto[ 'foto' ] ) ) {
								unlink( "../foto/orangtua/" . $data_ambil_foto[ 'foto' ] );
							}
						}

						$sql = "UPDATE `tb_orangtua` SET `nama`='$nama_orangtua',`alamat`='$alamat',`password`='$password',`status`='$status',foto = '$nama1', smartphone = '$smartphone', no_hp='$no_hp' WHERE id_orangtua='$id_orangtua'";

					}

					$res = mysqli_query( $link, $sql );


					if ( $res ) {
						$_SESSION[ 's_pesan' ] = "Data Berhasil Diubah!"
						?>
						<script language="javascript">
							document.location.href = "index.php?menu=ortu&action=tampil";
						</script>
						<?php
					} else {
						$_SESSION[ 's_pesan' ] = "Data Gagal Diubah!"
						?>
						<script language="javascript">
							document.location.href = "index.php?menu=ortu&action=tampil";
						</script>
						<?php
					}
					$link->close();

				} else {
					$_SESSION[ 's_pesan' ] = "format harus berbentuk JPG/PNG/JPEG";
					?>
					<script language="javascript">
						document.location.href = "index.php?menu=ortu&action=tampil";
					</script>
					<?php
				}
			} else {
				$_SESSION[ 's_pesan' ] = "size file terlalu besar";
				?>
				<script language="javascript">
					document.location.href = "index.php?menu=ortu&action=tampil";
				</script>
				<?php
			}
		} else {
			$_SESSION[ 's_pesan' ] = "ada error";

			?>
			<script language="javascript">
				document.location.href = "index.php?menu=ortu&action=tampil";
			</script>
			<?php
		}
	} else if ( isset( $_GET[ 'kodeJabatan' ] ) ) {
		$kode_jabatan = $_GET[ 'kodeJabatan' ];

		$nama_jabatan = $_POST[ 'nama' ];

		$sql = "UPDATE `tb_jabatan` SET `nama_jabatan`='$nama_jabatan' WHERE `kode_jabatan`='$kode_jabatan'";

		$res = mysqli_query( $link, $sql );


		if ( $res ) {
			$_SESSION[ 's_pesan' ] = "Data Berhasil Diubah!"
			?>
			<script language="javascript">
				document.location.href = "index.php?menu=jabatan&action=tampil";
			</script>
			<?php
		} else {
			$_SESSION[ 's_pesan' ] = "Data Gagal Diubah!"
			?>
			<script language="javascript">
				document.location.href = "index.php?menu=jabatan&action=tampil";
			</script>
			<?php
		}



	} else if ( isset( $_GET[ 'idKelas' ] ) ) {
		$id_kelas = $_GET[ 'idKelas' ];

		$kelas=$_POST['kelas'];
		$tingkatan=$_POST['tingkatan'];
		$jam_masuk = $_POST['jam_masuk'];
		$jam_keluar = $_POST['jam_keluar'];

		$sql = "Update tb_kelas set kelas='$kelas',tingkatan='$tingkatan',jam_masuk='$jam_masuk',jam_keluar='$jam_keluar' where id_kelas='$id_kelas';";

		$res = mysqli_query( $link, $sql );


		if ( $res ) {
			$_SESSION[ 's_pesan' ] = "Data Berhasil Diubah!"
			?>
			<script language="javascript">
				document.location.href = "index.php?menu=kelas&action=tampil";
			</script>
			<?php
		} else {
			$_SESSION[ 's_pesan' ] = "Data Gagal Diubah!"
			?>
			<script language="javascript">
				document.location.href = "index.php?menu=kelas&action=tampil";
			</script>
			<?php
		}



	} else if ( isset( $_GET[ 'idDevice' ] ) ) {
		$id_device = $_GET[ 'idDevice' ];

		$nuptk=$_POST['nuptk'];
		$tipe=$_POST['tipe'];
		$nama_device = $_POST['nama_device'];
		$status = $_POST['status'];
		
		if($status == "aktif"){
			$sql_update_status = "UPDATE `tb_device` SET `status`='tidak aktif'";
			$res_update_status = mysqli_query($link,$sql_update_status);
		}

		$sql = "UPDATE `tb_device` SET `nuptk`='$nuptk',`tipe`='$tipe',`nama`='$nama_device',`status`='$status' WHERE `id_device`='$id_device';";

		$res = mysqli_query( $link, $sql );


		if ( $res ) {
			$_SESSION[ 's_pesan' ] = "Data Berhasil Diubah!"
			?>
			<script language="javascript">
				document.location.href = "index.php?menu=device&action=tampil";
			</script>
			<?php
		} else {
			$_SESSION[ 's_pesan' ] = "Data Gagal Diubah!"
			?>
			<script language="javascript">
				document.location.href = "index.php?menu=device&action=tampil";
			</script>
			<?php
		}



	}
}

$link->close();

?>