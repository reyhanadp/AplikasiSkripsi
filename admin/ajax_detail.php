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
	}
}


echo json_encode( $data_json );

?>