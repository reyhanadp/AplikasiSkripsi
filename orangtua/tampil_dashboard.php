<section id="main-content">
	<section class="wrapper">
		<div class="row">
			<div class="col-sm-12">
				<section class="panel">
					<header class="panel-heading">

						<div class="col-md-10">
							<select id="cari_siswa" name="cari_murid" class="form-control">
								<option value="">Cari Siswa...</option>
								<?php
								$sql_cari_siswa = "SELECT `nis`,`nama` FROM `tb_siswa` WHERE `status` != 1 AND id_orangtua = '" . $_SESSION[ 's_id_orangtua' ] . "'";
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
						<!--								<div class="col-md-1"></div>-->
						<div class="col-md-2">
							<button type="submit" onClick="location.href='index.php?menu=geofencing';" class="btn btn-round btn-primary">Setting Geofencing</button>
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
	var geofencing_polygon_orangtua = [];
	var geofencing_polygon_sekolah = [];
	var markersArray = [];
	var orangtuaMarkerArray = [];
	var geofencing_circle = [];

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
			data: {
				jenis: 'orangtua'
			},
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

								if ( data_geofencing[ i ][ "bentuk" ] == "circle" ) {
									geofencing_circle[ b ] = new google.maps.Circle( {
										strokeColor: '#FF0000',
										strokeOpacity: 0.8,
										strokeWeight: 2,
										fillColor: '#FF0000',
										fillOpacity: 0.35,
										id_geofencing: data_geofencing[ i ][ "id_geofencing" ],
										map: map,
										center: {
											lat: parseFloat( data_koordinat[ 0 ][ "latitude" ] ),
											lng: parseFloat( data_koordinat[ 0 ][ "longitude" ] )
										},
										radius: parseFloat( data_koordinat[ 0 ][ "radius" ] ),
										title: data_geofencing[ i ][ "nama" ]
									} );

									geofencing_circle[ b ].addListener( 'mouseover', function () {
										this.getMap().getDiv().setAttribute( 'title', this.get( 'title' ) );
									} );

									geofencing_circle[ b ].addListener( 'mouseout', function () {
										this.getMap().getDiv().removeAttribute( 'title' );
									} );

									b++;
								} else {
									var jmlKoordinat = data_koordinat.length;

									var triangleCoords = [];
									for ( var j = 0; j < jmlKoordinat; j++ ) {
										triangleCoords.push( {
											lat: parseFloat( data_koordinat[ j ][ "latitude" ] ),
											lng: parseFloat( data_koordinat[ j ][ "longitude" ] )
										} );
									}
									geofencing_polygon_orangtua[ i ] = new google.maps.Polygon( {
										paths: triangleCoords,
										strokeColor: '#0000FF',
										strokeOpacity: 0.8,
										strokeWeight: 3,
										fillColor: '#FF0000',
										fillOpacity: 0.35,
									} );

									geofencing_polygon_orangtua[ i ].setMap( map );
								}


							}
						} );
					}


				}
			}
		} );

		$.ajax( {
			type: 'post',
			url: 'ajax_geofencing.php',
			async: false,
			data: {
				jenis: 'sekolah'
			},
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
								geofencing_polygon_sekolah[ i ] = new google.maps.Polygon( {
									paths: triangleCoords,
									strokeColor: '#FF0000',
									strokeOpacity: 0.8,
									strokeWeight: 3,
									fillColor: '#FF0000',
									fillOpacity: 0.35,
								} );

								geofencing_polygon_sekolah[ i ].setMap( map );

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

	function CustomMarkerOrangtua( latlng, map, imageSrc ) {
		this.latlng_ = latlng;
		this.imageSrc = imageSrc;

		// Once the LatLng and text are set, add the overlay to the map.  This will
		// trigger a call to panes_changed which should in turn call draw.
		this.setMap( map );
	}

	CustomMarkerOrangtua.prototype = new google.maps.OverlayView();

	CustomMarkerOrangtua.prototype.draw = function () {
		// Check if the div has been created.
		//			alert(this.div_);
		var div = this.div_;

		if ( !div ) {
			// Create a overlay text DIV
			div = this.div_ = document.createElement( 'div' );
			// Create the DIV representing our CustomMarker
			div.className = "customMarkerOrangtua"


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

	CustomMarkerOrangtua.prototype.remove = function () {
		// Check if the overlay was on the map and needs to be removed.
		//					this.div_.parentNode.removeChild( this.div_ );
		//					this.div_ = null;
		if ( this.div_ ) {
			this.div_.parentNode.removeChild( this.div_ );
			this.div_ = null;
		}
	};

	CustomMarkerOrangtua.prototype.getPosition = function () {
		return this.latlng_;
	};

	function clearOverlays() {
		for ( var i = 0; i < markersArray.length; i++ ) {
			markersArray[ i ].setMap( null );
		}

		for ( var i = 0; i < orangtuaMarkerArray.length; i++ ) {
			orangtuaMarkerArray[ i ].setMap( null );
		}
		markersArray = [];
		orangtuaMarkerArray = [];
	}

	function menampilkan_posisi_orangtua( position ) {
		var data = 'data_orangtua.php?lat=' + position.coords.latitude + '&longitude=' + position.coords.longitude;

		//Me guardo o direito a não explicar o óbvio, novamente
		$.get( data, {}, function ( data ) {
			$( data ).find( "marker" ).each(
				function () {
					var marker = $( this );

					var myLatLngOrangtua = new CustomMarkerOrangtua( new google.maps.LatLng( parseFloat( marker.attr( "lat" ) ), parseFloat( marker.attr( "lng" ) ) ), map, "../foto/orangtua/" + marker.attr( "foto" ) );


					orangtuaMarkerArray.push( myLatLngOrangtua );
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

		if ( i != 0 ) {
			clearOverlays();
			i = i + 1;
		} else if ( i == 0 ) {
			i = i + 1;
		}

		navigator.geolocation.getCurrentPosition( menampilkan_posisi_orangtua );

		var data = 'data_siswa.php';

		var jml_polygon = geofencing_polygon_orangtua.length;
		//Me guardo o direito a não explicar o óbvio, novamente
		$.get( data, {}, function ( data ) {
			$( data ).find( "marker" ).each(
				function () {
					var marker = $( this );

					var ubah_status = "tetap";

					var lat_lng = new google.maps.LatLng( parseFloat( marker.attr( "lat" ) ), parseFloat( marker.attr( "lng" ) ) );

					var overlay = new CustomMarker( lat_lng, map, "../foto/siswa/" + marker.attr( "foto" ) );

					markersArray.push( overlay );


				} );
		} );

	}
</script>