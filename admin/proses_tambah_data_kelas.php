<?php
session_start();
include "../koneksi.php";
$link = koneksi_db();
if(!empty($_POST['kelas']))
{
	$kelas=$_POST['kelas'];
	$id_kelas = 'S'.$kelas;
	$tingkatan=$_POST['tingkatan'];
	$jam_masuk = $_POST['jam_masuk'];
	$jam_keluar = $_POST['jam_keluar'];

	$sql = "INSERT INTO `tb_kelas`(`id_kelas`, `kelas`, `tingkatan`, `jam_masuk`, `jam_keluar`) VALUES ('$id_kelas','$kelas','$tingkatan','$jam_masuk','$jam_keluar');";
	$res = mysqli_query( $link, $sql );

	if ( $res ) {
		$_SESSION[ 's_pesan' ] = "Data Berhasil Disimpan!"
	?>
	    <script language="javascript">
			document.location.href = "index.php?menu=kelas&action=tampil";
		</script>
	<?php
	} else {
		$_SESSION[ 's_pesan' ] = "Data Gagal Disimpan!"
	?>
		<script language="javascript">
			document.location.href = "index.php?menu=kelas&action=tampil";
		</script>
	<?php
	}
	$link->close();
} else {
	?>
	<script language="javascript">
		document.location.href = "index.php?menu=kelas&action=tampil";
	</script>
	<?php
}
?>