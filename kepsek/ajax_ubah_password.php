<?php
	session_start();
	require('../koneksi.php');
	$link = koneksi_db();

	if ( isset( $_POST[ 'nuptk' ] ) ) {
			$nuptk = $_POST[ 'nuptk' ];
			$query = "SELECT * FROM tb_guru WHERE nuptk = $nuptk";
			$res = mysqli_query( $link, $query );
			while ( $row = mysqli_fetch_assoc( $res ) ) {
				?>
				<form action="proses_ubah_password.php?nuptk=<?php echo $nuptk; ?>" method="POST" onSubmit="return confirm('Apakah anda yakin ingin menyimpan data?');" enctype="multipart/form-data">
					<input type="hidden" name="nuptk" value="<?php echo $row['nuptk']; ?>">
					<div class="form-group">
						<center>
							<img src="../foto/guru/<?php echo $row['foto']; ?>" class="img-rounded" width="200" height="200">
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