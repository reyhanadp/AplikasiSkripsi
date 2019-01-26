<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Untitled Document</title>
</head>

<body>
	<?php

	$polygon = array(
		array( -6.930530778662047, 107.65440391431468 ),
		array( -6.930530778662047, 107.65448538641351 ),
		array( -6.930409297037373, 107.65448438058513 ),
		array( -6.930409962690192, 107.65440324376243 )
	);
	
	print_r($polygon);

//	$polygon = [
//		[ -6.930530778662047, 107.65440391431468 ],
//		[ -6.930530778662047, 107.65448538641351 ],
//		[ -6.930409297037373, 107.65448438058513 ],
//		[ -6.930409962690192, 107.65440324376243 ]
//	];
	//alert(inside([ -6.930475, 107.654560 ], polygon));
//	echo count($polygon);
	echo '<br>';
	echo inside( array( -6.930475, 107.654560 ), $polygon );
	echo '<br>';
	echo inside( array( -6.930483, 107.654453 ), $polygon );
	echo '<br>';
	echo inside( array( -6.930426, 107.654454 ), $polygon );
	echo '<br>';
	echo inside( array( -6.930461, 107.654341 ), $polygon );
	//		console.log( inside( [ -6.930483, 107.654453 ], polygon ) );

	function inside( $point = array(), $vs = array() ) {
		// ray-casting algorithm based on
		// http://www.ecse.rpi.edu/Homepages/wrf/Research/Short_Notes/pnpoly.html

		$x = $point[ 0 ];
		$y = $point[ 1 ];

		$inside = 'no';
		for ( $i = 0, $j = count( $vs ) - 1; $i < count( $vs ); $j = $i++ ) {
			$xi = $vs[ $i ][ 0 ];
			$yi = $vs[ $i ][ 1 ];
			$xj = $vs[ $j ][ 0 ];
			$yj = $vs[ $j ][ 1 ];

			$intersect = ( ( $yi > $y ) != ( $yj > $y ) ) && ( $x < ( $xj - $xi ) * ( $y - $yi ) / ( $yj - $yi ) + $xi );
			
			if ( $intersect ){
				$inside = 'yes';
			}
		}
		return $inside;
	}

	?>

	<script>
		var polygon = [
			[ -6.930530778662047, 107.65440391431468 ],
			[ -6.930530778662047, 107.65448538641351 ],
			[ -6.930409297037373, 107.65448438058513 ],
			[ -6.930409962690192, 107.65440324376243 ]
		];
		//alert(inside([ -6.930475, 107.654560 ], polygon));
		console.log( inside( [ -6.930475, 107.654560 ], polygon ) );
		console.log( inside( [ -6.930483, 107.654453 ], polygon ) );
		console.log( inside( [ -6.930426, 107.654454 ], polygon ) );
		console.log( inside( [ -6.930461, 107.654341 ], polygon ) );


		function inside( point, vs ) {
			// ray-casting algorithm based on
			// http://www.ecse.rpi.edu/Homepages/wrf/Research/Short_Notes/pnpoly.html

			var x = point[ 0 ],
				y = point[ 1 ];

			var inside = false;
			for ( var i = 0, j = vs.length - 1; i < vs.length; j = i++ ) {
				var xi = vs[ i ][ 0 ],
					yi = vs[ i ][ 1 ];
				var xj = vs[ j ][ 0 ],
					yj = vs[ j ][ 1 ];
				
				var intersect = ( ( yi > y ) != ( yj > y ) ) &&
					( x < ( xj - xi ) * ( y - yi ) / ( yj - yi ) + xi );
				if ( intersect ) inside = !inside;
			}

			return inside;
		};
	</script>
</body>
</html>