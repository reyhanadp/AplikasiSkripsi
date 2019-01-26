<?php
session_start();
require( '../koneksi.php' );
$link = koneksi_db();

?>

<style>
	#ukuran {
		position: absolute;
		/*		left: 38%;*/
		margin: 23px 0 0 0;
	}
	
	#ex1Slider {
		position: absolute;
		width: 700px;
		left: 15%;
		margin: 20px 0 0 0;
	}
	
	#ex1Slider .slider-selection {
		background: #BABABA;
	}
</style>

<section id="main-content">
	<section class="wrapper">
		<div class="row">
			<div class="col-sm-12">
				<section class="panel">
					<header class="panel-heading">

						<div class="col-md-2">
							<strong>Data Geofencing</strong>
						</div>

						<div class="col-md-7">
							<input id="input_cari" type="text" placeholder="Cari Tempat . . ." size="50">

						</div>
						<div class="col-md-3">
							<button href="#konfirmasi" class="btn btn-round btn-primary" data-toggle="modal" id="input_manual">Input Manual</button>
							<button class="btn btn-round btn-primary" id="delete-button" disabled>Delete</button>
							<button class="btn btn-round btn-primary" id="save-button">Save</button>
						</div>
						<br>
					</header>
					<div class="panel-body">
						<div id="map"></div>
						<h5 id="ukuran"><strong>Ukuran Geofencing</strong></h5>
						<input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="100" data-slider-step="0.001" data-slider-value="20" data-slider-enabled="false"/>
					</div>
				</section>
			</div>
		</div>
		<!-- page end-->
	</section>
	<!-- /wrapper -->
</section>

<!--modal geofencing-->
<div class="modal fade" id="konfirmasi" tabindex="-1" role="dialog" aria-labelledby="history" aria-hidden="true">
	<div class="modal-dialog" role="document">

		<!-- Modal content-->
		<div class="modal-content">
			<form id="input-manual" action="ajax_input_manual.php" method="post" enctype="multipart/form-data" onSubmit="return confirm('Apakah anda yakin menyimpan data geofencing?');">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<center>
						<h4 class="modal-title">Geofencing Input Manual</h4>
					</center>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="nama">Nama Geofencing : </label>
						<input type="text" class="form-control" name="nama" required>
					</div>
					<div class="form-group">
						<label for="latlng">Latitude dan Longitude Geofencing : </label>
						<div id="education_fields">
						</div>
						<div class="row">
							<div class="col-sm-5 nopadding">
								<div class="form-group">
									<input type="text" size="20" class="form-control" id="latitude" name="latitude[]" value="" placeholder="Latitude">
								</div>
							</div>

							<div class="col-sm-5 nopadding">
								<div class="form-group">
									<input type="text" size="20" class="form-control" id="longitude" name="longitude[]" value="" placeholder="Longitude">
								</div>
							</div>

							<div class="col-sm-2 nopadding">
								<div class="form-group">
									<button class="btn btn-success" type="button" onclick="education_fields();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
								</div>
							</div>
						</div>
						<div class="clear"></div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-round btn-primary">Simpan Geofencing</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	var room = 1;

	function education_fields() {

		room++;
		var objTo = document.getElementById( 'education_fields' )
		var divtest = document.createElement( "div" );
		divtest.setAttribute( "class", "form-group removeclass" + room );
		var rdiv = 'removeclass' + room;
		divtest.innerHTML = '<div class="row"><div class="col-sm-5 nopadding"><div class="form-group"><input type="text" size="20" class="form-control" id="latitude" name="latitude[]" value="" placeholder="Latitude"></div></div><div class="col-sm-5 nopadding"><div class="form-group"><input type="text" size="20" class="form-control" id="longitude" name="longitude[]" value="" placeholder="Longitude"></div></div><div class="col-sm-2 nopadding"><div class="form-group"><button class="btn btn-danger" type="button" onclick="remove_education_fields(' + room + ');"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button></div></div></div><div class="clear"></div>';
		objTo.appendChild( divtest )
	}

	function remove_education_fields( rid ) {
		$( '.removeclass' + rid ).remove();
	}
	//	$( function () {
	//		$( document ).on( 'click', '.btn-add', function ( e ) {
	//			e.preventDefault();
	//			var controlForm = $( '.controls form:first' ),
	//				currentEntry = $( this ).parents( '.entry:first' ),
	//				newEntry = $( currentEntry.clone() ).appendTo( controlForm );
	//
	//			newEntry.find( 'input' ).val( '' );
	//			controlForm.find( '.entry:not(:last) .btn-add' )
	//				.removeClass( 'btn-add' ).addClass( 'btn-remove' )
	//				.removeClass( 'btn-success' ).addClass( 'btn-danger' )
	//				.html( '<span class="glyphicon glyphicon-minus"></span>' );
	//		} ).on( 'click', '.btn-remove', function ( e ) {
	//			$( this ).parents( '.entry:first' ).remove();
	//
	//			e.preventDefault();
	//			return false;
	//		} );
	//	} );


	//	$( document ).ready( function () {
	//		$( '#konfirmasi' ).on( 'show.bs.modal', function ( e ) {
	//			//harus tetap id, jika tidak akan data tak akan terambil
	//			//menggunakan fungsi ajax untuk pengambilan data
	//			$.ajax( {
	//				type: 'post',
	//				url: 'ajax_detail_geofencing.php',
	//				success: function ( data ) {
	//					$( '.detail-konfirmasi' ).html( data ); //menampilkan data ke dalam modal
	//				}
	//			} );
	//		} );
	//	} );
</script>


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
	var input_slider;
	var searchBox;
	var curposdiv;
	var curseldiv;
	var geofencing_polygon = [];
	var geofencing_rectangle = [];
	var geofencing_circle = [];
	var slider_init;

	//	$( '#ex1' ).slider( {
	//		formatter: function ( value ) {
	//			return 'Radius: ' + value + ' meter';
	//		}
	//	} );

	$( '#ex1' ).on( 'slide', function ( tes ) {
		selectedShape.setRadius( tes.value );

	} );

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


		slider_init = new Slider( '#ex1', {
			formatter: function ( value ) {
				return 'Radius: ' + value + ' meter';
			}
		} );

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
				var d = 0;

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
								} else if ( data[ a ][ "bentuk" ] == "circle" ) {
									geofencing_circle[ d ] = new google.maps.Circle( {
										strokeColor: '#FF0000',
										strokeOpacity: 0.8,
										strokeWeight: 2,
										fillColor: '#FF0000',
										fillOpacity: 0.35,
										id_geofencing: data[ a ][ "id_geofencing" ],
										map: map,
										center: {
											lat: parseFloat( data_koordinat[ 0 ][ "latitude" ] ),
											lng: parseFloat( data_koordinat[ 0 ][ "longitude" ] )
										},
										radius: parseFloat( data_koordinat[ 0 ][ "radius" ] )
									} );

									geofencing_circle[ d ].addListener( 'click', function ( event ) {
										clearSelection();
										this.setEditable( true );
										selectedShape = this;
										button.disabled = !button.disabled;
										slider_init.enable();
										slider_init.setValue( selectedShape.getRadius() );
									} );

									d++;
								}
							}
						} );

					}
				}
			}
		} );



		input = ( document.getElementById( 'input_cari' ) );
		map.controls[ google.maps.ControlPosition.TOP_CENTER ].push( input );
		searchBox = new google.maps.places.SearchBox( input );



		google.maps.event.addListener( searchBox, 'places_changed', function () {
			var places = searchBox.getPlaces();
			if ( places.length == 0 ) {
				alert( 'Tempat Tidak Ditemukan' );
				return;
			}
			var bounds = new google.maps.LatLngBounds();
			for ( var i = 0, place; place = places[ i ]; i++ ) {
				bounds.extend( place.geometry.location );
			}
			map.fitBounds( bounds );
			map.setZoom( 19 );
		} );

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
				position: google.maps.ControlPosition.BOTTOM_CENTER,
				//				drawingModes: [ 'circle' ]
				drawingModes: [ 'circle', 'polygon', 'rectangle' ]
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
				var panjang_circle = geofencing_circle.length;

				//				simpan polygon
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


				//				simpan rectangle
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
										ne_lat: geofencing_rectangle[ i ].getBounds().getNorthEast().lat(),
										ne_lng: geofencing_rectangle[ i ].getBounds().getNorthEast().lng(),
										sw_lat: geofencing_rectangle[ i ].getBounds().getSouthWest().lat(),
										sw_lng: geofencing_rectangle[ i ].getBounds().getSouthWest().lng(),
										id_geofencing: geofencing_rectangle[ i ].id_geofencing
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


				//				simpan circle
				for ( var i = 0; i < panjang_circle; i++ ) {
					if ( geofencing_circle[ i ].getMap() != null ) {
						$.ajax( {
							type: 'post',
							url: 'ajax_hapus_koordinat.php',
							async: false,
							data: {
								jenis: 'sekolah',
								id_geofencing: geofencing_circle[ i ].id_geofencing
							},
							dataType: "json",
							success: function ( data_hapus_koordinat ) {

								$.ajax( {
									type: 'post',
									url: 'ajax_simpan_koordinat.php',
									async: false,
									data: {
										jenis: 'circle',
										lat: geofencing_circle[ i ].getBounds().getCenter().lat(),
										lng: geofencing_circle[ i ].getBounds().getCenter().lng(),
										radius: geofencing_circle[ i ].getRadius(),
										id_geofencing: geofencing_circle[ i ].id_geofencing
									},
									dataType: "json",
									success: function ( data ) {

									}
								} );

							}
						} );
					} else if ( geofencing_circle[ i ].getMap() == null ) {
						$.ajax( {
							type: 'post',
							url: 'ajax_ubah_status_geofencing.php',
							async: false,
							data: {
								jenis: 'sekolah',
								id_geofencing: geofencing_circle[ i ].id_geofencing
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

					if ( shape_baru.getMap() != null ) {

						if ( typeof shape_baru.getRadius == 'function' ) {
							bentuk = 'circle';
						} else if ( typeof shape_baru.getPath == 'function' ) {
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

								if ( typeof shape_baru.getRadius == 'function' ) {
									$.ajax( {
										type: 'post',
										url: 'ajax_simpan_koordinat.php',
										async: false,
										data: {
											jenis: 'circle',
											lat: shape_baru.getBounds().getCenter().lat(),
											lng: shape_baru.getBounds().getCenter().lng(),
											radius: shape_baru.getRadius(),
											id_geofencing: data_simpan_geofencing.id_geofencing
										},
										dataType: "json",
										success: function ( data ) {

										}
									} );
								} else if ( typeof shape_baru.getPath == 'function' ) {
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
					}
				};
				location.reload();
			}
		} );

		google.maps.event.addListener( drawingManager, 'overlaycomplete', function ( e ) {
			var nama_lokasi = prompt( "Masukan Nama Lokasi Geofencing : " );
			if ( nama_lokasi == null ) {
				e.overlay.setMap( null );
			}
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
			if ( typeof selectedShape.getRadius === "function" ) {
				slider_init.enable();
				slider_init.setValue( selectedShape.getRadius() );
			}

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
		slider_init.disable();
	}
</script>