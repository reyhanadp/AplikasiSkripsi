<section id="main-content">
	<section class="wrapper">
		<div class="row">
			<div class="col-sm-12">
				<section class="panel">
					<header class="panel-heading">

						<div class="col-md-10">
							Data Geofencing
						</div>
						<div class="col-md-1">
							<button class="btn btn-round btn-primary" id="save-button">Save</button>
						</div>
						<div class="col-md-1">
							<button class="btn btn-round btn-primary" id="delete-button" disabled>Delete</button>
						</div>
						<br>

					</header>
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

<script type="text/javascript">
	var drawingManager;
	var selectedShape;
	var colors = [ '#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082' ];
	var selectedColor;
	var colorButtons = {};
	var geofencingDatabase;
	var map; //= new google.maps.Map(document.getElementById('map'), {
	// these must have global refs too!:
	var placeMarkers = [];
	var button = document.getElementById( "delete-button" );
	var button_save = document.getElementById( "save-button" );
	var all_overlays = [];
	var input;
	var searchBox;
	var curposdiv;
	var curseldiv;
	var geofencing_polygon = [];
	var geofencing_rectangle = [];

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

		var polyOptions = {
			strokeWeight: 0,
			fillOpacity: 0.45,
			editable: true
		};



		$.ajax( {
			type: 'post',
			url: 'ajax_jumlah_geofencing.php',
			async: false,
			data: {
				jenis: 'sekolah'
			},
			dataType: "json",
			success: function ( data ) {
				var jmlGeofencing = data.length;
				var b = 0;
				var c = 0;

				//variabel untuk menampung tabel yang akan digenerasika
				if ( jmlGeofencing != 0 ) {
					for ( var a = 0; a < jmlGeofencing; a++ ) {

						$.ajax( {
							type: 'post',
							url: 'ajax_lokasi.php',
							async: false,
							data: {
								jenis: 'sekolah',
								id_geofencing: data[ a ][ "id_geofencing" ]
							},
							dataType: "json",
							success: function ( data_koordinat ) {
								var jmlKoordinat = data_koordinat.length;

								//validasi polygon atau rectangle
								if ( data[ a ][ "bentuk" ] == "polygon" ) {
									var triangleCoords = [];
									for ( var i = 0; i < jmlKoordinat; i++ ) {
										triangleCoords.push( {
											lat: parseFloat( data_koordinat[ i ][ "latitude" ] ),
											lng: parseFloat( data_koordinat[ i ][ "longitude" ] )
										} );
									}

									geofencing_polygon[ b ] = new google.maps.Polygon( {
										paths: triangleCoords,
										strokeColor: '#FF0000',
										strokeOpacity: 0.8,
										strokeWeight: 3,
										fillColor: '#FF0000',
										fillOpacity: 0.35,
										id_geofencing: data[ a ][ "id_geofencing" ],
										map: map
									} );

									geofencing_polygon[ b ].addListener( 'click', function ( event ) {
										clearSelection();
										this.setEditable( true );
										selectedShape = this;
										button.disabled = !button.disabled;
									} );
									b++;
								} else if ( data[ a ][ "bentuk" ] == "rectangle" ) {
									geofencing_rectangle[ c ] = new google.maps.Rectangle( {
										strokeColor: '#FF0000',
										strokeOpacity: 0.8,
										strokeWeight: 2,
										fillColor: '#FF0000',
										fillOpacity: 0.35,
										id_geofencing: data[ a ][ "id_geofencing" ],
										map: map,
										bounds: {
											north: parseFloat( data_koordinat[ 0 ][ "latitude" ] ),
											south: parseFloat( data_koordinat[ 2 ][ "latitude" ] ),
											east: parseFloat( data_koordinat[ 1 ][ "longitude" ] ),
											west: parseFloat( data_koordinat[ 3 ][ "longitude" ] )
										}
									} );

									geofencing_rectangle[ c ].addListener( 'click', function ( event ) {
										clearSelection();
										this.setEditable( true );
										selectedShape = this;
										button.disabled = !button.disabled;
									} );

									c++;
								}
							}
						} );

					}
				}
			}
		} );

		//		alert(geofencing_polygon[0].getPath().getAt(0).lat());
		infoWindow = new google.maps.InfoWindow;

		drawingManager = new google.maps.drawing.DrawingManager( {
			//			drawingMode: google.maps.drawing.OverlayType.NULL,
			markerOptions: {
				draggable: true,
				editable: true,
			},
			polylineOptions: {
				editable: true
			},
			drawingControlOptions: {
				position: google.maps.ControlPosition.TOP_CENTER,
				drawingModes: [ 'polygon', 'rectangle' ]
			},
			rectangleOptions: polyOptions,
			circleOptions: polyOptions,
			polygonOptions: polyOptions,
			map: map
		} );



		//		google.maps.event.addListener( drawingManager, 'polygoncomplete', function ( polygon ) {
		//			var coordinates = ( polygon.getPath().getArray() );
		//			console.log( coordinates );
		//		} );

		button_save.addEventListener( 'click', function ( event ) {

			var konfirmasi = confirm( "Apakah Anda Yakin Menyimpan Geofencing?" );

			if ( konfirmasi == true ) {
				var panjang_polygon = geofencing_polygon.length;
				var panjang_rectangle = geofencing_rectangle.length;

				for ( var i = 0; i < panjang_polygon; i++ ) {
					if ( geofencing_polygon[ i ].getMap() != null ) {

						$.ajax( {
							type: 'post',
							url: 'ajax_hapus_koordinat.php',
							async: false,
							data: {
								jenis: 'sekolah',
								id_geofencing: geofencing_polygon[ i ].id_geofencing
							},
							dataType: "json",
							success: function ( data_hapus_koordinat ) {
								for ( var j = 0; j < geofencing_polygon[ i ].getPath().getLength(); j++ ) {
									$.ajax( {
										type: 'post',
										url: 'ajax_simpan_koordinat.php',
										async: false,
										data: {
											jenis: 'poly',
											lat: geofencing_polygon[ i ].getPath().getAt( j ).lat(),
											lng: geofencing_polygon[ i ].getPath().getAt( j ).lng(),
											id_geofencing: geofencing_polygon[ i ].id_geofencing
										},
										dataType: "json",
										success: function ( data ) {

										}
									} );
								}
							}
						} );
					} else if ( geofencing_polygon[ i ].getMap() == null ) {
						$.ajax( {
							type: 'post',
							url: 'ajax_ubah_status_geofencing.php',
							async: false,
							data: {
								jenis: 'sekolah',
								id_geofencing: geofencing_polygon[ i ].id_geofencing
							},
							dataType: "json",
							success: function ( data_hapus_koordinat ) {

							}
						} );
					}
				}

				for ( var i = 0; i < panjang_rectangle; i++ ) {
					if ( geofencing_rectangle[ i ].getMap() != null ) {
						$.ajax( {
							type: 'post',
							url: 'ajax_hapus_koordinat.php',
							async: false,
							data: {
								jenis: 'sekolah',
								id_geofencing: geofencing_rectangle[ i ].id_geofencing
							},
							dataType: "json",
							success: function ( data_hapus_koordinat ) {

								$.ajax( {
									type: 'post',
									url: 'ajax_simpan_koordinat.php',
									async: false,
									data: {
										jenis: 'rectangle',
										ne_lat: geofencing_rectangle[i].getBounds().getNorthEast().lat(),
										ne_lng: geofencing_rectangle[i].getBounds().getNorthEast().lng(),
										sw_lat: geofencing_rectangle[i].getBounds().getSouthWest().lat(),
										sw_lng: geofencing_rectangle[i].getBounds().getSouthWest().lng(),
										id_geofencing: geofencing_rectangle[i].id_geofencing
									},
									dataType: "json",
									success: function ( data ) {

									}
								} );

							}
						} );
					} else if ( geofencing_rectangle[ i ].getMap() == null ) {
						$.ajax( {
							type: 'post',
							url: 'ajax_ubah_status_geofencing.php',
							async: false,
							data: {
								jenis: 'sekolah',
								id_geofencing: geofencing_rectangle[ i ].id_geofencing
							},
							dataType: "json",
							success: function ( data_hapus_koordinat ) {

							}
						} );
					}
				}

				var panjang_shape = all_overlays.length;
				var bentuk;
				for ( var i = 0; i < panjang_shape; i++ ) {
					var shape_baru = all_overlays[ i ].overlay;

					if ( typeof shape_baru.getPath == 'function' ) {
						bentuk = 'polygon';
					} else if ( typeof shape_baru.getBounds == 'function' ) {
						bentuk = 'rectangle';
					}


					$.ajax( {
						type: 'post',
						url: 'ajax_simpan_geofencing.php',
						async: false,
						data: {
							jenis: 'sekolah',
							nama: all_overlays[ i ].nama,
							bentuk: bentuk
						},
						dataType: "json",
						success: function ( data_simpan_geofencing ) {

							if ( typeof shape_baru.getPath == 'function' ) {
								for ( var j = 0; j < shape_baru.getPath().getLength(); j++ ) {
									$.ajax( {
										type: 'post',
										url: 'ajax_simpan_koordinat.php',
										async: false,
										data: {
											jenis: 'poly',
											lat: shape_baru.getPath().getAt( j ).lat(),
											lng: shape_baru.getPath().getAt( j ).lng(),
											id_geofencing: data_simpan_geofencing.id_geofencing
										},
										dataType: "json",
										success: function ( data ) {

										}
									} );
								}
							} else if ( typeof shape_baru.getBounds == 'function' ) {

								$.ajax( {
									type: 'post',
									url: 'ajax_simpan_koordinat.php',
									async: false,
									data: {
										jenis: 'rectangle',
										ne_lat: shape_baru.getBounds().getNorthEast().lat(),
										ne_lng: shape_baru.getBounds().getNorthEast().lng(),
										sw_lat: shape_baru.getBounds().getSouthWest().lat(),
										sw_lng: shape_baru.getBounds().getSouthWest().lng(),
										id_geofencing: data_simpan_geofencing.id_geofencing
									},
									dataType: "json",
									success: function ( data ) {

									}
								} );
							}
						}
					} );
				};
				location.reload();
			}
		} );

		google.maps.event.addListener( drawingManager, 'overlaycomplete', function ( e ) {
			var nama_lokasi = prompt( "Masukan Nama Lokasi Geofencing : " );
			e.nama = nama_lokasi;
			all_overlays.push( e );
			//~ if (e.type != google.maps.drawing.OverlayType.MARKER) {
			button.disabled = !button.disabled;
			var isNotMarker = ( e.type != google.maps.drawing.OverlayType.MARKER );
			// Switch back to non-drawing mode after drawing a shape.
			drawingManager.setDrawingMode( null );
			// Add an event listener that selects the newly-drawn shape when the user
			// mouses down on it.
			var newShape = e.overlay;
			newShape.type = e.type;


			google.maps.event.addListener( newShape, 'click', function () {
				setSelection( newShape, isNotMarker );
			} );
			setSelection( newShape, isNotMarker );
			//~ }// end if
		} );
		google.maps.event.addListener( drawingManager, 'drawingmode_changed', clearSelection );
		google.maps.event.addListener( map, 'click', clearSelection );
		google.maps.event.addDomListener( document.getElementById( 'delete-button' ), 'click', deleteSelectedShape );

	}

	function setSelection( shape, isNotMarker ) {
		clearSelection();
		selectedShape = shape;
		if ( isNotMarker ) {
			shape.setEditable( true );
			button.disabled = !button.disabled;
		}
	}

	function deleteSelectedShape() {
		if ( selectedShape ) {
			selectedShape.setMap( null );
			button.disabled = !button.disabled;
		}
	}

	function clearSelection() {
		for ( var j = 0; j < geofencing_polygon.length; j++ ) {
			geofencing_polygon[ j ].setEditable( false );
		}
		if ( selectedShape ) {
			if ( typeof selectedShape.setEditable == 'function' ) {
				selectedShape.setEditable( false );

			}
			selectedShape = null;


		}
		button.disabled = true;
	}
</script>