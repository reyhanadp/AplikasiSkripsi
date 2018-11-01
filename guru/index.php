<?php
session_start();
if ( isset( $_SESSION[ 's_nuptk' ] ) ) {
	if ( $_SESSION[ 's_kode_jabatan' ] != 'BKS' && $_SESSION[ 's_kode_jabatan' ] != 'KSK' ) {
		require( 'guru_header.php' );
		?>
		<style>
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
			<!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
			<!--header start-->
			<script>
				var jumlah_notif;
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
					url: 'ajax_angka_notif.php',
					async: false,
					dataType: "json",
					success: function ( data_angka_notif ) {
						jumlah_notif = data_angka_notif.jumlah;
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
			</script>
			<header class="header black-bg">
				<div class="sidebar-toggle-box">
					<div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
				</div>
				<!--logo start-->
				<a href="index.php" class="logo"><b>GU<span>RU</span></b></a>
				<!--logo end-->
				<div class="nav notify-row" id="top_menu">
					<!--  notification start -->
					<ul class="nav top-menu">

						<li id="header_inbox_bar" class="dropdown">
							<a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
              <i class="fa fa-bell-o"></i>
              <span class="badge bg-theme angka-notif"></span>
              </a>
						


							<ul class="dropdown-menu extended inbox tampil_notif">
							</ul>
						</li>
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

			<script>
				$( document ).ready( function () {
					$( '#konfirmasi' ).on( 'show.bs.modal', function ( e ) {
						//harus tetap id, jika tidak akan data tak akan terambil
						//menggunakan fungsi ajax untuk pengambilan data
						$.ajax( {
							type: 'post',
							url: 'ajax_modal_konfirmasi.php',
							success: function ( data ) {
								$( '.detail-konfirmasi' ).html( data ); //menampilkan data ke dalam modal
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
			</script>
			<!--header end-->
			<!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
			<!--sidebar start-->
			<aside>
				<div id="sidebar" class="nav-collapse ">
					<!-- sidebar menu start-->
					<ul class="sidebar-menu baterai" id="nav-accordion">
					</ul>
					<!-- sidebar menu end-->
				</div>
			</aside>

			<script>
				var refresh_baterai = function () {
					$.ajax( {
						type: 'post',
						url: 'ajax_baterai.php',
						success: function ( data ) {
							$( '.baterai' ).html( data );
						}
					} );
				}
				refresh_baterai();
				setInterval( refresh_baterai, 30000 );
			</script>
			<!--sidebar end-->
			<!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
			<!--main content start-->
			<section id="main-content">
				<section class="wrapper">
					<div class="row mt">
						<div class="col-sm-12">
							<section class="panel">
								<div class="panel-body">
									<div id="map"></div>
								</div>
							</section>
						</div>
					</div>
					<!-- page end-->
				</section>
				<!-- /wrapper -->
			</section>
			<!--main content end-->
			<!--footer start-->

			<!--footer end-->
			<script type="text/javascript">
				var map = null;
				var infoWindow = null;
				var geofencing_polygon = [];
				var markersArray = [];

				google.setOnLoadCallback( initMap );

				function initMap() {
					// The location of Uluru
					var myLatlng = new google.maps.LatLng( -6.930447, 107.654425 );
					var myOptions = {
						zoom: 19,
						center: myLatlng,
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						disableDefaultUI: false,
						zoomControl: true
					}
					map = new google.maps.Map( document.getElementById( "map" ),
						myOptions );

					infoWindow = new google.maps.InfoWindow;

					$.ajax( {
						type: 'post',
						url: 'ajax_geofencing.php',
						async: false,
						dataType: "json",
						success: function ( data_geofencing ) {
							var jml_geofencing = data_geofencing.length;

							if ( jml_geofencing != 0 ) {
								for ( var i = 0; i < jml_geofencing; i++ ) {
									$.ajax( {
										type: 'post',
										url: 'ajax_koordinat.php',
										async: false,
										data: {
											id_geofencing: data_geofencing[ i ][ "id_geofencing" ]
										},
										dataType: "json",
										success: function ( data_koordinat ) {
											var jmlKoordinat = data_koordinat.length;

											var triangleCoords = [];
											for ( var j = 0; j < jmlKoordinat; j++ ) {
												triangleCoords.push( {
													lat: parseFloat( data_koordinat[ j ][ "latitude" ] ),
													lng: parseFloat( data_koordinat[ j ][ "longitude" ] )
												} );


											}
											geofencing_polygon[ i ] = new google.maps.Polygon( {
												paths: triangleCoords,
												strokeColor: '#FF0000',
												strokeOpacity: 0.8,
												strokeWeight: 3,
												fillColor: '#FF0000',
												fillOpacity: 0.35

											} );

											geofencing_polygon[ i ].setMap( map );
										}
									} );
								}
							}
						}
					} );
					updateMaps();
					window.setInterval( updateMaps, 10000 );
				}

				function CustomMarker( latlng, map, imageSrc ) {
					this.latlng_ = latlng;
					this.imageSrc = imageSrc;

					// Once the LatLng and text are set, add the overlay to the map.  This will
					// trigger a call to panes_changed which should in turn call draw.
					this.setMap( map );
				}

				CustomMarker.prototype = new google.maps.OverlayView();

				CustomMarker.prototype.draw = function () {
					// Check if the div has been created.
					var div = this.div_;
					if ( !div ) {
						// Create a overlay text DIV
						div = this.div_ = document.createElement( 'div' );
						// Create the DIV representing our CustomMarker
						div.className = "customMarker"


						var img = document.createElement( "img" );
						img.src = this.imageSrc;
						div.appendChild( img );
						var me = this;
						google.maps.event.addDomListener( div, "click", function ( event ) {
							google.maps.event.trigger( me, "click" );
						} );

						// Then add the overlay to the DOM
						var panes = this.getPanes();
						panes.overlayImage.appendChild( div );
					}

					// Position the overlay 
					var point = this.getProjection().fromLatLngToDivPixel( this.latlng_ );
					if ( point ) {
						div.style.left = point.x + 'px';
						div.style.top = point.y + 'px';
					}
				};

				CustomMarker.prototype.remove = function () {
					// Check if the overlay was on the map and needs to be removed.
					if ( this.div_ ) {
						this.div_.parentNode.removeChild( this.div_ );
						this.div_ = null;
					}
				};

				CustomMarker.prototype.getPosition = function () {
					return this.latlng_;
				};

				function clearOverlays() {
					for ( var i = 0; i < markersArray.length; i++ ) {
						markersArray[ i ].setMap( null );
					}
				}



				var i = 0;

				function updateMaps() {
					var cek_jarak_guru_siswa;
					if ( i != 0 ) {
						clearOverlays();
					} else {
						i = i + 1;
					}
					var data = 'data.php';

					var jml_polygon = geofencing_polygon.length;
					//Me guardo o direito a não explicar o óbvio, novamente
					$.get( data, {}, function ( data ) {
						$( data ).find( "marker" ).each(
							function () {
								var marker = $( this );

								var ubah_status = "tetap";

								var lat_lng = new google.maps.LatLng( parseFloat( marker.attr( "lat" ) ), parseFloat( marker.attr( "lng" ) ) );

								var overlay = new CustomMarker( lat_lng, map, "../foto/siswa/" + marker.attr( "foto" ) );

								markersArray.push( overlay );

								var myLatlng = new google.maps.LatLng( marker.attr( "lat" ), marker.attr( "lng" ) );


								for ( var q = 0; q < jml_polygon; q++ ) {
									var hasil = google.maps.geometry.poly.containsLocation( myLatlng, geofencing_polygon[ q ] ) ? "didalam" : "diluar";

									if ( hasil == "didalam" ) {
										break;
									}
								}

								$.ajax( {
									type: 'post',
									url: 'ajax_jarak_guru_siswa.php',
									async: false,
									data: {
										lat_murid: marker.attr( "lat" ),
										longitude_murid: marker.attr( "lng" )
									},
									dataType: "json",
									success: function ( data ) {
										cek_jarak_guru_siswa = data.cek_jarak;
									}
								} );

								if ( marker.attr( "status" ) == 0 ) {
									if ( marker.attr( "cek_jadwal" ) == "yes" ) {
										if ( hasil == "diluar" ) {
											if ( cek_jarak_guru_siswa == 1 ) {
												if ( marker.attr( "baterai" ) <= 15 ) {
													ubah_status = "0 jadi 4";
												} else if ( marker.attr( "baterai" ) > 15 ) {
													ubah_status = "0 jadi 2";
												}
											} else if ( cek_jarak_guru_siswa == 0 ) {
												if ( marker.attr( "baterai" ) <= 15 ) {
													ubah_status = "0 jadi 3";
												}
											}

										} else if ( hasil == "didalam" ) {
											if ( marker.attr( "baterai" ) <= 15 ) {
												ubah_status = "0 jadi 3";
											}
										}
									} else if ( marker.attr( "cek_jadwal" ) == "no" ) {
										ubah_status = "0 jadi 5";
									}
								} else if ( marker.attr( "status" ) == 2 ) {
									if ( marker.attr( "cek_jadwal" ) == "yes" ) {
										if ( hasil == "diluar" ) {
											if ( cek_jarak_guru_siswa == 1 ) {
												if ( marker.attr( "baterai" ) <= 15 ) {
													ubah_status = "2 jadi 4";
												}
											} else if ( cek_jarak_guru_siswa == 0 ) {
												if ( marker.attr( "baterai" ) <= 15 ) {
													ubah_status = "2 jadi 3";
												} else if ( marker.attr( "baterai" ) > 15 ) {
													ubah_status = "2 jadi 0";
												}
											}
										} else if ( hasil == "didalam" ) {
											if ( marker.attr( "baterai" ) <= 15 ) {
												ubah_status = "2 jadi 3";
											} else if ( marker.attr( "baterai" ) > 15 ) {
												ubah_status = "2 jadi 0";
											}
										}
									}
								} else if ( marker.attr( "status" ) == 3 ) {
									if ( marker.attr( "cek_jadwal" ) == "yes" ) {
										if ( hasil == "diluar" ) {
											if ( cek_jarak_guru_siswa == 1 ) {
												if ( marker.attr( "baterai" ) <= 15 ) {
													ubah_status = "3 jadi 4";
												} else if ( marker.attr( "baterai" ) > 15 ) {
													ubah_status = "3 jadi 2";
												}
											} else if ( cek_jarak_guru_siswa == 0 ) {
												if ( marker.attr( "baterai" ) > 15 ) {
													ubah_status = "3 jadi 0";
												}
											}
										} else if ( hasil == "didalam" ) {
											if ( marker.attr( "baterai" ) > 15 ) {
												ubah_status = "3 jadi 0";
											}
										}
									} else if ( marker.attr( "cek_jadwal" ) == "no" ) {
										ubah_status = "3 jadi 5";
									}
								} else if ( marker.attr( "status" ) == 4 ) {
									if ( marker.attr( "cek_jadwal" ) == "yes" ) {
										if ( hasil == "diluar" ) {
											if ( cek_jarak_guru_siswa == 1 ) {
												if ( marker.attr( "baterai" ) > 15 ) {
													ubah_status = "4 jadi 2";
												}
											} else if ( cek_jarak_guru_siswa == 0 ) {
												if ( marker.attr( "baterai" ) <= 15 ) {
													ubah_status = "4 jadi 3";
												} else if ( marker.attr( "baterai" ) > 15 ) {
													ubah_status = "4 jadi 0";
												}
											}
										} else if ( hasil == "didalam" ) {
											if ( marker.attr( "baterai" ) <= 15 ) {
												ubah_status = "4 jadi 3";
											} else if ( marker.attr( "baterai" ) > 15 ) {
												ubah_status = "4 jadi 0";
											}
										}
									}
								} else if ( marker.attr( "status" ) == 5 ) {
									if ( marker.attr( "cek_jadwal" ) == "yes" ) {
										if ( hasil == "didalam" ) {
											if ( marker.attr( "baterai" ) <= 15 ) {
												ubah_status = "5 jadi 3";
											} else if ( marker.attr( "baterai" ) > 15 ) {
												ubah_status = "5 jadi 0";
											}
										}
									}
								}

								$.ajax( {
									type: 'post',
									url: 'ajax_update_status.php',
									async: false,
									data: {
										nis: marker.attr( "nis" ),
										kelas: marker.attr( "kelas" ),
										nama: marker.attr( "nama" ),
										perintah: ubah_status
									},
									success: function ( data ) {
										//										load_notification();
									}
								} );
							} );
					} );

				}
			</script>
		</section>
		<!-- js placed at the end of the document so the pages load faster -->
		<?php
		require( 'guru_footer.php' );
	}
} else {
	echo( "<script> location.href ='../index.php';</script>" );
}

?>