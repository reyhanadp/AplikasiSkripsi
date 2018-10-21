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
							<button class="btn btn-round btn-primary" id="delete-button">Delete</button>
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

	var map; //= new google.maps.Map(document.getElementById('map'), {
	// these must have global refs too!:
	var placeMarkers = [];
	var input;
	var searchBox;
	var curposdiv;
	var curseldiv;

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

		drawingManager = new google.maps.drawing.DrawingManager( {
			drawingMode: google.maps.drawing.OverlayType.NULL,
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
		
		google.maps.event.addListener( drawingManager, 'overlaycomplete', function ( e ) {
				//~ if (e.type != google.maps.drawing.OverlayType.MARKER) {
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
				google.maps.event.addListener( newShape, 'drag', function () {
					updateCurSelText( newShape );
				} );
				google.maps.event.addListener( newShape, 'dragend', function () {
					updateCurSelText( newShape );
				} );
				setSelection( newShape, isNotMarker );
				//~ }// end if
			} );
		google.maps.event.addListener( drawingManager, 'drawingmode_changed', clearSelection );
		google.maps.event.addListener( map, 'click', clearSelection );
		google.maps.event.addDomListener( document.getElementById( 'delete-button' ), 'click', deleteSelectedShape );
		// The marker, positioned at Uluru
	}
	
	function setSelection( shape, isNotMarker ) {
			clearSelection();
			selectedShape = shape;
			if ( isNotMarker )
				shape.setEditable( true );
//			selectColor( shape.get( 'fillColor' ) || shape.get( 'strokeColor' ) );
			updateCurSelText( shape );
		}
	
	function deleteSelectedShape() {
			if ( selectedShape ) {
				selectedShape.setMap( null );
			}
		}
	
	function clearSelection() {
			if ( selectedShape ) {
				if ( typeof selectedShape.setEditable == 'function' ) {
					selectedShape.setEditable( false );
				}
				selectedShape = null;
			}
//			curseldiv.innerHTML = "<b>cursel</b>:";
		}
	
	function selectColor( color ) {
			selectedColor = color;
			for ( var i = 0; i < colors.length; ++i ) {
				var currColor = colors[ i ];
				colorButtons[ currColor ].style.border = currColor == color ? '2px solid #789' : '2px solid #fff';
			}
			// Retrieves the current options from the drawing manager and replaces the
			// stroke or fill color as appropriate.
			var polylineOptions = drawingManager.get( 'polylineOptions' );
			polylineOptions.strokeColor = color;
			drawingManager.set( 'polylineOptions', polylineOptions );
			var rectangleOptions = drawingManager.get( 'rectangleOptions' );
			rectangleOptions.fillColor = color;
			drawingManager.set( 'rectangleOptions', rectangleOptions );
			var circleOptions = drawingManager.get( 'circleOptions' );
			circleOptions.fillColor = color;
			drawingManager.set( 'circleOptions', circleOptions );
			var polygonOptions = drawingManager.get( 'polygonOptions' );
			polygonOptions.fillColor = color;
			drawingManager.set( 'polygonOptions', polygonOptions );
		}
	
	function updateCurSelText( shape ) {
			posstr = "" + selectedShape.position;
			if ( typeof selectedShape.position == 'object' ) {
				posstr = selectedShape.position.toUrlValue();
			}
			pathstr = "" + selectedShape.getPath;
			if ( typeof selectedShape.getPath == 'function' ) {
				pathstr = "[ ";
				for ( var i = 0; i < selectedShape.getPath().getLength(); i++ ) {
					// .toUrlValue(5) limits number of decimals, default is 6 but can do more
					pathstr += selectedShape.getPath().getAt( i ).toUrlValue() + " , ";
				}
				pathstr += "]";
			}
			alert(pathstr);
			bndstr = "" + selectedShape.getBounds;
			cntstr = "" + selectedShape.getBounds;
			if ( typeof selectedShape.getBounds == 'function' ) {
				var tmpbounds = selectedShape.getBounds();
				cntstr = "" + tmpbounds.getCenter().toUrlValue();
				bndstr = "[NE: " + tmpbounds.getNorthEast().toUrlValue() + " SW: " + tmpbounds.getSouthWest().toUrlValue() + "]";
			}
			alert(bndstr);
			cntrstr = "" + selectedShape.getCenter;
			if ( typeof selectedShape.getCenter == 'function' ) {
				cntrstr = "" + selectedShape.getCenter().toUrlValue();
			}
			radstr = "" + selectedShape.getRadius;
			if ( typeof selectedShape.getRadius == 'function' ) {
				radstr = "" + selectedShape.getRadius();
			}
			curseldiv.innerHTML = "<b>cursel</b>: " + selectedShape.type + " " + selectedShape + "; <i>pos</i>: " + posstr + " ; <i>path</i>: " + pathstr + " ; <i>bounds</i>: " + bndstr + " ; <i>Cb</i>: " + cntstr + " ; <i>radius</i>: " + radstr + " ; <i>Cr</i>: " + cntrstr;
		}
</script>