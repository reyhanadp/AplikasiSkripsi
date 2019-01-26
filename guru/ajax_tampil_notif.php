<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$sql_ambil_notif = "SELECT tb_status.id_status,tb_notifikasi.id_notifikasi,tb_notifikasi.nis,tb_notifikasi.pesan_notif,tb_notifikasi.waktu,tb_siswa.foto,tb_siswa.nama,TIMESTAMPDIFF(minute,tb_notifikasi.waktu,now()) as menit, DATEDIFF(now(), waktu) AS hari, TIMESTAMPDIFF(MONTH, waktu, now()) AS bulan  FROM `tb_notifikasi` join tb_status on tb_notifikasi.id_notifikasi=tb_status.id_notifikasi JOIN tb_siswa ON tb_notifikasi.nis=tb_siswa.nis WHERE tb_status.status=0 AND tb_status.id_user='" . $_SESSION[ 's_nuptk' ] . "'";
$res_ambil_notif = mysqli_query( $link, $sql_ambil_notif );

?>
<div class="notify-arrow notify-arrow-green"></div>

<li>
	<p class="green">Anda Mempunyai
		<?php  echo $_POST['jumlah_notif'];?> Notifkasi</p>
</li>
<li>
	<a href="#konfirmasi" data-toggle="modal"><strong>Lihat Semua Notifikasi</strong></a>
</li>

<?php

while ( $data_ambil_notif = mysqli_fetch_array( $res_ambil_notif ) ) {
	//menit
	if($data_ambil_notif['menit']==0){
		$waktu = "Baru saja";
	}else if($data_ambil_notif['menit']<=60){
		$waktu = $data_ambil_notif['menit']." menit";
	//jam
	}else if($data_ambil_notif['menit']>60 && $data_ambil_notif['menit']<=1440){
		$waktu = floor($data_ambil_notif['menit']/60)." jam";
	//hari
	}else if($data_ambil_notif['menit']>1440){
		$waktu = $data_ambil_notif['hari']." hari";
	//bulan
	}else if($data_ambil_notif['hari']>=30){
		$waktu = $data_ambil_notif['bulan']." bulan";
	}


	?>

	<li>
		<a href="#konfirmasi_pilih" data-toggle="modal" data-id="<?php echo $data_ambil_notif['id_notifikasi']; ?>" data-status="<?php echo $data_ambil_notif['id_status']; ?>">
                  <span class="photo"><img alt="avatar" src="../foto/siswa/<?php echo $data_ambil_notif['foto'] ?>"></span>
                  <span class="subject">
                  <span class="from">
					  <?php 
						$nama = "";
						if(str_word_count($data_ambil_notif['nama'])>2){
							$pisah_nama = explode(" ",$data_ambil_notif['nama']);
							
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
							$nama = $data_ambil_notif['nama'];
						}
						echo $nama; 
					  ?>
					</span>
                  <span class="time"><?php echo $waktu; ?></span>
                  </span>
                  <span class="message">
                  <?php echo $data_ambil_notif['pesan_notif']; ?>
                  </span>
                  </a>
	</li>


	<?php
}
mysqli_close($link);
?>