<?php
session_start();
if ( isset( $_SESSION[ 's_nuptk' ] ) ) {
	if ( $_SESSION[ 's_kode_jabatan' ] == 'BKS' ) {


		require( 'admin_header.php' );
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
		</style>
		<section id="container">
			
			<script>
				function load_notifikasi() {
					var jumlah_notif;
					var jumlah_pesan;

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
						url: 'ajax_angka_pesan.php',
						async: false,
						dataType: "json",
						success: function ( data_angka_pesan ) {
							jumlah_pesan = data_angka_pesan.jumlah;
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
			<!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
			<!--header start-->
			<header class="header black-bg">
				<div class="sidebar-toggle-box">
					<div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
				</div>
				<!--logo start-->
				<a href="index.html" class="logo"><b>AD<span>MIN</span></b></a>
				<!--logo end-->
				<div class="nav notify-row" id="top_menu">
					<!--  notification start -->
					<ul class="nav top-menu">
						<!-- settings start -->
						<!-- notification dropdown start-->
						<li id="header_inbox_bar" class="dropdown">
							<a data-toggle="dropdown" class="dropdown-toggle" href="index.html#"><i class="fa fa-envelope-o"></i><span class="badge bg-theme angka-pesan"></span></a>
							<ul class="dropdown-menu extended inbox tampil_pesan">

							</ul>
						</li>
						<!-- notification dropdown end -->
					</ul>
					<!--  notification end -->
				</div>
				<div class="top-menu">
					<ul class="nav pull-right top-menu">
						<li><a class="logout" href="../logout.php">Logout</a>
						</li>
					</ul>
				</div>
			</header>
			<!--header end-->
			<!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
			<!--sidebar start-->
			<aside>
				<div id="sidebar" class="nav-collapse ">
					<!-- sidebar menu start-->
					<ul class="sidebar-menu" id="nav-accordion">
						<p class="centered"><a href="#"><img src="../foto/guru/<?php echo $_SESSION['s_foto']; ?>" class="img-circle" width="80"></a>
						</p>
						<h5 class="centered">
							<?php echo $_SESSION['s_nama']; ?>
						</h5>
						<?php
						if ( isset( $_GET[ 'menu' ] ) ) {
							if ( ( ( $_GET[ 'action' ] == 'tampil' ) || ( $_GET[ 'action' ] == 'cari' ) ) ) {

								$menu = $_GET[ 'menu' ];
								if ( $menu == 'guru' ) {
									require( 'menu_guru.php' );
								} else if ( $menu == 'siswa' ) {
									require( 'menu_siswa.php' );
								} else if ( $menu == 'ortu' ) {
									require( 'menu_orangtua.php' );
								} else if ( $menu == 'jabatan' ) {
									require( 'menu_jabatan.php' );
								} else if ( $menu == 'kelas' ) {
									require( 'menu_kelas.php' );
								} else if ( $menu == 'geofencing' ) {
									require( 'menu_geofencing.php' );
								} else if ( $menu == 'device' ) {
									require( 'menu_device.php' );
								}
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
				$action = $_GET[ 'action' ];
				if ( ( $_GET[ 'menu' ] == 'guru' ) && ( $_GET[ 'action' ] == 'tampil' ) ) {
					//panggil file tampil data guru
					require( 'tampil_guru.php' );
				} else if ( ( $_GET[ 'menu' ] == 'siswa' ) && ( $_GET[ 'action' ] == 'tampil' ) ) {
					//panggil file tampil data guru
					require( 'tampil_siswa.php' );
				} else if ( ( $_GET[ 'menu' ] == 'ortu' ) && ( $_GET[ 'action' ] == 'tampil' ) ) {
					//panggil file tampil data guru
					require( 'tampil_orangtua.php' );
				} else if ( ( $_GET[ 'menu' ] == 'jabatan' ) && ( $_GET[ 'action' ] == 'tampil' ) ) {
					//panggil file tampil data guru
					require( 'tampil_jabatan.php' );
				} else if ( ( $_GET[ 'menu' ] == 'jabatan' ) && ( $_GET[ 'action' ] == 'cari' ) ) {
					//panggil file tampil data guru
					require( 'tampil_cari_jabatan.php' );
				} else if ( ( $_GET[ 'menu' ] == 'kelas' ) && ( $_GET[ 'action' ] == 'tampil' ) ) {
					//panggil file tampil data guru
					require( 'tampil_kelas.php' );
				} else if ( ( $_GET[ 'menu' ] == 'kelas' ) && ( $_GET[ 'action' ] == 'cari' ) ) {
					//panggil file tampil data guru
					require( 'tampil_cari_kelas.php' );
				} else if ( ( $_GET[ 'menu' ] == 'geofencing' ) && ( $_GET[ 'action' ] == 'tampil' ) ) {
					//panggil file tampil data guru
					require( 'tampil_geofencing.php' );
				} else if ( ( $_GET[ 'menu' ] == 'device' ) && ( $_GET[ 'action' ] == 'tampil' ) ) {
					//panggil file tampil data guru
					require( 'tampil_device.php' );
				}
			} else {
				require( 'tampil_dashboard.php' );
			}
			?>
			<!--main content end-->
			<!--footer start-->
			<?php
			$query_ambil_data_guru = "SELECT `nuptk`,`nama`,foto FROM `tb_guru` where nuptk!='".$_SESSION[ 's_nuptk' ]."'";
			$result_ambil_data_guru = mysqli_query( $link, $query_ambil_data_guru );

			$query_ambil_data_orangtua = "SELECT `id_orangtua`,`nama`,foto FROM `tb_orangtua`";
			$result_ambil_data_orangtua = mysqli_query( $link, $query_ambil_data_orangtua );

			?>
			<div class="chat_box">
				<div class="chat_head">CHAT</div>
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
			<!--footer end-->
		</section>
		<!-- js placed at the end of the document so the pages load faster -->
		<?php
		require( 'admin_footer.php' );
	}
} else {
	echo( "<script> location.href ='../index.php';</script>" );
}

?>