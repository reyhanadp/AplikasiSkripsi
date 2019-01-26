<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Siswa Lokasi</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body class="isi_body">
	
</body>


<script>
	window.setInterval( update_lat_long, 1000 );

	function update_lat_long() {
		$.ajax( {
			type: 'post',
			url: 'refresh_siswa.php',
			data: {
				id: '112'
			},
			success: function ( data ) {
				$( '.isi_body' ).html( data );
			}
		} );
	}
</script>

</html>