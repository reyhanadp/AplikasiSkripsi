<?php
	function koneksi_db()
	{
		$host = "127.0.0.1";
		$username = "root";
		$password = "";
		$database  = "db_slbcsukapura";
		
		//koneksi
		$link = mysqli_connect($host,$username,$password,$database);
		if(!$link)
		{
			die("TIDAK BISA MELAKUKAN KONEKSI DATABSE".mysqli_error());
		}
		
		return $link;
	}
?>