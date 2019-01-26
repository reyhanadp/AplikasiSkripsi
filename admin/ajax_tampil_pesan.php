<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$sql_ambil_pesan = "SELECT `id_pesan`, `id_pengirim`, `isi_pesan`, `waktu`,TIMESTAMPDIFF(minute,waktu,now()) as menit, DATEDIFF(now(), waktu) AS hari, TIMESTAMPDIFF(MONTH, waktu, now()) AS bulan FROM `tb_pesan` WHERE `id_penerima`='" . $_SESSION[ 's_nuptk' ] . "' AND `status`='0' ORDER BY `id_pesan` DESC";
$res_ambil_pesan = mysqli_query( $link, $sql_ambil_pesan );
$jumlah_ambil_pesan = mysqli_num_rows( $res_ambil_pesan );

?>
<div class="notify-arrow notify-arrow-green"></div>

<li>
	<p class="green">Anda Mempunyai
		<?php  echo $_POST['jumlah_pesan'];?> Pesan</p>
</li>
<?php
if ( $jumlah_ambil_pesan != 0 ) {
	?>
	<li>
		<a href="#" onClick="return telah_dibaca()" data-toggle="modal"><strong>Tandai Semua Telah Dibaca</strong></a>
	</li>

	<?php
}
$id_pengirim = array();

while ( $data_ambil_pesan = mysqli_fetch_array( $res_ambil_pesan ) ) {
	$sama = 0;
	
	for($i=0 ; $i< count($id_pengirim);$i++){
		if($data_ambil_pesan[ 'id_pengirim' ] == $id_pengirim[$i]){
			$sama = 1;
			break;
		}
	}
	
	if($sama==0){
		array_push($id_pengirim,$data_ambil_pesan[ 'id_pengirim' ]);
	
	
	$temp = substr( $data_ambil_pesan[ 'id_pengirim' ], 0, 1 );

	if ( $temp == "O" || $temp == "o" ) {
		$sql_ambil_data_user = "SELECT `nama`, `foto` FROM `tb_orangtua` WHERE `id_orangtua`='" . $data_ambil_pesan[ 'id_pengirim' ] . "'";
		$user = 'orangtua';
	} else {
		$sql_ambil_data_user = "SELECT `foto`, `nama` FROM `tb_guru` WHERE `nuptk`='" . $data_ambil_pesan[ 'id_pengirim' ] . "'";
		$user = 'guru';
	}

	$res_ambil_data_user = mysqli_query( $link, $sql_ambil_data_user );
	$data_ambil_data_user = mysqli_fetch_array( $res_ambil_data_user );


	//menit
	if ( $data_ambil_pesan[ 'menit' ] == 0 ) {
		$waktu = "Baru saja";
	} else if ( $data_ambil_pesan[ 'menit' ] <= 60 ) {
		$waktu = $data_ambil_pesan[ 'menit' ] . " menit";
		//jam
	} else if ( $data_ambil_pesan[ 'menit' ] > 60 && $data_ambil_pesan[ 'menit' ] <= 1440 ) {
		$waktu = floor( $data_ambil_pesan[ 'menit' ] / 60 ) . " jam";
		//hari
	} else if ( $data_ambil_pesan[ 'menit' ] > 1440 ) {
		$waktu = $data_ambil_pesan[ 'hari' ] . " hari";
		//bulan
	} else if ( $data_ambil_pesan[ 'hari' ] >= 30 ) {
		$waktu = $data_ambil_pesan[ 'bulan' ] . " bulan";
	}


	?>

	<li>
		<a href="#" onClick="register_popup( '<?php echo $data_ambil_pesan[ 'id_pengirim' ]; ?>', '<?php echo $data_ambil_data_user[ 'nama' ]; ?>', '<?php echo $data_ambil_data_user['foto']; ?>', '<?php echo $user; ?>' ); return false;" data-toggle="modal" data-id="<?php echo $data_ambil_pesan['id_pesan']; ?>">
                  <span class="photo"><img alt="avatar" src="../foto/<?php echo $user;?>/<?php echo $data_ambil_data_user['foto'] ?>"></span>
                  <span class="subject">
                  <span class="from">
					  <?php 
						$nama = "";
						if(str_word_count($data_ambil_data_user['nama'])>2){
							$pisah_nama = explode(" ",$data_ambil_data_user['nama']);
							
							for($i = 0; $i< count($pisah_nama); $i++){
								
								
								if($i == 0){
									$nama = $pisah_nama[$i];
								}elseif($i % 2 == 0){
									$nama = $nama."<br>".$pisah_nama[$i];
								}else{
									$nama = $nama." ".$pisah_nama[$i];
								}
							}
						}else{
							$nama = $data_ambil_data_user['nama'];
						}
						echo $nama; 
					  ?>
					</span>
                  <span class="time"><?php echo $waktu; ?></span>
                  </span>
                  <span class="message">
                  <?php echo $data_ambil_pesan['isi_pesan']; ?>
                  </span>
                  </a>
	
	</li>


	<?php
		}
}
mysqli_close($link);
?>