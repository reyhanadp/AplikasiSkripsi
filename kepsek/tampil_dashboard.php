<?php
if ( isset( $_POST[ 'tahun' ] ) ) {
	$tahun = $_POST[ 'tahun' ];
	$awal_tahun = $tahun . '-01-01';
	$akhir_tahun = $tahun . '-12-31';
	$query_kabur_sdlb = "SELECT (select COUNT(DISTINCT tb_laporan.nis) FROM tb_siswa JOIN tb_laporan ON tb_siswa.nis=tb_laporan.nis JOIN tb_kelas ON tb_kelas.id_kelas=tb_siswa.id_kelas where tb_kelas.tingkatan='SDLB' AND waktu_kabur between '$awal_tahun' and '$akhir_tahun') as Kabur from dual";
	$result_kabur = mysqli_query( $link, $query_kabur_sdlb );
	$data_kabur = mysqli_fetch_array( $result_kabur );
	$jml_kabur_sdlb = $data_kabur[ 'Kabur' ];

	$query_tidak_kabur_sdlb = "SELECT ((SELECT COUNT(*) FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas=tb_kelas.id_kelas WHERE tb_kelas.tingkatan='SDLB')-(select COUNT(DISTINCT tb_laporan.nis) FROM tb_siswa JOIN tb_laporan ON tb_siswa.nis=tb_laporan.nis JOIN tb_kelas ON tb_kelas.id_kelas=tb_siswa.id_kelas where tb_kelas.tingkatan='SDLB' AND waktu_kabur between '$awal_tahun' and '$akhir_tahun')) as 'Tidak Kabur' from dual";
	$result_tidak_kabur = mysqli_query( $link, $query_tidak_kabur_sdlb );
	$data_tidak_kabur = mysqli_fetch_array( $result_tidak_kabur );
	$jml_tidak_kabur_sdlb = $data_tidak_kabur[ 'Tidak Kabur' ];

	$query_kabur_smplb = "SELECT (select COUNT(DISTINCT tb_laporan.nis) FROM tb_siswa JOIN tb_laporan ON tb_siswa.nis=tb_laporan.nis JOIN tb_kelas ON tb_kelas.id_kelas=tb_siswa.id_kelas where tb_kelas.tingkatan='SMPLB' AND waktu_kabur between '$awal_tahun' and '$akhir_tahun') as Kabur from dual";
	$result_kabur = mysqli_query( $link, $query_kabur_smplb );
	$data_kabur = mysqli_fetch_array( $result_kabur );
	$jml_kabur_smplb = $data_kabur[ 'Kabur' ];

	$query_tidak_kabur_smplb = "SELECT ((SELECT COUNT(*) FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas=tb_kelas.id_kelas WHERE tb_kelas.tingkatan='SMPLB')-(select COUNT(DISTINCT tb_laporan.nis) FROM tb_siswa JOIN tb_laporan ON tb_siswa.nis=tb_laporan.nis JOIN tb_kelas ON tb_kelas.id_kelas=tb_siswa.id_kelas where tb_kelas.tingkatan='SMPLB' AND waktu_kabur between '$awal_tahun' and '$akhir_tahun')) as 'Tidak Kabur' from dual";
	$result_tidak_kabur = mysqli_query( $link, $query_tidak_kabur_smplb );
	$data_tidak_kabur = mysqli_fetch_array( $result_tidak_kabur );
	$jml_tidak_kabur_smplb = $data_tidak_kabur[ 'Tidak Kabur' ];

	$query_kabur_smalb = "SELECT (select COUNT(DISTINCT tb_laporan.nis) FROM tb_siswa JOIN tb_laporan ON tb_siswa.nis=tb_laporan.nis JOIN tb_kelas ON tb_kelas.id_kelas=tb_siswa.id_kelas where tb_kelas.tingkatan='SMALB' AND waktu_kabur between '$awal_tahun' and '$akhir_tahun') as Kabur from dual";
	$result_kabur = mysqli_query( $link, $query_kabur_smalb );
	$data_kabur = mysqli_fetch_array( $result_kabur );
	$jml_kabur_smalb = $data_kabur[ 'Kabur' ];

	$query_tidak_kabur_smalb = "SELECT ((SELECT COUNT(*) FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas=tb_kelas.id_kelas WHERE tb_kelas.tingkatan='SMALB')-(select COUNT(DISTINCT tb_laporan.nis) FROM tb_siswa JOIN tb_laporan ON tb_siswa.nis=tb_laporan.nis JOIN tb_kelas ON tb_kelas.id_kelas=tb_siswa.id_kelas where tb_kelas.tingkatan='SMALB' AND waktu_kabur between '$awal_tahun' and '$akhir_tahun')) as 'Tidak Kabur' from dual";
	$result_tidak_kabur = mysqli_query( $link, $query_tidak_kabur_smalb );
	$data_tidak_kabur = mysqli_fetch_array( $result_tidak_kabur );
	$jml_tidak_kabur_smalb = $data_tidak_kabur[ 'Tidak Kabur' ];
} else {
	$tanggal = getdate();
	$tahun = $tanggal[ 'year' ];

	$awal_tahun = $tahun . '-01-01';
	$akhir_tahun = $tahun . '-12-31';
	$query_kabur_sdlb = "SELECT (select COUNT(DISTINCT tb_laporan.nis) FROM tb_siswa JOIN tb_laporan ON tb_siswa.nis=tb_laporan.nis JOIN tb_kelas ON tb_kelas.id_kelas=tb_siswa.id_kelas where tb_kelas.tingkatan='SDLB' AND waktu_kabur between '$awal_tahun' and '$akhir_tahun') as Kabur from dual";
	$result_kabur = mysqli_query( $link, $query_kabur_sdlb );
	$data_kabur = mysqli_fetch_array( $result_kabur );
	$jml_kabur_sdlb = $data_kabur[ 'Kabur' ];

	$query_tidak_kabur_sdlb = "SELECT ((SELECT COUNT(*) FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas=tb_kelas.id_kelas WHERE tb_kelas.tingkatan='SDLB')-(select COUNT(DISTINCT tb_laporan.nis) FROM tb_siswa JOIN tb_laporan ON tb_siswa.nis=tb_laporan.nis JOIN tb_kelas ON tb_kelas.id_kelas=tb_siswa.id_kelas where tb_kelas.tingkatan='SDLB' AND waktu_kabur between '$awal_tahun' and '$akhir_tahun')) as 'Tidak Kabur' from dual";
	$result_tidak_kabur = mysqli_query( $link, $query_tidak_kabur_sdlb );
	$data_tidak_kabur = mysqli_fetch_array( $result_tidak_kabur );
	$jml_tidak_kabur_sdlb = $data_tidak_kabur[ 'Tidak Kabur' ];

	$query_kabur_smplb = "SELECT (select COUNT(DISTINCT tb_laporan.nis) FROM tb_siswa JOIN tb_laporan ON tb_siswa.nis=tb_laporan.nis JOIN tb_kelas ON tb_kelas.id_kelas=tb_siswa.id_kelas where tb_kelas.tingkatan='SMPLB' AND waktu_kabur between '$awal_tahun' and '$akhir_tahun') as Kabur from dual";
	$result_kabur = mysqli_query( $link, $query_kabur_smplb );
	$data_kabur = mysqli_fetch_array( $result_kabur );
	$jml_kabur_smplb = $data_kabur[ 'Kabur' ];

	$query_tidak_kabur_smplb = "SELECT ((SELECT COUNT(*) FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas=tb_kelas.id_kelas WHERE tb_kelas.tingkatan='SMPLB')-(select COUNT(DISTINCT tb_laporan.nis) FROM tb_siswa JOIN tb_laporan ON tb_siswa.nis=tb_laporan.nis JOIN tb_kelas ON tb_kelas.id_kelas=tb_siswa.id_kelas where tb_kelas.tingkatan='SMPLB' AND waktu_kabur between '$awal_tahun' and '$akhir_tahun')) as 'Tidak Kabur' from dual";
	$result_tidak_kabur = mysqli_query( $link, $query_tidak_kabur_smplb );
	$data_tidak_kabur = mysqli_fetch_array( $result_tidak_kabur );
	$jml_tidak_kabur_smplb = $data_tidak_kabur[ 'Tidak Kabur' ];

	$query_kabur_smalb = "SELECT (select COUNT(DISTINCT tb_laporan.nis) FROM tb_siswa JOIN tb_laporan ON tb_siswa.nis=tb_laporan.nis JOIN tb_kelas ON tb_kelas.id_kelas=tb_siswa.id_kelas where tb_kelas.tingkatan='SMALB' AND waktu_kabur between '$awal_tahun' and '$akhir_tahun') as Kabur from dual";
	$result_kabur = mysqli_query( $link, $query_kabur_smalb );
	$data_kabur = mysqli_fetch_array( $result_kabur );
	$jml_kabur_smalb = $data_kabur[ 'Kabur' ];

	$query_tidak_kabur_smalb = "SELECT ((SELECT COUNT(*) FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas=tb_kelas.id_kelas WHERE tb_kelas.tingkatan='SMALB')-(select COUNT(DISTINCT tb_laporan.nis) FROM tb_siswa JOIN tb_laporan ON tb_siswa.nis=tb_laporan.nis JOIN tb_kelas ON tb_kelas.id_kelas=tb_siswa.id_kelas where tb_kelas.tingkatan='SMALB' AND waktu_kabur between '$awal_tahun' and '$akhir_tahun')) as 'Tidak Kabur' from dual";
	$result_tidak_kabur = mysqli_query( $link, $query_tidak_kabur_smalb );
	$data_tidak_kabur = mysqli_fetch_array( $result_tidak_kabur );
	$jml_tidak_kabur_smalb = $data_tidak_kabur[ 'Tidak Kabur' ];
}
?>

<script type="text/javascript">
	$( function () {

		//get the doughnut chart canvas
		var ctx1 = $( "#chartSDLB" );
		var ctx2 = $( "#chartSMPLB" );
		var ctx3 = $( "#chartSMALB" );

		//doughnut chart data
		var data1 = {
			labels: [ "Kabur", "Tidak Kabur" ],
			datasets: [ {
				label: "SDLB",
				data: [ <?php echo $jml_kabur_sdlb; ?>, <?php echo $jml_tidak_kabur_sdlb; ?> ],
				backgroundColor: [
					"#DEB887",
					"#A9A9A9"
				],
				borderColor: [
					"#CDA776",
					"#989898"
				],
				borderWidth: [ 1, 1 ]
			} ]
		};

		var data2 = {
			labels: [ "Kabur", "Tidak Kabur" ],
			datasets: [ {
				label: "SMPLB",
				data: [ <?php echo $jml_kabur_smplb; ?>, <?php echo $jml_tidak_kabur_smplb; ?> ],
				backgroundColor: [
					"#DEB887",
					"#A9A9A9"
				],
				borderColor: [
					"#CDA776",
					"#989898"
				],
				borderWidth: [ 1, 1 ]
			} ]
		};

		var data3 = {
			labels: [ "Kabur", "Tidak Kabur" ],
			datasets: [ {
				label: "SMALB",
				data: [ <?php echo $jml_kabur_smalb;?>, <?php echo $jml_tidak_kabur_smalb; ?> ],
				backgroundColor: [
					"#DEB887",
					"#A9A9A9"
				],
				borderColor: [
					"#CDA776",
					"#989898"
				],
				borderWidth: [ 1, 1 ]
			} ]
		};

		//options
		var optionsSDLB = {
			responsive: true,
			title: {
				display: true,
				position: "top",
				text: "SDLB",
				fontSize: 18,
				fontColor: "#111"
			},
			legend: {
				display: true,
				position: "bottom",
				labels: {
					fontColor: "#333",
					fontSize: 16
				}
			}
		};
		var optionsSMPLB = {
			responsive: true,
			title: {
				display: true,
				position: "top",
				text: "SMPLB",
				fontSize: 18,
				fontColor: "#111"
			},
			legend: {
				display: true,
				position: "bottom",
				labels: {
					fontColor: "#333",
					fontSize: 16
				}
			}
		};

		var optionsSMALB = {
			responsive: true,
			title: {
				display: true,
				position: "top",
				text: "SMALB",
				fontSize: 18,
				fontColor: "#111"
			},
			legend: {
				display: true,
				position: "bottom",
				labels: {
					fontColor: "#333",
					fontSize: 16
				}
			}
		};

		//create Chart class object
		var chart1 = new Chart( ctx1, {
			type: "doughnut",
			data: data1,
			options: optionsSDLB
		} );

		var chart2 = new Chart( ctx2, {
			type: "doughnut",
			data: data2,
			options: optionsSMPLB
		} );

		var chart3 = new Chart( ctx3, {
			type: "doughnut",
			data: data3,
			options: optionsSMALB
		} );

	} );
</script>
<?php
$query = "SELECT DISTINCT(YEAR(waktu_kabur)) as tahun FROM tb_laporan";
$res = mysqli_query( $link, $query );
$tanggal = getdate();
$tahun_sekarang = $tanggal[ 'year' ];

?>

<section id="main-content">
	<section class="wrapper">
		<div id="page-wrapper" style="padding-left: 10px; padding-right: 10px; padding-top: 20px;">
			<div class="row">
				<div class="col-md-12">
					<center>
						<h1>Statistik Pemantauan Siswa <?php echo $tahun;?></h1>
					</center>
				</div>
				<div class="row">
					<form action="index.php" method="POST">
						<div class="col-md-3">Tahun :
							<select id="selectBox" name='tahun'>
								<?php
								$cek_tahun = 0;
								while ( $data_tahun = mysqli_fetch_array( $res ) ) {
									if ( $data_tahun[ 'tahun' ] == $tahun_sekarang ) {
										$cek_tahun = 1;
									}
									?>

								<option value="<?php echo $data_tahun['tahun'];?>">
									<?php echo $data_tahun['tahun'];?>
								</option>

								<?php
								}
								if ( $cek_tahun == 0 ) {
									?>
								<option value="<?php echo $tahun_sekarang;?>" selected>
									<?php echo $tahun_sekarang;?>
								</option>
								<?php 
						}
						?>

							</select><button type="submit"> Pilih </button>
					</form>
					</div>
				</div>

				<!-- /.row -->

				<div class="row">
					<div class="col-md-4">
						<canvas id="chartSDLB"></canvas><br>
						<center>
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<th colspan=3>
										<center><strong>SDLB</strong>
									</th>
								</thead>
								<tbody>
									<tr>
										<td>
											<center><strong>Kabur</strong>
										</td>
										<td>
											<center><strong>Tidak kabur</strong>
										</td>
										<td>
											<center><strong>Total Siswa</strong>
										</td>
									</tr>
									<tr>
										<td>
											<center>
												<?php echo $jml_kabur_sdlb; ?>
										</td>
										<td>
											<center>
												<?php echo $jml_tidak_kabur_sdlb; ?>
										</td>
										<td>
											<center>
												<?php echo $jml_tidak_kabur_sdlb+$jml_kabur_sdlb; ?>
										</td>
									</tr>
								</tbody>
							</table>
							</center>
					</div>
					<div class="col-md-4">
						<canvas id="chartSMPLB"></canvas><br>
						<center>
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<th colspan=3>
										<center><strong>SMPLB</strong>
									</th>
								</thead>
								<tbody>
									<tr>
										<td>
											<center><strong>Kabur</strong>
										</td>
										<td>
											<center><strong>Tidak kabur</strong>
										</td>
										<td>
											<center><strong>Total Siswa</strong>
										</td>
									</tr>
									<tr>
										<td>
											<center>
												<?php echo $jml_kabur_smplb; ?>
										</td>
										<td>
											<center>
												<?php echo $jml_tidak_kabur_smplb; ?>
										</td>
										<td>
											<center>
												<?php echo $jml_tidak_kabur_smplb+$jml_kabur_smplb; ?>
										</td>
									</tr>
								</tbody>
							</table>
							</center>
					</div>
					<div class="col-md-4">
						<canvas id="chartSMALB"></canvas><br>
						<center>
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<th colspan=3>
										<center><strong>SMALB</strong>
									</th>
								</thead>
								<tbody>
									<tr>
										<td>
											<center><strong>Kabur</strong>
										</td>
										<td>
											<center><strong>Tidak kabur</strong>
										</td>
										<td>
											<center><strong>Total Siswa</strong>
										</td>
									</tr>
									<tr>
										<td>
											<center>
												<?php echo $jml_kabur_smalb; ?>
										</td>
										<td>
											<center>
												<?php echo $jml_tidak_kabur_smalb; ?>
										</td>
										<td>
											<center>
												<?php echo $jml_tidak_kabur_smalb+$jml_kabur_smalb; ?>
										</td>
									</tr>
								</tbody>
							</table>
							</center>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>

<!-- /#wrapper -->