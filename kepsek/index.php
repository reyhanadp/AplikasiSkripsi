<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();
if ( isset( $_SESSION[ 's_nuptk' ] ) ) {
	if ( $_SESSION[ 's_kode_jabatan' ] == 'KSK' ) {
		require( 'kepsek_header.php' );
		?>
		<style>
			.chat_box {
				position: fixed;
				right: 20px;
				bottom: 0px;
				width: 250px;
			}
			
			.chat_body {
				background: white;
				height: 400px;
				padding: 5px 0px;
				overflow: scroll;
				overflow-x: hidden;
				display: none;
			}
			
			.chat_head,
			.msg_head {
				background: #f39c12;
				color: white;
				padding: 15px;
				font-weight: bold;
				cursor: pointer;
				border-radius: 5px 5px 0px 0px;
			}
			
			.msg_box {
				position: fixed;
				bottom: -5px;
				width: 250px;
				background: white;
				border-radius: 5px 5px 0px 0px;
				display: none;
			}
			
			.msg_head {
				background: #3498db;
			}
			
			.msg_body {
				background: white;
				height: 200px;
				font-size: 12px;
				padding: 15px;
				overflow: auto;
				overflow-x: hidden;
			}
			
			.msg_input {
				width: 100%;
				border: 1px solid white;
				border-top: 1px solid #DDDDDD;
				-webkit-box-sizing: border-box;
				/* Safari/Chrome, other WebKit */
				-moz-box-sizing: border-box;
				/* Firefox, other Gecko */
				box-sizing: border-box;
			}
			
			.close {
				float: right;
				cursor: pointer;
			}
			
			.minimize {
				float: right;
				cursor: pointer;
				padding-right: 5px;
			}
			
			.user_head_orangtua {
				position: relative;
				padding: 10px 10px;
			}
			
			.user_head_orangtua:hover {
				background: #f8f8f8;
				cursor: pointer;
			}
			
			.user_head_orangtua:before {
				position: absolute;
				background: #2ecc71;
				height: 10px;
				width: 10px;
				left: 10px;
				top: 15px;
				border-radius: 6px;
			}
			
			.user_head_guru {
				position: relative;
				padding: 10px 10px;
			}
			
			.user_head_guru:hover {
				background: #f8f8f8;
				cursor: pointer;
			}
			
			.user_head_guru:before {
				position: absolute;
				background: #2ecc71;
				height: 10px;
				width: 10px;
				left: 10px;
				top: 15px;
				border-radius: 6px;
			}
			
			.user {
				position: relative;
				padding: 10px 30px;
			}
			
			.user:hover {
				background: #f8f8f8;
				cursor: pointer;
			}
			
			.user:before {
				content: '';
				position: absolute;
				background: #2ecc71;
				height: 10px;
				width: 10px;
				left: 10px;
				top: 15px;
				border-radius: 6px;
			}
			
			.msg_a {
				position: relative;
				background: #FDE4CE;
				padding: 10px;
				min-height: 10px;
				margin-bottom: 5px;
				margin-right: 10px;
				border-radius: 5px;
			}
			
			.msg_a:before {
				content: "";
				position: absolute;
				width: 0px;
				height: 0px;
				border: 10px solid;
				border-color: transparent #FDE4CE transparent transparent;
				left: -20px;
				top: 7px;
			}
			
			.msg_b {
				background: #EEF2E7;
				padding: 10px;
				min-height: 15px;
				margin-bottom: 5px;
				position: relative;
				margin-left: 10px;
				border-radius: 5px;
				word-wrap: break-word;
			}
			
			.msg_b:after {
				content: "";
				position: absolute;
				width: 0px;
				height: 0px;
				border: 10px solid;
				border-color: transparent transparent transparent #EEF2E7;
				right: -20px;
				top: 7px;
			}
			
			.customMarker {
				position: absolute;
				cursor: pointer;
				background: #000000;
				width: 100px;
				height: 100px;
				/* -width/2 */
				margin-left: -50px;
				/* -height + arrow */
				margin-top: -110px;
				border-radius: 50%;
				padding: 0px;
			}
			
			.customMarker:after {
				content: "";
				position: absolute;
				bottom: -10px;
				left: 40px;
				border-width: 10px 10px 0;
				border-style: solid;
				border-color: #000000 transparent;
				display: block;
				width: 0;
			}
			
			.customMarker img {
				width: 90px;
				height: 90px;
				margin: 5px;
				border-radius: 50%;
			}
			
			.customMarkerGuru {
				position: absolute;
				cursor: pointer;
				background: #3AFF00;
				width: 100px;
				height: 100px;
				/* -width/2 */
				margin-left: -50px;
				/* -height + arrow */
				margin-top: -110px;
				border-radius: 50%;
				padding: 0px;
			}
			
			.customMarkerGuru:after {
				content: "";
				position: absolute;
				bottom: -10px;
				left: 40px;
				border-width: 10px 10px 0;
				border-style: solid;
				border-color: #3AFF00 transparent;
				display: block;
				width: 0;
			}
			
			.customMarkerGuru img {
				width: 90px;
				height: 90px;
				margin: 5px;
				border-radius: 50%;
			}
			
			.modal-dialog,
			.modal-content {
				/* 80% of window height */
				height: 95%;
			}
			
			.modal-body {
				/* 100% = dialog height, 120px = header + footer */
				max-height: calc(100% - 135px);
				overflow-y: scroll;
			}
		</style>
		<section id="container">
			<script>
				function load_notifikasi() {
					var jumlah_notif;
					var jumlah_pesan;
					$.ajax( {
						type: 'post',
						url: 'ajax_angka_notif.php',
						dataType: "json",
						success: function ( data_angka_notif ) {
							$( '.angka-notif' ).html( data_angka_notif.jumlah );
						}
					} );

					$.ajax( {
						type: 'post',
						url: 'ajax_angka_pesan.php',
						dataType: "json",
						success: function ( data_angka_pesan ) {
							$( '.angka-pesan' ).html( data_angka_pesan.jumlah );
						}
					} );

					$.ajax( {
						type: 'post',
						url: 'ajax_angka_notif.php',
						async: false,
						dataType: "json",
						success: function ( data_angka_notif ) {
							jumlah_notif = data_angka_notif.jumlah;
						}
					} );

					$.ajax( {
						type: 'post',
						url: 'ajax_angka_pesan.php',
						async: false,
						dataType: "json",
						success: function ( data_angka_pesan ) {
							jumlah_pesan = data_angka_pesan.jumlah;
						}
					} );

					$.ajax( {
						type: 'post',
						url: 'ajax_tampil_notif.php',
						data: {
							jumlah_notif: jumlah_notif
						},
						success: function ( data ) {
							$( '.tampil_notif' ).html( data );
						}
					} );

					$.ajax( {
						type: 'post',
						url: 'ajax_tampil_pesan.php',
						data: {
							jumlah_pesan: jumlah_pesan
						},
						success: function ( data ) {
							$( '.tampil_pesan' ).html( data );
						}
					} );
				}

				function telah_dibaca() {
					$.ajax( {
						type: 'post',
						url: 'ajax_telah_dibaca.php',
						success: function ( data ) {

						}
					} );
					load_notifikasi();
					return false;
				}

				function pesan_dibaca( id ) {
					$.ajax( {
						type: 'post',
						url: 'ajax_dibaca.php',
						data: {
							id: id
						},
						success: function ( data ) {

						}
					} );
					load_notifikasi();
				}
				load_notifikasi();
			</script>
			<!--header start-->
			<header class="header black-bg">
				<div class="sidebar-toggle-box">
					<div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
				</div>
				<!--logo start-->
				<a href="index.php" class="logo"><b>KEPALA <span>SEKOLAH</span></b></a>
				<!--logo end-->
				<div class="nav notify-row" id="top_menu">
					<!--  notification start -->
					<ul class="nav top-menu">

						<li id="header_inbox_bar" class="dropdown">
							<a data-toggle="dropdown" class="dropdown-toggle" href="index.html#"><i class="fa fa-bell-o"></i><span class="badge bg-theme angka-notif"></span></a>
							<ul class="dropdown-menu extended inbox tampil_notif">
							</ul>
						</li>

						<li id="header_inbox_bar" class="dropdown">
							<a data-toggle="dropdown" class="dropdown-toggle" href="index.html#"><i class="fa fa-envelope-o"></i><span class="badge bg-theme angka-pesan"></span></a>
							<ul class="dropdown-menu extended inbox tampil_pesan">

							</ul>
						</li>

					</ul>
					<!--  notification end -->
				</div>
				<div class="top-menu">
					<ul class="nav pull-right top-menu">
						<li>
							<a href="#ubah_pw" data-toggle="modal" class="logout" data-id="<?php echo $_SESSION['s_nuptk'];?>">Ubah Password</a>
						</li>
						<li><a class="logout" href="../logout.php">Logout</a>
						</li>
					</ul>
				</div>
			</header>
			
<!--			modal ubah password-->
			<div class="modal fade" id="ubah_pw" tabindex="-1" role="dialog" aria-labelledby="ubah" aria-hidden="true">
				<div class="modal-dialog" role="document">

					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<center>
								<h4 class="modal-title">Ubah Password</h4>
							</center>
						</div>
						<div class="modal-body">
							<div class="isi_ubah_password"></div>
						</div>

					</div>
				</div>
			</div>

			<div class="modal fade" id="konfirmasi" tabindex="-1" role="dialog" aria-labelledby="Konfimasi" aria-hidden="true">
				<div class="modal-dialog" role="document">

					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<center>
								<h4 class="modal-title">Konfirmasi</h4>
							</center>
						</div>
						<div class="modal-body">
							<div class="detail-konfirmasi"></div>
						</div>
						<div class="modal-footer">
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="konfirmasi_pilih" tabindex="-1" role="dialog" aria-labelledby="Konfimasi" aria-hidden="true">
				<div class="modal-dialog" role="document">

					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<center>
								<h4 class="modal-title">Konfirmasi</h4>
							</center>
						</div>
						<div class="modal-body">
							<div class="detail-konfirmasi-pilih"></div>
						</div>

					</div>
				</div>
			</div>

			<div class="modal fade" id="detail_siswa" tabindex="-1" role="dialog" aria-labelledby="detail" aria-hidden="true">
				<div class="modal-dialog" role="document">

					<!-- Modal content-->
					<div class="modal-content detail-siswa">
					</div>
				</div>
			</div>

			<script>
				
				//				ubah password modal
				$( document ).ready( function () {
					$( '#ubah_pw' ).on( 'show.bs.modal', function ( e ) {
						var idx = $( e.relatedTarget ).data( 'id' ); //harus tetap id, jika tidak akan data tak akan terambil
						//menggunakan fungsi ajax untuk pengambilan data
						$.ajax( {
							type: 'post',
							url: 'ajax_ubah_password.php',
							data: {
								nuptk: idx
							},
							success: function ( data ) {
								$( '.isi_ubah_password' ).html( data ); //menampilkan data ke dalam modal
							}
						} );
					} );
				} );
				
				$( document ).ready( function () {
					$( '#konfirmasi' ).on( 'show.bs.modal', function ( e ) {
						//harus tetap id, jika tidak akan data tak akan terambil
						//menggunakan fungsi ajax untuk pengambilan data
						$.ajax( {
							type: 'post',
							url: 'ajax_modal_konfirmasi.php',
							success: function ( data ) {
								$( '.detail-konfirmasi' ).html( data ); //menampilkan data ke dalam modal
								load_notifikasi();
							}
						} );
					} );
				} );

				$( document ).ready( function () {
					$( '#konfirmasi_pilih' ).on( 'show.bs.modal', function ( e ) {
						//harus tetap id, jika tidak akan data tak akan terambil
						//menggunakan fungsi ajax untuk pengambilan data
						var idx = $( e.relatedTarget ).data( 'id' );
						var id_status = $( e.relatedTarget ).data( 'status' );
						$.ajax( {
							type: 'post',
							url: 'ajax_pilih_notifikasi.php',
							data: {
								idNotifikasi: idx,
								idStatus: id_status
							},
							success: function ( data ) {
								$( '.detail-konfirmasi-pilih' ).html( data ); //menampilkan data ke dalam modal
								load_notifikasi();
							}
						} );
					} );
				} );

				$( document ).on( 'click', '.konfirmasi-ya', function () {
					//menampilkan jumlah status 1
					var idx = $( this ).data( 'id' );
					var waktu = $( this ).data( 'waktu' );
					var nis = $( this ).data( 'nis' );
					var pesan = $( this ).data( 'pesan' );
					$.ajax( {
						type: 'post',
						url: 'ajax_konfirmasi_ya.php',
						data: {
							idNotifikasi: idx,
							waktu: waktu,
							nis: nis,
							pesan: pesan
						},
						success: function ( data ) {
							load_konfirmasi();
						}
					} );
				} );

				$( document ).on( 'click', '.konfirmasi_pilih', function () {
					//menampilkan jumlah status 1
					var idx = $( this ).data( 'id' );
					var waktu = $( this ).data( 'waktu' );
					var nis = $( this ).data( 'nis' );
					var pesan = $( this ).data( 'pesan' );
					$.ajax( {
						type: 'post',
						url: 'ajax_konfirmasi_ya.php',
						data: {
							idNotifikasi: idx,
							waktu: waktu,
							nis: nis,
							pesan: pesan
						},
						success: function ( data ) {
							load_konfirmasi();
						}
					} );
				} );

				$( document ).on( 'click', '.konfirmasi-tidak', function () {
					//menampilkan jumlah status 1
					var idx = $( this ).data( 'id' );
					$.ajax( {
						type: 'post',
						url: 'ajax_konfirmasi_tidak.php',
						data: {
							idNotifikasi: idx,
						},
						success: function ( data ) {
							load_konfirmasi();
						}
					} );
				} );

				$( document ).on( 'click', '.ketemu', function () {
					//menampilkan jumlah status 1
					var waktu = $( this ).data( 'waktu' );
					var lat = $( this ).data( 'lat' );
					var longitude = $( this ).data( 'longitude' );
					$.ajax( {
						type: 'post',
						url: 'ajax_konfirmasi_ketemu.php',
						data: {
							waktu: waktu,
							lat: lat,
							longitude: longitude
						},
						success: function ( data ) {
							load_konfirmasi();
						}
					} );
				} );

				function load_konfirmasi() {
					$.ajax( {
						type: 'post',
						url: 'ajax_modal_konfirmasi.php',
						success: function ( data ) {
							$( '.detail-konfirmasi' ).html( data ); //menampilkan data ke dalam modal
						}
					} );
				}

				$( document ).ready( function () {
					$( '#detail_siswa' ).on( 'show.bs.modal', function ( e ) {
						var idx = $( e.relatedTarget ).data( 'id' );
						var latitude = $( e.relatedTarget ).data( 'latitude' );
						var longitude = $( e.relatedTarget ).data( 'longitude' );
						//harus tetap id, jika tidak akan data tak akan terambil
						//menggunakan fungsi ajax untuk pengambilan data
						$.ajax( {
							type: 'post',
							url: 'ajax_detail_siswa.php',
							data: {
								nis: idx,
							},
							success: function ( data ) {
								$( '.detail-siswa' ).html( data ); //menampilkan data ke dalam modal
								geocodeLatLng( geocoder, latitude, longitude );
							}
						} );
					} );
				} );

				function geocodeLatLng( geocoder, lat, lng ) {
					var latlng = {
						lat: parseFloat( lat ),
						lng: parseFloat( lng )
					};
					geocoder.geocode( {
						'location': latlng
					}, function ( results, status ) {
						if ( status === 'OK' ) {
							if ( results[ 0 ] ) {
								document.getElementById( 'lokasi_terakhir' ).innerHTML = results[ 0 ].formatted_address;
							} else {
								document.getElementById( 'lokasi_terakhir' ).innerHTML = 'Lokasi Tidak Ditemukan';
							}
						} else {
							document.getElementById( 'lokasi_terakhir' ).innerHTML = 'Lokasi Tidak Ditemukan';
						}
					} );
				}
			</script>
			<!--header end-->
			<!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
			<!--sidebar start-->
			<aside>
				<div id="sidebar" class="nav-collapse ">
					<!-- sidebar menu start-->
					<ul class="sidebar-menu" id="nav-accordion">
						<p class="centered"><a href="profile.html"><img src="../foto/guru/<?php echo $_SESSION['s_foto']; ?>" class="img-circle" width="80"></a>
						</p>
						<h5 class="centered">
							<?php echo $_SESSION['s_nama']; ?>
						</h5>
						<?php 
						if ( isset( $_GET[ 'menu' ] ) ) {
								$menu = $_GET[ 'menu' ];
								if ( $menu == 'pemantauan' ) {
									require( 'menu_pemantauan.php' );
								}
						} else {
							require( 'menu_dashboard.php' );
						}
						?>
					</ul>
					<!-- sidebar menu end-->
				</div>
			</aside>
			<!--sidebar end-->
			<!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
			<!--main content start-->

			<?php
			if ( isset( $_GET[ 'menu' ] ) ) {
				$menu = $_GET[ 'menu' ];
				if ( $menu == 'pemantauan' ) {
					require( 'tampil_pemantauan.php' );
				}
			} else {
				require( 'tampil_dashboard.php' );
			}
			?>

			<?php
			$query_ambil_data_guru = "SELECT `nuptk`,`nama`,foto FROM `tb_guru` where nuptk!='" . $_SESSION[ 's_nuptk' ] . "'";
			$result_ambil_data_guru = mysqli_query( $link, $query_ambil_data_guru );

			$query_ambil_data_orangtua = "SELECT `id_orangtua`,`nama`,foto FROM `tb_orangtua`";
			$result_ambil_data_orangtua = mysqli_query( $link, $query_ambil_data_orangtua );

			?>
			<div class="chat_box">
				<div class="chat_head"><i class="fa fa-comments-o"></i>&nbsp;&nbsp;&nbsp;CHAT</div>
				<div class="chat_body">
					<div class="user_head_guru"><strong><span class="fa fa-caret-square-o-down"></span>&nbsp;&nbsp;&nbsp;Guru</strong>
					</div>
					<div class="user_guru">
						<?php
						while ( $data_guru = mysqli_fetch_array( $result_ambil_data_guru ) ) {
							?>
						<div class="user" data-tipe="guru" data-id="<?php echo $data_guru['nuptk']; ?>" data-nama="<?php echo $data_guru['nama']; ?>" data-foto="<?php echo $data_guru['foto']; ?>">
							<?php echo $data_guru['nama']; ?>
						</div>
						<?php
						}
						?>
					</div>
					<div class="user_head_orangtua"><strong><span class="fa fa-caret-square-o-down"></span>&nbsp;&nbsp;&nbsp;Orangtua</strong>
					</div>
					<div class="user_orangtua">
						<?php
						while ( $data_orangtua = mysqli_fetch_array( $result_ambil_data_orangtua ) ) {
							?>
						<div class="user" data-tipe="orangtua" data-id="<?php echo $data_orangtua['id_orangtua']; ?>" data-nama="<?php echo $data_orangtua['nama']; ?>" data-foto="<?php echo $data_orangtua['foto']; ?>">
							<?php echo $data_orangtua['nama']; ?>
						</div>
						<?php
						}
						?>
					</div>
				</div>
			</div>

			<script>
				var total_popups = 0;
				//arrays of popups ids
				var popups = [];

				$( document ).on( 'click', '.user', function ( e ) {
					//menampilkan jumlah status 1
					var idx = $( this ).data( 'id' );
					var nama = $( this ).data( 'nama' );
					var foto = $( this ).data( 'foto' );
					var tipe = $( this ).data( 'tipe' );
					register_popup( idx, nama, foto, tipe );
				} );

				$( document ).on( 'click', '.msg_head', function ( e ) {
					var idx = $( this ).data( 'id' );
					$( '#' + idx + ' .msg_wrap' ).slideToggle( 'slow' );
				} );

				$( document ).on( 'click', '.chat_head', function ( e ) {
					$( '.chat_body' ).slideToggle( 'slow' );
				} );

				$( document ).on( 'click', '.user_head_guru', function ( e ) {
					$( '.user_guru' ).slideToggle( 'slow' );
					var icon = this.querySelector( 'span' );

					if ( icon.classList.contains( 'fa-caret-square-o-down' ) ) {
						icon.classList.remove( 'fa-caret-square-o-down' );
						icon.classList.add( 'fa-caret-square-o-right' );
					} else {
						icon.classList.remove( 'fa-caret-square-o-right' );
						icon.classList.add( 'fa-caret-square-o-down' );
					}
				} );

				$( document ).on( 'click', '.user_head_orangtua', function ( e ) {
					$( '.user_orangtua' ).slideToggle( 'slow' );
					var icon = this.querySelector( 'span' );

					if ( icon.classList.contains( 'fa-caret-square-o-down' ) ) {
						icon.classList.remove( 'fa-caret-square-o-down' );
						icon.classList.add( 'fa-caret-square-o-right' );
					} else {
						icon.classList.remove( 'fa-caret-square-o-right' );
						icon.classList.add( 'fa-caret-square-o-down' );
					}
				} );

				$( document ).on( 'keydown', '.msg_input', function ( e ) {
					var idx = $( this ).data( 'id' );
					if ( e.keyCode == 13 ) {
						e.preventDefault();
						var msg = $( this ).val();
						$( this ).val( '' );
						$.ajax( {
							type: 'post',
							url: 'ajax_kirim_pesan.php',
							data: {
								pesan: msg,
								id: idx
							},
							dataType: "json",
							success: function ( data ) {
								refreshChat( idx );
							}
						} );

					}

				} );

				function refreshChat( id ) {
					$.ajax( {
						type: 'post',
						url: 'ajax_refresh_pesan.php',
						data: {
							id: id
						},
						success: function ( data ) {
							$( '.msg_body_' + id ).html( data );
						}
					} );
				}

				Array.remove = function ( array, from, to ) {
					var rest = array.slice( ( to || from ) + 1 || array.length );
					array.length = from < 0 ? array.length + from : from;
					return array.push.apply( array, rest );
				};

				function close_popup( id ) {
					for ( var iii = 0; iii < popups.length; iii++ ) {

						if ( id == popups[ iii ] ) {
							Array.remove( popups, iii );
							document.getElementById( id ).style.display = "none";

							calculate_popups();

							return;
						}
					}
				}

				function register_popup( id, name, foto, tipe ) {
					var foto_baru;

					for ( var iii = 0; iii < popups.length; iii++ ) {
						//already registered. Bring it to front.

						if ( id == popups[ iii ] ) {
							//membuang popup
							Array.remove( popups, iii );
							//menambahkan popup ke array
							popups.unshift( id );

							calculate_popups();
							return;
						}
					}

					if ( tipe == 'guru' ) {
						foto_baru = '../foto/guru/' + foto;
					} else {
						foto_baru = '../foto/orangtua/' + foto;
					}

					var element = '<div class="msg_box" id="' + id + '">';
					element = element + '<div class="msg_head" data-id="' + id + '"><img src="' + foto_baru + '" class="img-circle" width="40" height="35"></img>&nbsp;&nbsp;&nbsp;' + name;
					element = element + '<div class="close"><a href="javascript:close_popup(\'' + id + '\');"><span class="fa fa-times"></span></a></div></div>';
					element = element + '<div class="msg_wrap">';
					element = element + '<div class="msg_body msg_body_' + id + '">';

					$.ajax( {
						type: 'post',
						url: 'ajax_ambil_pesan.php',
						async: false,
						data: {
							id: id
						},
						dataType: "json",
						success: function ( data ) {
							var jumlah_pesan = data.length;
							for ( var i = 0; i < jumlah_pesan; i++ ) {

								if ( id == data[ i ][ "id_pengirim" ] ) {
									element = element + '<div class="msg_a">' + data[ i ][ "isi_pesan" ] + '</div>';
								} else {
									element = element + '<div class="msg_b">' + data[ i ][ "isi_pesan" ] + '</div>';
								}
							}
						}
					} );

					element = element + '</div>';
					element = element + '<div class="msg_footer"><textarea class="msg_input" rows="4" data-id="' + id + '"></textarea>';
					element = element + '</div>';
					element = element + '</div>';
					element = element + '</div>';

					$( "body" ).append( element );

					popups.unshift( id );

					calculate_popups();
					pesan_dibaca( id );

				}

				function calculate_popups() {
					var width = window.innerWidth;
					if ( width < 540 ) {
						total_popups = 0;
					} else {
						width = width - 200;
						//320 is width of a single popup box
						total_popups = parseInt( width / 320 );
					}
					display_popups();

				}

				function display_popups() {
					var right = 300;

					var iii = 0;
					for ( iii; iii < total_popups; iii++ ) {
						if ( popups[ iii ] != undefined ) {
							var element = document.getElementById( popups[ iii ] );
							element.style.right = right + "px";
							right = right + 280;
							element.style.display = "block";
						}
					}

					for ( var jjj = iii; jjj < popups.length; jjj++ ) {
						var element = document.getElementById( popups[ jjj ] );
						element.style.display = "none";
					}
				}

				window.addEventListener( "resize", calculate_popups );
				window.addEventListener( "load", calculate_popups );
				//				window.setInterval( updateChatPerDetik, 5000 );

				//				function updateChatPerDetik() {
				//					var jumlah_popup = popups.length;
				//					for ( var i = 0; i < jumlah_popup; i++ ) {
				//						refreshChat( popups[ i ] );
				//					}
				//				}
			</script>
			<!-- page end-->

		</section>
		<?php
		require( 'kepsek_footer.php' );
	}
} else {
	echo( "<script> location.href ='../index.php';</script>" );
}

?>