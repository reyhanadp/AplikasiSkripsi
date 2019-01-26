<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

$query_ambil_geofencing = "SELECT * FROM `tb_geofencing` WHERE `status`='0'";
$result_ambil_geofencing = mysqli_query( $link, $query_ambil_geofencing );
while ( $data_ambil_geofencing = mysqli_fetch_array( $result_ambil_geofencing ) ) {
	?>
	<table class="table table-bordered">
		<tr>
			<td class="col-md-12">
				<div class="row">
					<div class="col-md-10">
						<b>
							<?php echo $data_ambil_geofencing['nama']; ?>
						</b>
					</div>
					<div class="col-md-2">
						<button type="button" data-id="<?php echo  $data_ambil_geofencing['id_geofencing']; ?>" class="btn btn-primary btn-sm restore">Restore</button>
					</div>
				</div>
			</td>
		</tr>
	</table>
	<?php

}
mysqli_close( $link );


?>