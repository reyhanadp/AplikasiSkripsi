<section id="main-content">
	<section class="wrapper">
		<div class="row">
			<div class="col-sm-12">
				<section class="panel">
					<header class="panel-heading">
						<div class="col-md-12 col-xs-12 col-sm-12">
							<select id="cari_siswa" name="cari_murid" class="form-control">
								<option value="">Cari Siswa...</option>
								<?php
								$sql_cari_siswa = "SELECT `nis`,`nama` FROM `tb_siswa` WHERE `status` != 1";
								$result_cari_siswa = mysqli_query( $link, $sql_cari_siswa );
								while ( $data_cari_siswa = mysqli_fetch_array( $result_cari_siswa ) ) {
									?>
								<option value="<?php echo $data_cari_siswa['nis']; ?>">
									<?php echo $data_cari_siswa['nama']; ?>
								</option>
								<?php
								}
								?>
							</select>
						</div>
						<br>
					</header>
					<div class="panel-body">
						<div id="map"></div>
						<audio id="audiotag1" src="../audio/chess-chess1.mp3" preload="auto"></audio>
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
	var geocoder = null;
	var geofencing_polygon = [];
	var markersArray = [];
	var guruMarkerArray = [];


	//code cari siswa (sisi client)
	$( document ).ready( function () {

		$( "#cari_siswa" ).select2( {
			placeholder: "Cari Siswa"
		} );
		$( "#cari_siswa" ).on( "select2:select", function ( e ) {
			var selected_element = $( e.currentTarget );
			var select_val = selected_element.val();
			$.ajax( {
				type: 'post',
				url: 'ajax_lat_lng_siswa.php',
				data: {
					nis: select_val
				},
				dataType: "json",
				success: function ( data ) {
					var myLatlng = new google.maps.LatLng( data.lat, data.lng );
					if ( myLatlng == "(0, 0)" ) {
						alert( data.nama + " tidak ada di map!!" );
					} else {
						map.panTo( myLatlng )
					}


				}
			} );
		} );

	} );



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

		geocoder = new google.maps.Geocoder;
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

	function CustomMarker( latlng, map, imageSrc, nis ) {
		this.latlng_ = latlng;
		this.imageSrc = imageSrc;
		this.nis = nis;

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

			div.title = 'Siswa';
			var img = document.createElement( "img" );
			img.src = this.imageSrc;
			div.appendChild( img );
			var me = this;
			var nis = this.nis;
			google.maps.event.addDomListener( div, "click", function ( event ) {
				$( "#detail_siswa" ).modal();
				$.ajax( {
					type: 'post',
					url: 'ajax_detail_siswa.php',
					data: {
						nis: nis,
					},
					success: function ( data ) {
						$( '.detail-siswa' ).html( data ); //menampilkan data ke dalam modal
						geocodeLatLng( geocoder, latitude, longitude );
					}
				} );
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

	function CustomMarkerGuru( latlng, map, imageSrc ) {
		this.latlng_ = latlng;
		this.imageSrc = imageSrc;

		// Once the LatLng and text are set, add the overlay to the map.  This will
		// trigger a call to panes_changed which should in turn call draw.
		this.setMap( map );
	}

	CustomMarkerGuru.prototype = new google.maps.OverlayView();

	CustomMarkerGuru.prototype.draw = function () {
		// Check if the div has been created.
		//			alert(this.div_);
		var div = this.div_;

		if ( !div ) {
			// Create a overlay text DIV
			div = this.div_ = document.createElement( 'div' );
			// Create the DIV representing our CustomMarker
			div.className = "customMarkerGuru"

			div.title = 'Guru';
			var img = document.createElement( "img" );

			img.src = this.imageSrc;
			div.appendChild( img );
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

	CustomMarkerGuru.prototype.remove = function () {
		// Check if the overlay was on the map and needs to be removed.
		//					this.div_.parentNode.removeChild( this.div_ );
		//					this.div_ = null;
		if ( this.div_ ) {
			this.div_.parentNode.removeChild( this.div_ );
			this.div_ = null;
		}
	};

	CustomMarkerGuru.prototype.getPosition = function () {
		return this.latlng_;
	};

	function clearOverlays() {

		for ( var i = 0; i < markersArray.length; i++ ) {
			markersArray[ i ].setMap( null );
		}

		for ( var i = 0; i < guruMarkerArray.length; i++ ) {
			guruMarkerArray[ i ].setMap( null );
		}
	}

	function menampilkan_posisi_guru( position ) {
		var data = 'data_guru.php?lat=' + position.coords.latitude + '&longitude=' + position.coords.longitude;

		//Me guardo o direito a não explicar o óbvio, novamente
		$.get( data, {}, function ( data ) {
			$( data ).find( "marker" ).each(
				function () {
					var marker = $( this );

					var myLatLngGuru = new CustomMarkerGuru( new google.maps.LatLng( parseFloat( marker.attr( "lat" ) ), parseFloat( marker.attr( "lng" ) ) ), map, "../foto/guru/" + marker.attr( "foto" ) );


					guruMarkerArray.push( myLatLngGuru );
				} );
		} );
	}

	function notifikasiPopup() {
		if ( Notification.permission !== "granted" ) {
			Notification.requestPermission();
		} else {
			$.ajax( {
				type: 'post',
				url: 'ajax_popup.php',
				dataType: "json",
				success: function ( data ) {
					var data_notif = data.notif;
					var notifikasi = [];
					for ( var i = data_notif.length - 1; i >= 0; i-- ) {
						notifikasi[ i ] = new Notification( data_notif[ i ][ 'nama' ], {
							icon: "../foto/siswa/" + data_notif[ i ][ 'foto' ],
							body: data_notif[ i ][ 'pesan_notif' ],
						} );
						document.getElementById( 'audiotag1' ).play();
						setTimeout( function () {
							notifikasi[ i ].close();
						}, 5000 );
					};
				}
			} );
		}
	}

	function notifikasi_sms_gateway() {
		$.ajax( {
			type: 'post',
			url: 'ajax_ambil_guru_tanpa_smartphone.php',
			async: false,
			dataType: "json",
			success: function ( data_nuptk ) {
				var jml_nuptk = data_nuptk.length;
				for ( var k = 0; k < jml_nuptk; k++ ) {

					$.ajax( {
						type: 'post',
						url: 'ajax_ambil_id_notifikasi.php',
						async: false,
						data: {
							nuptk: data_nuptk[ k ][ "nuptk" ]
						},
						dataType: "json",
						success: function ( data_id_notifikasi ) {
							var jml_id_notifikasi = data_id_notifikasi.length;
							for ( var l = 0; l < jml_id_notifikasi; l++ ) {

								$.ajax( {
									type: 'post',
									url: 'ajax_kirim_sms.php',
									data: {
										nuptk: data_nuptk[ k ][ "nuptk" ],
										id_notifikasi: data_id_notifikasi[ l ][ "id_notifikasi" ],
										no_hp: data_nuptk[ k ][ "no_hp" ],
										lokasi: data_id_notifikasi[ l ][ "alamat" ],
										nama_siswa: data_id_notifikasi[ l ][ "nama" ],
										pesan: data_id_notifikasi[ l ][ "pesan_notif" ],
										kelas: data_id_notifikasi[ l ][ "kelas" ],
										tingkatan: data_id_notifikasi[ l ][ "tingkatan" ]

									},
									dataType: "json",
									success: function ( data ) {

									}
								} );
							}
						}
					} );
				}
			}
		} );
	}

	function load_notification() {
		var jumlah_notif;
		notifikasiPopup();

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
	}



	var i = 0;

	function updateMaps() {
		load_notification();
		notifikasi_sms_gateway();

		var cek_jarak_guru_siswa;
		if ( i != 0 ) {
			clearOverlays();
			i = i + 1;
		} else if ( i == 0 ) {
			i = i + 1;
		}

		navigator.geolocation.getCurrentPosition( menampilkan_posisi_guru );

		var data = 'data_siswa.php';

		var jml_polygon = geofencing_polygon.length;
		//Me guardo o direito a não explicar o óbvio, novamente
		$.get( data, {}, function ( data ) {
			$( data ).find( "marker" ).each(
				function () {
					var marker = $( this );

					var ubah_status = "tetap";

					var lat_lng = new google.maps.LatLng( parseFloat( marker.attr( "lat" ) ), parseFloat( marker.attr( "lng" ) ) );

					var overlay = new CustomMarker( lat_lng, map, "../foto/siswa/" + marker.attr( "foto" ), marker.attr( "nis" ) );

					markersArray.push( overlay );

					var myLatlng = new google.maps.LatLng( marker.attr( "lat" ), marker.attr( "lng" ) );


					for ( var q = 0; q < jml_polygon; q++ ) {
						var hasil = google.maps.geometry.poly.containsLocation( myLatlng, geofencing_polygon[ q ] ) ? "didalam" : "diluar";

						if ( hasil == "didalam" ) {
							break;
						}
					}

					var cek_jarak_guru_siswa = 1;

					$.ajax( {
						type: 'post',
						url: 'ajax_posisi_guru.php',
						async: false,
						dataType: "json",
						success: function ( data_posisi_guru ) {
							var jml_posisi_guru = data_posisi_guru.length;

							for ( var j = 0; j < jml_posisi_guru; j++ ) {

								var posisi_guru = new google.maps.LatLng( data_posisi_guru[ j ][ "latitude" ], data_posisi_guru[ j ][ "longitude" ] );

								var jarak = Math.round( google.maps.geometry.spherical.computeDistanceBetween( myLatlng, posisi_guru ) );

								if ( jarak < 10 ) {
									cek_jarak_guru_siswa = 0;
								}
							}
						}
					} );

					//								alert(marker.attr( "nama" )+" "+marker.attr( "cek_jadwal" ));
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
									} else if ( marker.attr( "baterai" ) > 15 ) {
										//													ubah_status = "0 jadi 2";
									}
								}
							} else if ( hasil == "didalam" ) {
								if ( marker.attr( "baterai" ) <= 15 ) {
									ubah_status = "0 jadi 3";
								} else if ( marker.attr( "baterai" ) > 15 ) {
									//													ubah_status = "0 jadi 2";
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
									} else if ( marker.attr( "baterai" ) > 15 ) {
										//													ubah_status = "2 jadi 0";
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
						} else if ( marker.attr( "cek_jadwal" ) == "no" ) {
							if ( hasil == "diluar" ) {
								if ( cek_jarak_guru_siswa == 1 ) {
									if ( marker.attr( "baterai" ) <= 15 ) {
										ubah_status = "2 jadi 4";
									} else if ( marker.attr( "baterai" ) > 15 ) {
										//													ubah_status = "2 jadi 0";
									}
								} else if ( cek_jarak_guru_siswa == 0 ) {
									if ( marker.attr( "baterai" ) <= 15 ) {
										ubah_status = "2 jadi 5";
									} else if ( marker.attr( "baterai" ) > 15 ) {
										ubah_status = "2 jadi 5";
									}
								}
							} else if ( hasil == "didalam" ) {
								if ( marker.attr( "baterai" ) <= 15 ) {
									ubah_status = "2 jadi 5";
								} else if ( marker.attr( "baterai" ) > 15 ) {
									ubah_status = "2 jadi 5";
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
									if ( marker.attr( "baterai" ) <= 15 ) {
										//													ubah_status = "3 jadi 4";
									} else if ( marker.attr( "baterai" ) > 15 ) {
										ubah_status = "3 jadi 0";
									}
								}
							} else if ( hasil == "didalam" ) {
								if ( marker.attr( "baterai" ) <= 15 ) {
									//													ubah_status = "3 jadi 4";
								} else if ( marker.attr( "baterai" ) > 15 ) {
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
						} else if ( marker.attr( "cek_jadwal" ) == "no" ) {
							if ( hasil == "diluar" ) {
								if ( cek_jarak_guru_siswa == 1 ) {
									if ( marker.attr( "baterai" ) <= 15 ) {
										//													ubah_status = "4 jadi 5";
									} else if ( marker.attr( "baterai" ) > 15 ) {
										ubah_status = "4 jadi 2";
									}
								} else if ( cek_jarak_guru_siswa == 0 ) {
									if ( marker.attr( "baterai" ) <= 15 ) {
										ubah_status = "4 jadi 5";
									} else if ( marker.attr( "baterai" ) > 15 ) {
										ubah_status = "4 jadi 5";
									}
								}
							} else if ( hasil == "didalam" ) {
								if ( marker.attr( "baterai" ) <= 15 ) {
									ubah_status = "4 jadi 5";
								} else if ( marker.attr( "baterai" ) > 15 ) {
									ubah_status = "4 jadi 5";
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
					} else if ( marker.attr( "status" ) == 6 ) {
						if ( marker.attr( "cek_jadwal" ) == "yes" ) {
							if ( hasil == "didalam" ) {
								if ( marker.attr( "baterai" ) <= 15 ) {
									ubah_status = "6 jadi 3";
								} else if ( marker.attr( "baterai" ) > 15 ) {
									ubah_status = "6 jadi 0";
								}
							}
						}
					}

					if ( ubah_status != "tetap" ) {

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
								load_notification();
							}
						} );
					}
				} );
		} );
	}
</script>