<?php
session_start();
if ( isset( $_SESSION[ 's_nuptk' ] ) ) {
	if ( $_SESSION[ 's_kode_jabatan' ] == "BKS" ) {
		echo( "<script> location.href ='admin/index.php';</script>" );
	} else if ( $_SESSION[ 's_kode_jabatan' ] == "KSK" ) {
		echo( "<script> location.href ='kepsek/index.php';</script>" );
	} else {
		echo( "<script> location.href ='guru/index.php';</script>" );
	}
} else if ( isset( $_SESSION[ 's_id_orangtua' ] ) ) {
	echo( "<script> location.href ='orangtua/index.php';</script>" );
} else {
	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<title>Pemantauan</title>

		<?php
		//	header
		require( 'login/login_header.php' );
		?>

		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100">

					<form class="login100-form validate-form" enctype="multipart/form-data" method="post" action="login/login.php">

						<span class="login100-form-title p-b-43">
						Login to continue
					</span>
					

						<?php
						if ( isset( $_SESSION[ 's_pesan' ] ) ) {
							?>
						<div class="alert alert-danger" role="alert" align="center">
							<strong>Warning! </strong>
						</div>
						<?php echo $_SESSION['s_pesan']; ?>
						<?php
						unset( $_SESSION[ 's_pesan' ] );
						}
						?>

						<div class="wrap-input100">
							<input class="input100" type="text" name="username">
							<span class="focus-input100"></span>
							<span class="label-input100">Username</span>
						</div>


						<div class="wrap-input100 validate-input" data-validate="Password is required">
							<input class="input100" type="password" name="password">
							<span class="focus-input100"></span>
							<span class="label-input100">Password</span>
						</div>

						<div class="flex-sb-m w-full p-t-3 p-b-32">
							<div class="contact100-form-checkbox">
								<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
								<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
							

							</div>

							<div>
								<a href="#" class="txt1">
								Forgot Password?
							</a>
							

							</div>
						</div>


						<div class="container-login100-form-btn">
							<button class="login100-form-btn">
							Login
						</button>
						

						</div>

					</form>

					<div class="login100-more" style="background-image: url('foto/background.jpg');">
					</div>
				</div>
			</div>
		</div>
		<?php
		//	footer
		require( 'login/login_footer.php' );
		}
		?>