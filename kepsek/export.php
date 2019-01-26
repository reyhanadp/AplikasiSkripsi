<?php
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");

if($_GET['target']=='sdlb')
{
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=Data-SLDB.xls");
 
// Tambahkan table
include 'data_SDLB.php';
} else if($_GET['target']=='smplb')
{

// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=Data-SMPLB.xls");
 
// Tambahkan table
include 'data_SMPLB.php';
} else if($_GET['target']=='smalb')
{

// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=Data-SMALB.xls");
 
// Tambahkan table
include 'data_SMALB.php';
}
?>