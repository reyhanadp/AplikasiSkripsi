
<script src="../halaman_utama/lib/jquery/jquery.min.js"></script>
<script src="../select2-master/dist/js/select2.min.js"></script>
<script src="../halaman_utama/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="../halaman_utama/lib/jquery-ui-1.9.2.custom.min.js"></script>
<script src="../halaman_utama/lib/jquery.ui.touch-punch.min.js"></script>
<script class="include" type="text/javascript" src="../halaman_utama/lib/jquery.dcjqaccordion.2.7.js"></script>
<script src="../halaman_utama/lib/jquery.scrollTo.min.js"></script>
<script src="../halaman_utama/lib/jquery.nicescroll.js" type="text/javascript"></script>
<!--common script for all pages-->
<script src="../halaman_utama/lib/common-scripts.js"></script>
<!--script for this page-->
<!--Google Map-->
<?php
	if(isset($_GET['menu'])){
		?>
<script async defer type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDeSbTd4xPktRSQwbytnDN33ugM6sJrq_0&callback=initMap&libraries=drawing&libraries=places,drawing"></script>
<?php
	}
?>



<!--common script for all pages-->

</body>

</html>