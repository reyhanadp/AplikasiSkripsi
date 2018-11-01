<?php
session_start();
include "../koneksi.php";
$link = koneksi_db();
if (!empty( $_POST[ 'nis' ]) ) {
	$nis = $_POST[ 'nis' ];
	$nama_siswa = $_POST[ 'nama' ];
	$alamat = $_POST[ 'alamat' ];
	$password = $_POST[ 'password' ];
	$tempat_lahir = $_POST[ 'tempat_lahir' ];
	$tgl_lahir = $_POST[ 'tanggal_lahir' ];
	$id_kelas = $_POST[ 'id_kelas' ];
	$id_orangtua = $_POST['id_orangtua'];
	$nuptk= $_POST['nuptk'];

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
					$nama1 = "foto-default.jpg";
				} else {
					$format2 = "." . $format;
					$namafile = "../foto/siswa/" . $nama;
					$namafile = str_replace( $format2, "", $namafile );
					$namafile = $namafile . "_" . $time . $format2;
					move_uploaded_file( $tmp_name, $namafile );
					$nama1 = str_replace( $format2, "", $nama );
					$nama1 = $nama1 . "_" . $time . $format2;
				}


				$sql = "insert into tb_siswa values ('$nis','$nama_siswa', '$alamat', '$tempat_lahir','$tgl_lahir', '$password','$id_kelas','$id_orangtua','$nama1',NULL,NULL,NULL,NULL,'0','$nuptk');";
				$res = mysqli_query( $link, $sql );

				if ( $res ) {
					$_SESSION[ 's_pesan' ] = "Data Berhasil Disimpan!"
					?>
					<script language="javascript">
						document.location.href = "index.php?menu=siswa&action=tampil";
					</script>
					<?php
				} else {
					$_SESSION[ 's_pesan' ] = "Data Gagal Disimpan!"
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
} else {
	?>
	<script language="javascript">
		document.location.href = "index.php?menu=siswa&action=tampil";
	</script>
	<?php
}
?>