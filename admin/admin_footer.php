<script src="../halaman_utama/lib/jquery/jquery.min.js"></script>
<script src="../halaman_utama/lib/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" language="javascript" src="../halaman_utama/lib/advanced-datatable/js/jquery.js"></script>
<script class="include" type="text/javascript" src="../halaman_utama/lib/jquery.dcjqaccordion.2.7.js"></script>
<script src="../halaman_utama/lib/jquery.scrollTo.min.js"></script>
<script src="../halaman_utama/lib/jquery.nicescroll.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="../halaman_utama/lib/advanced-datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="../halaman_utama/lib/advanced-datatable/js/DT_bootstrap.js"></script>
<!--common script for all pages-->
<script src="../halaman_utama/lib/common-scripts.js"></script>
<script type="text/javascript" src="../halaman_utama/lib/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="../halaman_utama/lib/gritter-conf.js"></script>
<script type="text/javascript" src="../halaman_utama/lib/jquery.backstretch.min.js"></script>
<!--script for this page-->
<!--Google Map-->
<?php
	if(isset($_GET['menu'])){
	if($_GET['menu']=="geofencing"){
?>
<script async defer type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDeSbTd4xPktRSQwbytnDN33ugM6sJrq_0&callback=initMap&libraries=drawing&libraries=places,drawing"></script>
<?php
	}
		}
?>

<script type="text/javascript">
	<?php
		if(isset($_SESSION['s_pesan'])){
			
		
	?>
	$(document).ready(function() {
      var unique_id = $.gritter.add({
        // (string | mandatory) the heading of the notification
        title: 'Peringatan!',
        // (string | mandatory) the text inside the notification
        text: '<?php echo $_SESSION['s_pesan']; ?>',
        // (string | optional) the image to display on the left
        // (bool | optional) if you want it to fade out on its own or just sit there
        sticky: false,
        // (int | optional) the time you want it to be alive for before fading out
        time: 8000,
        // (string | optional) the class name you want to apply to that specific message
        class_name: 'my-sticky-class'
      });

      return false;
    });
	
	<?php
			unset($_SESSION['s_pesan']);
		}
	?>
	/* Formating function for row details */
	$( document ).ready( function () {
		/*
		 * Insert a 'details' column to the table
		 */
		var nCloneTh = document.createElement( 'th' );
		var nCloneTd = document.createElement( 'td' );
		nCloneTd.innerHTML = '<?php if(isset($_GET['menu'])){ if($_GET['menu']!='jabatan' && $_GET['menu']!='kelas' && $_GET['menu']!='device'){ ?><img src="../foto/mata.png" class="mata">&nbsp;&nbsp;<?php }}?><img src="../foto/edit.png" class="edit">';
		nCloneTd.className = "center";

		$( '#hidden-table-info thead tr' ).each( function () {
			this.insertBefore( nCloneTh, this.childNodes[ 0 ] );
		} );

		$( '#hidden-table-info tbody tr' ).each( function () {
			this.insertBefore( nCloneTd.cloneNode( true ), this.childNodes[ 0 ] );
		} );

		/*
		 * Initialse DataTables, with no sorting on the 'details' column
		 */
		var oTable = $( '#hidden-table-info' ).dataTable( {
			"aoColumnDefs": [ {
				"bSortable": false,
				"aTargets": [ 0 ]
			} ],
			"aaSorting": [
				[ 1, 'asc' ]
			]
		} );

		/* Add event listener for opening and closing details
		 * Note that the indicator for showing which row is open is not controlled by DataTables,
		 * rather it is done here
		 */
		$( '.mata' ).live( 'click', function () {
			var nTr = $( this ).parents( 'tr' )[ 0 ];
			if ( oTable.fnIsOpen( nTr ) ) {
				/* This row is already open - close it */
				this.src = "../foto/mata.png";
				oTable.fnClose( nTr );
			} else {
				/* Open this row */
				this.src = "../foto/mata_buta.png";
				oTable.fnOpen( nTr, fnFormatDetails( oTable, nTr ), 'details' );
			}
		} );

		$( '.edit' ).live( 'click', function () {
			var nTr = $( this ).parents( 'tr' )[ 0 ];
			if ( oTable.fnIsOpen( nTr ) ) {
				/* This row is already open - close it */
				oTable.fnClose( nTr );
			} else {
				/* Open this row */
				oTable.fnOpen( nTr, fnFormatEdit( oTable, nTr ), 'details' );
			}
		} );
	} );
</script>


</body>

</html>