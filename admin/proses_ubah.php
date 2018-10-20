<?php
session_start();
include "../koneksi.php";
$link = koneksi_db();
if ( isset( $_POST[ 'submit' ] ) ) {
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
	$id_orangtua = $_POST['id_orangtua'];
	$status=$_POST['status'];
	$nuptk=$_POST['nuptk'];

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
}

$link->close();

?>