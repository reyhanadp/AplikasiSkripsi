<?php
require "koneksi.php";
$link = koneksi_db();

function jarak_titik( $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000 ) {
	// convert from degrees to radians
	$latFrom = deg2rad( $latitudeFrom );
	$lonFrom = deg2rad( $longitudeFrom );
	$latTo = deg2rad( $latitudeTo );
	$lonTo = deg2rad( $longitudeTo );

	$latDelta = $latTo - $latFrom;
	$lonDelta = $lonTo - $lonFrom;

	$angle = 2 * asin( sqrt( pow( sin( $latDelta / 2 ), 2 ) + cos( $latFrom ) * cos( $latTo ) * pow( sin( $lonDelta / 2 ), 2 ) ) );
	return $angle * $earthRadius;
}

function inside( $point = array(), $vs = array() ) {
	// ray-casting algorithm based on
	// http://www.ecse.rpi.edu/Homepages/wrf/Research/Short_Notes/pnpoly.html

	$x = $point[ 0 ];
	$y = $point[ 1 ];

	$inside = 'no';
	for ( $i = 0, $j = count( $vs ) - 1; $i < count( $vs ); $j = $i++ ) {
		$xi = $vs[ $i ][ 0 ];
		$yi = $vs[ $i ][ 1 ];
		$xj = $vs[ $j ][ 0 ];
		$yj = $vs[ $j ][ 1 ];

		$intersect = ( ( $yi > $y ) != ( $yj > $y ) ) && ( $x < ( $xj - $xi ) * ( $y - $yi ) / ( $yj - $yi ) + $xi );

		if ( $intersect ) {
			$inside = 'yes';
		}
	}
	return $inside;
}

//ambil jumlah geofencing sekolah
$sql_geofencing_sekolah = "SELECT id_geofencing FROM `tb_geofencing` WHERE jenis='sekolah' and status='0'";
$res_geofencing_sekolah = mysqli_query( $link, $sql_geofencing_sekolah );
$jumlah_geofencing_sekolah = mysqli_num_rows( $res_geofencing_sekolah );
$data_json_geofencing_sekolah = array();
while ( $data_geofencing_sekolah = mysqli_fetch_assoc( $res_geofencing_sekolah ) ) {
	$data_json_geofencing_sekolah[] = $data_geofencing_sekolah;
}

//ambil data guru
$sql_guru = "select nuptk,nama,latitude,longitude from tb_guru where latitude is not null";
$res_guru = mysqli_query( $link, $sql_guru );
$data_json_guru = array();
while ( $data_guru = mysqli_fetch_assoc( $res_guru ) ) {
	$data_json_guru[] = $data_guru;
}

//ambil data siswa
$sql_siswa = "select CURDATE() tanggal_sekarang,TIME_FORMAT(now(), '%H:%i:%s') waktu,tb_siswa.nama,tb_siswa.baterai,tb_siswa.nis,tb_siswa.lat,tb_siswa.longitude,tb_siswa.status,tb_kelas.kelas,tb_kelas.jam_masuk,tb_kelas.jam_keluar,tb_siswa.id_orangtua from tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas=tb_kelas.id_kelas where tb_siswa.lat IS NOT NULL AND tb_siswa.status != 1";
$res_siswa = mysqli_query( $link, $sql_siswa );

while ( $data_siswa = mysqli_fetch_array( $res_siswa ) ) {
	//ambil data geofencing orangtua
	$sql_geofencing_orangtua = "SELECT `id_geofencing` FROM `tb_geofencing` WHERE `id_user`='" . $data_siswa[ 'id_orangtua' ] . "'";
	$res_geofencing_orangtua = mysqli_query( $link, $sql_geofencing_orangtua );
	$jumlah_geofencing_orangtua = mysqli_num_rows( $res_geofencing_orangtua );
	$data_json_geofencing_orangtua = array();
	while ( $data_geofencing_orangtua = mysqli_fetch_assoc( $res_geofencing_orangtua ) ) {
		$data_json_geofencing_orangtua[] = $data_geofencing_orangtua;
	}

	//ambil data orangtua
	$sql_orangtua = "SELECT latitude,longitude FROM `tb_orangtua` WHERE id_orangtua='" . $data_siswa[ 'id_orangtua' ] . "'";
	$res_orangtua = mysqli_query( $link, $sql_orangtua );
	$data_json_orangtua = array();
	while ( $data_orangtua = mysqli_fetch_assoc( $res_orangtua ) ) {
		$data_json_orangtua[] = $data_orangtua;
	}

	//	default variabel
	$cek_jadwal = "no";
	$cek_dalam_sekolah = "no";
	$cek_dalam_rumah = "no";
	$cek_dekat_guru = "no";
	$cek_dekat_orangtua = "no";
	$cek_telat = "no";
	$ubah_status = "tetap";

	//pengecekan jadwal sekolah
	$jam_sekarang = $data_siswa[ 'waktu' ];
	if ( $hari != 'Saturday' && $hari != 'Sunday' ) {
		if ( $data_siswa[ 'jam_masuk' ] <= $jam_sekarang && $jam_sekarang <= $data_siswa[ 'jam_keluar' ] ) {
			$cek_jadwal = "yes";
		}
	}
	echo $data_siswa[ 'nama' ] . '<br> ';
	echo 'jadwal : ' . $cek_jadwal . '<br> ';



	//pengecekan siswa di sekolah atau tidak
	for ( $i = 0; $i < $jumlah_geofencing_sekolah; $i++ ) {
		//ambil data koordinat sekolah
		$sql_koordinat_sekolah = "SELECT tb_geofencing.bentuk,tb_koordinat.latitude,tb_koordinat.longitude,tb_koordinat.radius FROM `tb_geofencing` JOIN tb_koordinat ON tb_geofencing.id_geofencing=tb_koordinat.id_geofencing WHERE jenis='sekolah' AND tb_koordinat.id_geofencing='" . $data_json_geofencing_sekolah[ $i ][ 'id_geofencing' ] . "'";
		$res_koordinat_sekolah = mysqli_query( $link, $sql_koordinat_sekolah );
		$data_json_koordinat_sekolah = array();
		while ( $data_koordinat_sekolah = mysqli_fetch_assoc( $res_koordinat_sekolah ) ) {
			$data_json_koordinat_sekolah[] = $data_koordinat_sekolah;
		}
		if ( $data_json_koordinat_sekolah[ 0 ][ 'bentuk' ] == "circle" ) {
			$jarak_siswa_sekolah = jarak_titik( $data_siswa[ 'lat' ], $data_siswa[ 'longitude' ], $data_json_koordinat_sekolah[ $i ][ 'latitude' ], $data_json_koordinat_sekolah[ $i ][ 'longitude' ] );

			if ( $jarak_siswa_sekolah <= $data_json_koordinat_sekolah[ $i ][ 'radius' ] ) {
				$cek_dalam_sekolah = "yes";
				break;
			}
		} else {
			$polygon = array();
			for ( $j = 0; $j < count( $data_json_koordinat_sekolah ); $j++ ) {
				array_push( $polygon, array( $data_json_koordinat_sekolah[ $j ][ 'latitude' ], $data_json_koordinat_sekolah[ $j ][ 'longitude' ] ) );
			}

			if ( inside( array( $data_siswa[ 'lat' ], $data_siswa[ 'longitude' ] ), $polygon ) == "yes" ) {
				$cek_dalam_sekolah = "yes";
				break;
			}
		}
	}
	echo 'dalam sekolah : ' . $cek_dalam_sekolah . '<br>';

	//pengecekan siswa yes rumah atau tidak
	for ( $i = 0; $i < $jumlah_geofencing_orangtua; $i++ ) {
		//ambil data koordinat rumah
		$sql_koordinat_orangtua = "SELECT tb_geofencing.bentuk,tb_koordinat.latitude,tb_koordinat.longitude,tb_koordinat.radius FROM `tb_geofencing` JOIN tb_koordinat ON tb_geofencing.id_geofencing=tb_koordinat.id_geofencing WHERE tb_koordinat.id_geofencing='" . $data_json_geofencing_orangtua[ $i ][ 'id_geofencing' ] . "'";
		$res_koordinat_orangtua = mysqli_query( $link, $sql_koordinat_orangtua );
		$data_json_koordinat_orangtua = array();
		while ( $data_koordinat_orangtua = mysqli_fetch_assoc( $res_koordinat_orangtua ) ) {
			$data_json_koordinat_orangtua[] = $data_koordinat_orangtua;
		}
		if ( $data_json_koordinat_orangtua[ 0 ][ 'bentuk' ] == "circle" ) {
			$jarak_siswa_rumah = jarak_titik( $data_siswa[ 'lat' ], $data_siswa[ 'longitude' ], $data_json_koordinat_orangtua[ $i ][ 'latitude' ], $data_json_koordinat_orangtua[ $i ][ 'longitude' ] );

			if ( $jarak_siswa_rumah <= $data_json_koordinat_orangtua[ $i ][ 'radius' ] ) {
				$cek_dalam_rumah = "yes";
				break;
			}
		} else {
			$polygon = array();
			for ( $j = 0; $j < count( $data_json_koordinat_orangtua ); $j++ ) {
				array_push( $polygon, array( $data_json_koordinat_orangtua[ $j ][ 'latitude' ], $data_json_koordinat_orangtua[ $j ][ 'longitude' ] ) );
			}

			if ( inside( array( $data_siswa[ 'lat' ], $data_siswa[ 'longitude' ] ), $polygon ) == "yes" ) {
				$cek_dalam_rumah = "yes";
				break;
			}
		}
	}
	echo 'dalam rumah : ' . $cek_dalam_rumah . '<br>';

	//pengecekan siswa dekat guru atau tidak
	for ( $i = 0; $i < count( $data_json_guru ); $i++ ) {
		$jarak_siswa_guru = jarak_titik( $data_siswa[ 'lat' ], $data_siswa[ 'longitude' ], $data_json_guru[ $i ][ 'latitude' ], $data_json_guru[ $i ][ 'longitude' ] );

		if ( $jarak_siswa_guru <= 10 ) {
			$cek_dekat_guru = "yes";
			break;
		}
	}

	echo 'dekat guru : ' . $cek_dekat_guru . '<br> ';

	//	pengecekan siswa dekat orangtua atau tidak
	for ( $i = 0; $i < count( $data_json_orangtua ); $i++ ) {
		$jarak_siswa_orangtua = jarak_titik( $data_siswa[ 'lat' ], $data_siswa[ 'longitude' ], $data_json_orangtua[ $i ][ 'latitude' ], $data_json_orangtua[ $i ][ 'longitude' ] );

		if ( $jarak_siswa_orangtua <= 10 ) {
			$cek_dekat_orangtua = "yes";
			break;
		}
	}

	echo 'dekat orangtua : ' . $cek_dekat_orangtua . '<br> ';
	echo 'baterai : ' . $data_siswa[ 'baterai' ] . '<br> ';

	if ( ( $cek_jadwal == "yes" && ( $cek_dalam_sekolah == "yes" || $cek_dekat_guru == "yes" ) ) && $data_siswa[ 'baterai' ] > 15 && $data_siswa[ 'status' ] != 0 ) {
		$ubah_status = "jadi 0";
		$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='0' WHERE nis='" . $data_siswa[ 'nis' ] . "';";
		$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );

		if ( $data_siswa[ 'status' ] == 5 || $data_siswa[ 'status' ] == 6 || $data_siswa[ 'status' ] == 7 || $data_siswa[ 'status' ] == 8 || $data_siswa[ 'status' ] == 9 ) {
			$sql_insert_notifikasi = "INSERT INTO `tb_notifikasi`(`id_notifikasi`, `nis`, `nuptk`, `pesan_notif`, `waktu`, `status`) VALUES (NULL,'" . $data_siswa[ 'nis' ] . "',NULL,'masuk sekolah',CURRENT_TIMESTAMP,'0')";
			$res_insert_notifikasi = mysqli_query( $link, $sql_insert_notifikasi );
		} else if ( $data_siswa[ 'status' ] == 2 || $data_siswa[ 'status' ] == 4 ) {
			$sql_insert_notifikasi = "INSERT INTO `tb_notifikasi`(`id_notifikasi`, `nis`, `nuptk`, `pesan_notif`, `waktu`, `status`) VALUES (NULL,'" . $data_siswa[ 'nis' ] . "',NULL,'kembali ke sekolah',CURRENT_TIMESTAMP,'0')";
			$res_insert_notifikasi = mysqli_query( $link, $sql_insert_notifikasi );
		}
	} else {
		$sql_telat = "SELECT `id_notifikasi` FROM `tb_notifikasi` WHERE `waktu` LIKE '" . $data_siswa[ 'tanggal_sekarang' ] . "%' AND `pesan_notif`='belum masuk sekolah' AND `nis`='" . $data_siswa[ 'nis' ] . "'";
		$res_telat = mysqli_query( $link, $sql_telat );
		$ketemu_telat = mysqli_num_rows( $res_telat );

		$datetime1 = strtotime( $data_siswa[ 'jam_masuk' ] );
		$datetime2 = strtotime( $jam_sekarang );
		$interval = $datetime2 - $datetime1;
		$minutes = round( $interval / 60 );
		if ( $cek_jadwal == "yes" ) {
			if ( $minutes >= 30 && $data_siswa[ 'status' ] != 0 && $ketemu_telat == 0 ) {
				$sql_insert_notifikasi = "INSERT INTO `tb_notifikasi`(`id_notifikasi`, `nis`, `nuptk`, `pesan_notif`, `waktu`, `status`) VALUES (NULL,'" . $data_siswa[ 'nis' ] . "',NULL,'belum masuk sekolah',CURRENT_TIMESTAMP,'0')";
				$res_insert_notifikasi = mysqli_query( $link, $sql_insert_notifikasi );
			}
		}
	}

//	( $data_siswa[ 'status' ] != 7 && $data_siswa[ 'status' ] != 9 ) && $data_siswa[ 'status' ] != 2
	
	if ( $cek_jadwal == "yes" && $cek_dalam_sekolah == "no" && $cek_dekat_guru == "no" && $cek_dalam_rumah == "no" && $cek_dekat_orangtua == "no" && $data_siswa[ 'baterai' ] > 15 && ( $data_siswa[ 'status' ] == 0 || $data_siswa[ 'status' ] == 3 )  ) {
		$ubah_status = "jadi 2";
		$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='2' WHERE nis='" . $data_siswa[ 'nis' ] . "';";
		$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );

		$sql_insert_notifikasi = "INSERT INTO `tb_notifikasi`(`id_notifikasi`, `nis`, `nuptk`, `pesan_notif`, `waktu`, `status`) VALUES (NULL,'" . $data_siswa[ 'nis' ] . "',NULL,'keluar sekolah',CURRENT_TIMESTAMP,'0')";
		$res_insert_notifikasi = mysqli_query( $link, $sql_insert_notifikasi );
	}

	if ( $data_siswa[ 'status' ] == 0 && $data_siswa[ 'baterai' ] <= 15 ) {
		$ubah_status = "jadi 3";
		$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='3' WHERE nis='" . $data_siswa[ 'nis' ] . "';";
		$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );

		$sql_insert_notifikasi = "INSERT INTO `tb_notifikasi`(`id_notifikasi`, `nis`, `nuptk`, `pesan_notif`, `waktu`, `status`) VALUES (NULL,'" . $data_siswa[ 'nis' ] . "',NULL,'baterai lemah sekolah',CURRENT_TIMESTAMP,'0')";
		$res_insert_notifikasi = mysqli_query( $link, $sql_insert_notifikasi );
	}

	if ( $data_siswa[ 'status' ] == 2 && $data_siswa[ 'baterai' ] <= 15 ) {
		$ubah_status = "jadi 4";
		$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='4' WHERE nis='" . $data_siswa[ 'nis' ] . "';";
		$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );

		$sql_insert_notifikasi = "INSERT INTO `tb_notifikasi`(`id_notifikasi`, `nis`, `nuptk`, `pesan_notif`, `waktu`, `status`) VALUES (NULL,'" . $data_siswa[ 'nis' ] . "',NULL,'keluar sekolah dan baterai lemah',CURRENT_TIMESTAMP,'0')";
		$res_insert_notifikasi = mysqli_query( $link, $sql_insert_notifikasi );
	}

	if ( $cek_jadwal == "no" && ( $cek_dalam_sekolah == "yes" || $cek_dekat_guru == "yes" ) && $cek_dalam_rumah == "no" && $cek_dekat_orangtua == "no" && $data_siswa[ 'status' ] != 5 && $data_siswa[ 'status' ] != 7 && $data_siswa[ 'status' ] != 9 ) {
		$ubah_status = "jadi 5";
		$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='5' WHERE nis='" . $data_siswa[ 'nis' ] . "';";
		$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );

		$sql_insert_notifikasi = "INSERT INTO `tb_notifikasi`(`id_notifikasi`, `nis`, `nuptk`, `pesan_notif`, `waktu`, `status`) VALUES (NULL,'" . $data_siswa[ 'nis' ] . "',NULL,'pulang sekolah',CURRENT_TIMESTAMP,'0')";
		$res_insert_notifikasi = mysqli_query( $link, $sql_insert_notifikasi );
	}

	if ( ( $cek_dalam_rumah == "yes" || $cek_dekat_orangtua == "yes" ) && $data_siswa[ 'baterai' ] > 15 && ( $data_siswa[ 'status' ] != 6 && $data_siswa[ 'status' ] != 3 ) ) {
		$ubah_status = "jadi 6";
		$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='6' WHERE nis='" . $data_siswa[ 'nis' ] . "';";
		$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );

		if ( $cek_dalam_rumah == "yes" ) {
			$sql_insert_notifikasi = "INSERT INTO `tb_notifikasi`(`id_notifikasi`, `nis`, `nuptk`, `pesan_notif`, `waktu`, `status`) VALUES (NULL,'" . $data_siswa[ 'nis' ] . "',NULL,'di rumah',CURRENT_TIMESTAMP,'0')";
			$res_insert_notifikasi = mysqli_query( $link, $sql_insert_notifikasi );
		} else if ( $cek_dekat_orangtua == "yes" ) {
			$sql_insert_notifikasi = "INSERT INTO `tb_notifikasi`(`id_notifikasi`, `nis`, `nuptk`, `pesan_notif`, `waktu`, `status`) VALUES (NULL,'" . $data_siswa[ 'nis' ] . "',NULL,'di dekat orangtua',CURRENT_TIMESTAMP,'0')";
			$res_insert_notifikasi = mysqli_query( $link, $sql_insert_notifikasi );
		}


	}

	if ( ( $data_siswa[ 'status' ] == 6 || $data_siswa[ 'status' ] == 8 || $data_siswa[ 'status' ] == 9 ) && $cek_dalam_rumah == "no" && $cek_dekat_orangtua == "no" && $data_siswa[ 'baterai' ] > 15 ) {
		$ubah_status = "jadi 7";
		$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='7' WHERE nis='" . $data_siswa[ 'nis' ] . "';";
		$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );

		$sql_insert_notifikasi = "INSERT INTO `tb_notifikasi`(`id_notifikasi`, `nis`, `nuptk`, `pesan_notif`, `waktu`, `status`) VALUES (NULL,'" . $data_siswa[ 'nis' ] . "',NULL,'keluar rumah',CURRENT_TIMESTAMP,'0')";
		$res_insert_notifikasi = mysqli_query( $link, $sql_insert_notifikasi );
	}

	if ( ( $cek_dalam_rumah == "yes" || $cek_dekat_orangtua == "yes" ) && $data_siswa[ 'baterai' ] <= 15 && $data_siswa[ 'status' ] != 8 ) {
		$ubah_status = "jadi 8";
		$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='8' WHERE nis='" . $data_siswa[ 'nis' ] . "';";
		$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );

		$sql_insert_notifikasi = "INSERT INTO `tb_notifikasi`(`id_notifikasi`, `nis`, `nuptk`, `pesan_notif`, `waktu`, `status`) VALUES (NULL,'" . $data_siswa[ 'nis' ] . "',NULL,'baterai lemah rumah',CURRENT_TIMESTAMP,'0')";
		$res_insert_notifikasi = mysqli_query( $link, $sql_insert_notifikasi );
	}

	if ( ( $data_siswa[ 'status' ] == 6 || $data_siswa[ 'status' ] == 8 || $data_siswa[ 'status' ] == 7 ) && $cek_dalam_rumah == "no" && $cek_dekat_orangtua == "no" && $data_siswa[ 'baterai' ] <= 15 ) {
		$ubah_status = "jadi 9";
		$sql_ubah_status_siswa = "UPDATE `tb_siswa` SET `status`='9' WHERE nis='" . $data_siswa[ 'nis' ] . "';";
		$res_ubah_status_siswa = mysqli_query( $link, $sql_ubah_status_siswa );

		$sql_insert_notifikasi = "INSERT INTO `tb_notifikasi`(`id_notifikasi`, `nis`, `nuptk`, `pesan_notif`, `waktu`, `status`) VALUES (NULL,'" . $data_siswa[ 'nis' ] . "',NULL,'keluar rumah dan baterai lemah',CURRENT_TIMESTAMP,'0')";
		$res_insert_notifikasi = mysqli_query( $link, $sql_insert_notifikasi );
	}

	echo '<strong>' . $ubah_status . '</strong><br><br>';

}

?>