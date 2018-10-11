<?php
require( '../koneksi.php' );
$link = koneksi_db();

$query_guru = "select nuptk,nama,tb_jabatan.nama_jabatan,foto from tb_guru join tb_jabatan on tb_guru.kode_jabatan = tb_jabatan.kode_jabatan";
$result_guru = mysqli_query( $link, $query_guru );

while ( $data = mysqli_fetch_array( $result_guru ) ) {
	?>

			<?php echo $data['nuptk']; ?>

			<?php echo $data['nama']; ?>

			<?php echo $data['nama_jabatan']; ?>

			<?php echo $data['foto']; ?>
	<?php
}
?>
<h1>tes</h1>