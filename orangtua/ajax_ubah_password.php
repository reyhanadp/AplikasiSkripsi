<?php
	session_start();
	require('../koneksi.php');
	$link = koneksi_db();

	if ( isset( $_POST[ 'id_orangtua' ] ) ) {
			$id_orangtua = $_POST[ 'id_orangtua' ];
			$query = "SELECT * FROM tb_orangtua WHERE id_orangtua = '$id_orangtua'";
			$res = mysqli_query( $link, $query );
			while ( $row = mysqli_fetch_assoc( $res ) ) {
				?>
				<form action="proses_ubah_password.php" method="POST" onSubmit="return confirm('Apakah anda yakin ingin menyimpan data?');" enctype="multipart/form-data">
					<input type="hidden" name="id_orangtua" value="<?php echo $row['id_orangtua']; ?>">
					<div class="form-group">
						<center>
							<img src="../foto/orangtua/<?php echo $row['foto']; ?>" class="img-rounded" width="200" height="200">
						</center>
					</div>
					<div class="form-group">
						<label for="password_lama">Password Lama:</label>
						<input type="password" class="form-control" name="pass_lama" placeholder="Masukkan Password Lama" required>
					</div>
					<div class="form-group">
						<label for="pass_baru">Password Baru:</label>
						<input type="password" class="form-control" name="pass_baru" placeholder="Masukkan Password Baru" required>
					</div>
					<div class="form-group">
						<label for="konf_pass">Konfirmasi Password:</label>
						<input type="password" class="form-control" name="konf_pass" placeholder="Masukkan Konfirmasi Password" required>
					</div>
					<div>
						<button type="submit" class="btn btn-primary" name="submit">Simpan</button>
					</div>
				</form>


				<?php
			}
		}
?>