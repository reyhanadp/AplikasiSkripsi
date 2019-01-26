<?php
	session_start();
	require('../koneksi.php');
	$link = koneksi_db();
	$i = 0;

	$query_update_lat_long_orangtua = "update tb_orangtua set latitude='".$_GET['lat']."', longitude='".$_GET['longitude']."' where id_orangtua='".$_SESSION['s_id_orangtua']."'";
	$result_update_lat_long_orangtua = mysqli_query($link,$query_update_lat_long_orangtua);

	$sql_guru = "select nama,latitude,longitude,foto from tb_orangtua where latitude is not null AND id_orangtua='".$_SESSION['s_id_orangtua']."'";
	$res_guru = mysqli_query($link,$sql_guru);
?>
<markers>
<?php
	
	while($data_guru = mysqli_fetch_array($res_guru)){
		?>
	<marker nama="<?php echo $data_guru['nama']; ?>" lat="<?php echo $data_guru['latitude']; ?>" lng="<?php echo $data_guru['longitude']; ?>" foto="<?php echo $data_guru['foto']; ?>" jumlah="<?php echo $i; ?>"/>
	<?php
		$i++;
	}
	mysqli_close($link);
	?>
</markers>
