<?php
session_start();
include "../koneksi.php";
$link = koneksi_db();
if ( !empty( $_POST[ 'nuptk' ] ) ) {
	$nuptk = $_POST[ 'nuptk' ];
	$pass_lama = $_POST[ 'pass_lama' ];
	$pass_baru = $_POST[ 'pass_baru' ];
	$konf_pass = $_POST[ 'konf_pass' ];

	$sql_guru = "select * from tb_guru where nuptk='$nuptk'";
	$res_guru = mysqli_query( $link, $sql_guru );
	$data_guru = mysqli_fetch_array( $res_guru );
	echo $data_guru[ 'password' ];

	//validasi
	if ( $pass_lama == $data_guru[ 'password' ] ) {
		if ( $pass_baru == $konf_pass ) {
			$sql = "update tb_guru set password='$pass_baru' where nuptk='$nuptk';";
			$res = mysqli_query( $link, $sql );

			if ( $res ) {
				$_SESSION[ 's_pesan' ] = "Password Berhasil Diubah!";
				?>
				<script language="javascript">
					document.location.href = "../guru/index.php";
				</script>
				<?php
			} else {
				$_SESSION[ 's_pesan' ] = "Password Gagal Diubah!";
				?>
				<script language="javascript">
					document.location.href = "../guru/index.php";
				</script>
				<?php
			}
			$link->close();
		} else {
			$_SESSION[ 's_pesan' ] = "Password Baru dan Konfirmasi Password Tidak Sesuai!";
			?>
			<script language="javascript">
				document.location.href = "../guru/index.php";
			</script>
			<?php
		}
	} else {
		$_SESSION[ 's_pesan' ] = "Password Salah!";
		?>
		<script language="javascript">
			document.location.href = "../guru/index.php";
		</script>
		<?php
	}


} else {
	?>
	<script language="javascript">
		document.location.href = "../guru/index.php";
	</script>
	<?php
}
?>