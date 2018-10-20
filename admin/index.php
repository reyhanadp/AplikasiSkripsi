<?php
	session_start();
	require('admin_header.php');
?>

  <section id="container">
    <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg">
      <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
      </div>
      <!--logo start-->
      <a href="index.html" class="logo"><b>AD<span>MIN</span></b></a>
      <!--logo end-->
      <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
          <!-- settings start -->
          <!-- notification dropdown start-->
          <li id="header_notification_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
              <i class="fa fa-bell-o"></i>
              <span class="badge bg-warning">7</span>
              </a>
            <ul class="dropdown-menu extended notification">
              <div class="notify-arrow notify-arrow-yellow"></div>
              <li>
                <p class="yellow">You have 7 new notifications</p>
              </li>
              <li>
                <a href="index.html#">
                  <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                  Server Overloaded.
                  <span class="small italic">4 mins.</span>
                  </a>
              </li>
              <li>
                <a href="index.html#">
                  <span class="label label-warning"><i class="fa fa-bell"></i></span>
                  Memory #2 Not Responding.
                  <span class="small italic">30 mins.</span>
                  </a>
              </li>
              <li>
                <a href="index.html#">
                  <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                  Disk Space Reached 85%.
                  <span class="small italic">2 hrs.</span>
                  </a>
              </li>
              <li>
                <a href="index.html#">
                  <span class="label label-success"><i class="fa fa-plus"></i></span>
                  New User Registered.
                  <span class="small italic">3 hrs.</span>
                  </a>
              </li>
              <li>
                <a href="index.html#">See all notifications</a>
              </li>
            </ul>
          </li>
          <!-- notification dropdown end -->
        </ul>
        <!--  notification end -->
      </div>
      <div class="top-menu">
        <ul class="nav pull-right top-menu">
          <li><a class="logout" href="../logout.php">Logout</a></li>
        </ul>
      </div>
    </header>
    <!--header end-->
    <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
          <p class="centered"><a href="#"><img src="../foto/guru/<?php echo $_SESSION['s_foto']; ?>" class="img-circle" width="80"></a></p>
          <h5 class="centered"><?php echo $_SESSION['s_nama']; ?></h5>
          <?php
			if ( isset( $_GET[ 'menu' ] )) {
				if((($_GET['action']=='tampil')||($_GET['action']=='cari'))){

					$menu = $_GET[ 'menu' ];
					if ( $menu == 'guru' ) {
						require( 'menu_guru.php' );
					} else if ( $menu == 'siswa' ) {
						require( 'menu_siswa.php' );
					} else if ( $menu == 'ortu' ) {
						require( 'menu_orangtua.php' );
					} else if ( $menu == 'jabatan' ) {
						require( 'menu_jabatan.php' );
					} else if ( $menu == 'kelas' ) {
						require( 'menu_kelas.php' );
					} else if ( $menu == 'geofencing' ) {
						require( 'menu_geofencing.php' );
					}
				}
			} else {
				require( 'menu_dashboard.php' );
			}
			?>
			
			
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <?php
		if ( isset( $_GET[ 'menu' ] ) ) {
			$action = $_GET[ 'action' ];
			if(($_GET['menu']=='guru') && ($_GET['action']=='tampil'))
					{
						//panggil file tampil data guru
						require( 'tampil_guru.php' );
					}
			else if(($_GET['menu']=='guru') && ($_GET['action']=='cari'))
					{
						//panggil file tampil data guru
						require( 'tampil_cari_guru.php' );
					}
			else if(($_GET['menu']=='siswa') && ($_GET['action']=='tampil'))
					{
						//panggil file tampil data guru
						require( 'tampil_siswa.php' );
					}
			else if(($_GET['menu']=='siswa') && ($_GET['action']=='cari'))
					{
						//panggil file tampil data guru
						require( 'tampil_cari_siswa.php' );
					}
			else if(($_GET['menu']=='orangtua') && ($_GET['action']=='tampil'))
					{
						//panggil file tampil data guru
						require( 'tampil_orangtua.php' );
					}
			else if(($_GET['menu']=='orangtua') && ($_GET['action']=='cari'))
					{
						//panggil file tampil data guru
						require( 'tampil_cari_orangtua.php' );
					}
			else if(($_GET['menu']=='jabatan') && ($_GET['action']=='tampil'))
					{
						//panggil file tampil data guru
						require( 'tampil_jabatan.php' );
					}
			else if(($_GET['menu']=='jabatan') && ($_GET['action']=='cari'))
					{
						//panggil file tampil data guru
						require( 'tampil_cari_jabatan.php' );
					}
			else if(($_GET['menu']=='kelas') && ($_GET['action']=='tampil'))
					{
						//panggil file tampil data guru
						require( 'tampil_kelas.php' );
					}
			else if(($_GET['menu']=='kelas') && ($_GET['action']=='cari'))
					{
						//panggil file tampil data guru
						require( 'tampil_cari_kelas.php' );
					}
			else if(($_GET['menu']=='geofencing') && ($_GET['action']=='tampil'))
					{
						//panggil file tampil data guru
						require( 'tampil_geofencing.php' );
					}
			} else {
			require( 'tampil_dashboard.php' );
		}
	  ?>
    <!--main content end-->
    <!--footer start-->
    
    <!--footer end-->
  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <?php
	require('admin_footer.php');
?>