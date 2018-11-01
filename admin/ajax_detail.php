<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

if ( isset( $_POST[ 'jenis' ] ) ) {
	if ( $_POST[ 'jenis' ] == "siswa" ) {
		$sql = "select nis,tb_siswa.password,tb_siswa.nama 'nama_siswa',tb_siswa.alamat 'alamat_siswa',tb_siswa.tempat_lahir,tb_siswa.tgl_lahir,tb_siswa.status 'status_siswa',tb_orangtua.nama 'nama_orangtua',tb_kelas.kelas,tb_kelas.tingkatan, tb_kelas.id_kelas, tb_orangtua.id_orangtua, tb_siswa.nuptk, tb_guru.nama 'nama_guru' from tb_siswa join tb_kelas on tb_siswa.id_kelas=tb_kelas.id_kelas join tb_orangtua on tb_siswa.id_orangtua=tb_orangtua.id_orangtua join tb_guru on tb_siswa.nuptk=tb_guru.nuptk where nis='" . $_POST[ 'id' ] . "'";
		$res = mysqli_query( $link, $sql );

		$data = mysqli_fetch_array( $res );

		$data_json = array(
			'nis' => $data[ 'nis' ],
			'nama_siswa' => $data[ 'nama_siswa' ],
			'alamat_siswa' => $data[ 'alamat_siswa' ],
			'tempat_lahir' => $data[ 'tempat_lahir' ],
			'tgl_lahir' => $data['tgl_lahir'],
			'status_siswa' => $data[ 'status_siswa' ],
			'nama_orangtua' => $data[ 'nama_orangtua' ],
			'kelas' => $data[ 'kelas' ],
			'tingkatan' => $data[ 'tingkatan' ],
			'password' => $data['password'],
			'id_kelas' => $data['id_kelas'],
			'id_orangtua' => $data['id_orangtua'],
			'nuptk' => $data['nuptk'],
			'nama_guru' => $data['nama_guru']
		);
	}else if($_POST[ 'jenis' ] == "guru"){
		$sql = "SELECT tb_guru.nuptk,tb_guru.nip,tb_guru.nama 'nama_guru',tb_guru.tempat_lahir,tb_guru.tgl_lahir,tb_kelas.kelas,tb_kelas.tingkatan,tb_jabatan.kode_jabatan,tb_jabatan.nama_jabatan,tb_guru.status,tb_guru.password,tb_guru.id_kelas FROM `tb_guru` JOIN tb_jabatan ON tb_guru.kode_jabatan=tb_jabatan.kode_jabatan JOIN tb_kelas ON tb_guru.id_kelas=tb_kelas.id_kelas where tb_guru.nuptk = '" . $_POST[ 'id' ] . "'";
		$res = mysqli_query( $link, $sql );

		$data = mysqli_fetch_array( $res );

		$data_json = array(
			'nuptk' => $data[ 'nuptk' ],
			'nip' => $data[ 'nip' ],
			'nama_guru' => $data[ 'nama_guru' ],
			'tempat_lahir' => $data[ 'tempat_lahir' ],
			'tgl_lahir' => $data['tgl_lahir'],
			'kelas' => $data[ 'kelas' ],
			'tingkatan' => $data[ 'tingkatan' ],
			'kode_jabatan' => $data['kode_jabatan'],
			'nama_jabatan' => $data['nama_jabatan'],
			'status_guru' => $data[ 'status_guru' ],
			'password' => $data['password'],
			'id_kelas' => $data['id_kelas']
		);
	}else if($_POST[ 'jenis' ] == "orangtua"){
		$sql = "SELECT * FROM `tb_orangtua` where id_orangtua = '" . $_POST[ 'id' ] . "'";
		$res = mysqli_query( $link, $sql );

		$data = mysqli_fetch_array( $res );

		$data_json = array(
			'id_orangtua' => $data[ 'id_orangtua' ],
			'nama_orangtua' => $data[ 'nama' ],
			'alamat' => $data[ 'alamat' ],
			'no_telp' => $data[ 'no_telp' ],
			'password' => $data['password'],
			'status' => $data[ 'status' ]
		);
	}else if($_POST[ 'jenis' ] == "jabatan"){
		$sql = "SELECT * FROM `tb_jabatan` where kode_jabatan = '" . $_POST[ 'id' ] . "'";
		$res = mysqli_query( $link, $sql );

		$data = mysqli_fetch_array( $res );

		$data_json = array(
			'kode_jabatan' => $data[ 'kode_jabatan' ],
			'nama_jabatan' => $data[ 'nama_jabatan' ]
		);
	}else if($_POST[ 'jenis' ] == "kelas"){
		$sql = "SELECT id_kelas,kelas,tingkatan, DATE_FORMAT(jam_masuk, '%H:%i') 'jam_masuk',DATE_FORMAT(jam_keluar, '%H:%i') 'jam_keluar' FROM `tb_kelas` where id_kelas = '" . $_POST[ 'id' ] . "'";
		$res = mysqli_query( $link, $sql );

		$data = mysqli_fetch_array( $res );

		$data_json = array(
			'id_kelas' => $data[ 'id_kelas' ],
			'kelas' => $data[ 'kelas' ],
			'tingkatan' => $data[ 'tingkatan' ],
			'jam_masuk' => $data[ 'jam_masuk' ],
			'jam_keluar' => $data[ 'jam_keluar' ]
		);
	}
}


echo json_encode( $data_json );

?>