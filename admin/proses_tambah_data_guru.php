<?php
session_start();
include "../koneksi.php";
$link = koneksi_db();
if (!empty( $_POST[ 'nuptk' ]) ) {
	$nuptk = $_POST[ 'nuptk' ];
	$nip = $_POST[ 'nip' ];
	$nama_guru = $_POST[ 'nama' ];
	$password = $_POST[ 'password' ];
	$tempat_lahir = $_POST[ 'tempat_lahir' ];
	$tgl_lahir = $_POST[ 'tgl_lahir' ];
	$id_kelas = $_POST[ 'id_kelas' ];
	$id_jabatan = $_POST[ 'id_jabatan' ];
	$status = $_POST['status'];

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
					$namafile = "../foto/guru/" . $nama;
					$namafile = str_replace( $format2, "", $namafile );
					$namafile = $namafile . "_" . $time . $format2;
					move_uploaded_file( $tmp_name, $namafile );
					$nama1 = str_replace( $format2, "", $nama );
					$nama1 = $nama1 . "_" . $time . $format2;
				}


				$sql = "INSERT INTO `tb_guru`(`nuptk`, `nip`, `foto`, `nama`, `tempat_lahir`, `tgl_lahir`, `kode_jabatan`, `password`, `status`, `id_kelas`, `longitude`, `latitude`) VALUES ('$nuptk','$nip','$nama1', '$nama_guru', '$tempat_lahir','$tgl_lahir', '$id_jabatan','$password','$status','$id_kelas',NULL,NULL);";
				$res = mysqli_query( $link, $sql );

				if ( $res ) {
					$_SESSION[ 's_pesan' ] = "Data Berhasil Disimpan!"
					?>
					<script language="javascript">
						document.location.href = "index.php?menu=guru&action=tampil";
					</script>
					<?php
				} else {
					$_SESSION[ 's_pesan' ] = "Data Gagal Disimpan!"
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
} else {
	?>
	<script language="javascript">
		document.location.href = "index.php?menu=guru&action=tampil";
	</script>
	<?php
}
?>