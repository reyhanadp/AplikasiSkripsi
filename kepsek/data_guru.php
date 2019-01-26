<?php
	session_start();
	require('../koneksi.php');
	$link = koneksi_db();
	$i = 0;

	$query_update_lat_long_guru = "update tb_guru set latitude='".$_GET['lat']."', longitude='".$_GET['longitude']."', update_time = CURRENT_TIMESTAMP where nuptk='".$_SESSION['s_nuptk']."'";
	$result_update_lat_long_guru = mysqli_query($link,$query_update_lat_long_guru);

	$sql_guru = "select nama,latitude,longitude,foto from tb_guru where latitude is not null";
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
