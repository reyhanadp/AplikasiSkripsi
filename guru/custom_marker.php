<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Untitled Document</title>

</head>

<body>
	<style>
		.customMarker {
			position: absolute;
			cursor: pointer;
			background: #424242;
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
			border-color: #424242 transparent;
			display: block;
			width: 0;
		}
		
		.customMarker img {
			width: 90px;
			height: 90px;
			margin: 5px;
			border-radius: 50%;
		}
	</style>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeSbTd4xPktRSQwbytnDN33ugM6sJrq_0&libraries=geometry"></script>
	

	<script type="text/javascript" src="http://www.google.com/jsapi"></script>
	<div id="map" style="width: 640pxpx; height: 480px;">map div</div>
	<script>
		google.setOnLoadCallback(initialize);
		
		function initialize(){
			var map = new google.maps.Map( document.getElementById( "map" ), {
			zoom: 17,
			center: new google.maps.LatLng( 37.77088429547992, -122.4135623872337 ),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		} );

		var data = [ {
			profileImage: "http://www.gravatar.com/avatar/d735414fa8687e8874783702f6c96fa6?s=90&d=identicon&r=PG",
			pos: [ 37.77085, -122.41356 ],
		}, {
			profileImage: "http://placekitten.com/90/90",
			pos: [ 37.77220, -122.41555 ],
		} ]

		for ( var i = 0; i < data.length; i++ ) {
			new CustomMarker( new google.maps.LatLng( data[ i ].pos[ 0 ], data[ i ].pos[ 1 ] ), map, data[ i ].profileImage )
		}
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
		
		
	</script>
</body>

</html>