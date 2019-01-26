<?php
// Load file koneksi.php
include "../koneksi.php";
$link = koneksi_db();

if ( isset( $_GET[ 'tingkat' ] ) ) {
	
	$tingkat = $_GET[ 'tingkat' ];

	// Load plugin PHPExcel nya
	require_once '../PHPExcel/PHPExcel.php';

	// Panggil class PHPExcel nya
	$excel = new PHPExcel();

	// Settingan awal fil excel
	$excel->getProperties()->setCreator( 'Solahudin' )->setLastModifiedBy( 'Solahudin' )->setTitle( "Data Siswa " . $tingkat )->setSubject( "Siswa" )->setDescription( "Laporan Data Siswa " . $tingkat )->setKeywords( "Data Siswa " . $tingkat );

	// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
	$style_col = array(
		'font' => array( 'bold' => true ), // Set font nya jadi bold
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			'top' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), // Set border top dengan garis tipis
			'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), // Set border right dengan garis tipis
			'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), // Set border bottom dengan garis tipis
			'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) // Set border left dengan garis tipis
		)
	);
	
	

	// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
	$style_row = array(
		'alignment' => array(
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		),
		'borders' => array(
			'top' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), // Set border top dengan garis tipis
			'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), // Set border right dengan garis tipis
			'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ), // Set border bottom dengan garis tipis
			'left' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) // Set border left dengan garis tipis
		)
	);
	
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName( 'Logo' );
	$objDrawing->setDescription( 'Logo' );
	$objDrawing->setPath( '../foto/logo.png' );
	$objDrawing->setHeight( 160 );
	$objDrawing->setWidth( 160 );
	$objDrawing->setCoordinates( 'B1' );
	$objDrawing->setOffsetX( 5 );
	$objDrawing->setWorksheet( $excel->getActiveSheet() );

	$excel->getActiveSheet()->mergeCells( 'B1:B7' ); // Set Merge Cell pada kolom A1 sampai F1

	$excel->setActiveSheetIndex( 0 )->setCellValue( 'C1', "IDENTITAS SEKOLAH" ); // Set kolom A1 dengan tulisan "DATA SISWA"
	$excel->getActiveSheet()->mergeCells( 'C1:D1' ); // Set Merge Cell pada kolom A1 sampai F1
	$excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setBold( TRUE ); // Set bold kolom A1
	$excel->getActiveSheet()->getStyle( 'C1' )->getFont()->setSize( 12 ); // Set font size 15 untuk kolom A1
	$excel->getActiveSheet()->getStyle( 'C1' )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER ); // Set text center untuk kolom A1

	// Buat header tabel nya pada baris ke 3
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'C2', "Nama Sekolah" ); // Set kolom A3 dengan tulisan "NO"
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'D2', "SLB C Sukapura" ); // Set kolom A3 dengan tulisan "NO"$excel->setActiveSheetIndex(0)->setCellValue('C2', "Nama Sekolah"); // Set kolom A3 dengan tulisan "NO"

	$excel->setActiveSheetIndex( 0 )->setCellValue( 'C3', "Status" ); // Set kolom B3 dengan tulisan "NIS"
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'D3', "Swasta" ); // Set kolom A3 dengan tulisan "NO"$excel->setActiveSheetIndex(0)->setCellValue('C2', "Nama Sekolah"); // Set kolom A3 dengan tulisan "NO"

	$excel->setActiveSheetIndex( 0 )->setCellValue( 'C4', "Alamat" ); // Set kolom C3 dengan tulisan "NAMA"
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'D4', "Jl. PSM Perumahan Bumi Asri" );
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'D5', "Kiaracondong Bandung 40285" ); // Set kolom A3 dengan tulisan "NO"$excel->setActiveSheetIndex(0)->setCellValue('C2', "Nama Sekolah"); // Set kolom A3 dengan tulisan "NO"
	$excel->getActiveSheet()->mergeCells( 'C4:C5' ); // Set Merge Cell pada kolom A1 sampai F1

	$excel->setActiveSheetIndex( 0 )->setCellValue( 'C6', "No. Telepon" ); // Set kolom A3 dengan tulisan "NO"$excel->setActiveSheetIndex(0)->setCellValue('C2', "Nama Sekolah"); // Set kolom A3 dengan tulisan "NO"
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'D6', "022-7336239" ); // Set kolom A3 dengan tulisan "NO"$excel->setActiveSheetIndex(0)->setCellValue('C2', "Nama Sekolah"); // Set kolom A3 dengan tulisan "NO"


	$excel->setActiveSheetIndex( 0 )->setCellValue( 'C7', "Email" ); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'D7', "slbcsukapura@gmail.com" ); // Set kolom D3 dengan tulisan "JENIS KELAMIN"


	$excel->setActiveSheetIndex( 0 )->setCellValue( 'C8', "NPSN" ); // Set kolom E3 dengan tulisan "TELEPON"
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'D8', "20219811" ); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
	

	for ( $i = 0; $i < 8; $i++ ) {
		# code
		$no = $i + 1;
		$excel->getActiveSheet()->getStyle( 'C' . $no )->applyFromArray( $style_row );
		$excel->getActiveSheet()->getStyle( 'D' . $no )->applyFromArray( $style_row );
	}
	$tanggal = getdate();
	$date_now = $tanggal[ 'mday' ] . " " . $tanggal[ 'month' ] . " " . $tanggal[ 'year' ];
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'F2', "Bandung, " . $date_now );
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'F3', "Kepala Sekolah" );

	//menampilkan data kepala sekolah
	$sql = mysqli_query( $link, "SELECT nama,nip FROM tb_guru where kode_jabatan='KSK';" );

	if ( $data = mysqli_fetch_assoc( $sql ) ) {
		$nama_kepsek = $data[ 'nama' ];
		$nip = $data[ 'nip' ];
	}
	
	
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'F7', $nama_kepsek );
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'F8', "NIP." . $nip );

	// // Buat header tabel nya pada baris ke 3
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'A10', "DATA SISWA " . $tingkat );

	$excel->setActiveSheetIndex( 0 )->setCellValue( 'A11', "NO" ); // Set kolom A3 dengan tulisan "NO"
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'B11', "NIS" ); // Set kolom B3 dengan tulisan "NIS"
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'C11', "NAMA" ); // Set kolom C3 dengan tulisan "NAMA"
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'D11', "WAKTU KABUR" ); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'E11', "WAKTU KETEMU" ); // Set kolom E3 dengan tulisan "TELEPON"
	$excel->setActiveSheetIndex( 0 )->setCellValue( 'F11', "LOKASI KETEMU" ); // Set kolom F3 dengan tulisan "ALAMAT"

	// Apply style header yang telah kita buat tadi ke masing-masing kolom header
	$excel->getActiveSheet()->getStyle( 'A11' )->applyFromArray( $style_col );
	$excel->getActiveSheet()->getStyle( 'B11' )->applyFromArray( $style_col );
	$excel->getActiveSheet()->getStyle( 'C11' )->applyFromArray( $style_col );
	$excel->getActiveSheet()->getStyle( 'D11' )->applyFromArray( $style_col );
	$excel->getActiveSheet()->getStyle( 'E11' )->applyFromArray( $style_col );
	$excel->getActiveSheet()->getStyle( 'F11' )->applyFromArray( $style_col );

	// Set height baris ke 1, 2 dan 3
	$excel->getActiveSheet()->getRowDimension( '1' )->setRowHeight( 20 );
	$excel->getActiveSheet()->getRowDimension( '2' )->setRowHeight( 20 );
	$excel->getActiveSheet()->getRowDimension( '3' )->setRowHeight( 20 );

	// Buat query untuk menampilkan semua data siswa
	$query = mysqli_query( $link, "SELECT tb_siswa.nis,tb_siswa.nama,tb_laporan.waktu_kabur,tb_laporan.waktu_ketemu,tb_laporan.lat,tb_laporan.longtitude FROM tb_siswa JOIN tb_laporan ON tb_siswa.nis=tb_laporan.nis JOIN tb_kelas ON tb_kelas.id_kelas=tb_siswa.id_kelas where tb_kelas.tingkatan='" . $tingkat . "' and tb_laporan.lat is not null" )or die( mysqli_error( $link ) );

	$no = 1; // Untuk penomoran tabel, di awal set dengan 1
	$numrow = 12; // Set baris pertama untuk isi tabel adalah baris ke 4
	while ( $data = mysqli_fetch_array( $query ) ) { // Ambil semua data dari hasil eksekusi $sql
		$excel->setActiveSheetIndex( 0 )->setCellValue( 'A' . $numrow, $no );
		$excel->setActiveSheetIndex( 0 )->setCellValue( 'B' . $numrow, $data[ 'nis' ] );
		$excel->setActiveSheetIndex( 0 )->setCellValue( 'C' . $numrow, $data[ 'nama' ] );
		$excel->setActiveSheetIndex( 0 )->setCellValue( 'D' . $numrow, $data[ 'waktu_kabur' ] );
		$excel->setActiveSheetIndex( 0 )->setCellValueExplicit( 'E' . $numrow, $data[ 'waktu_ketemu' ] );

		if ( !function_exists( 'getaddress' ) ) {
			// ... proceed to declare your function
			function getaddress( $lat, $lng ) {
				$url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim( $lat ) . ',' . trim( $lng ) . '&key=AIzaSyDeSbTd4xPktRSQwbytnDN33ugM6sJrq_0';
				$json = @file_get_contents( $url );
				$data = json_decode( $json );
				$status = $data->status;
				if ( $status == "OK" ) {
					return $data->results[ 0 ]->formatted_address;
				} else {
					return false;
				}
			}

			$lokasi_ketemu = getaddress( $data[ 'lat' ], $data[ 'longtitude' ] );
		}


		$excel->setActiveSheetIndex( 0 )->setCellValue( 'F' . $numrow, $lokasi_ketemu );

		// 	// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		$excel->getActiveSheet()->getStyle( 'A' . $numrow )->applyFromArray( $style_row );
		$excel->getActiveSheet()->getStyle( 'B' . $numrow )->applyFromArray( $style_row );
		$excel->getActiveSheet()->getStyle( 'C' . $numrow )->applyFromArray( $style_row );
		$excel->getActiveSheet()->getStyle( 'D' . $numrow )->applyFromArray( $style_row );
		$excel->getActiveSheet()->getStyle( 'E' . $numrow )->applyFromArray( $style_row );
		$excel->getActiveSheet()->getStyle( 'F' . $numrow )->applyFromArray( $style_row );

		$excel->getActiveSheet()->getRowDimension( $numrow )->setRowHeight( 20 );

		$no++; // Tambah 1 setiap kali looping
		$numrow++; // Tambah 1 setiap kali looping
	}

	// Set width kolom
	$excel->getActiveSheet()->getColumnDimension( 'A' )->setWidth( 5 ); // Set width kolom A
	$excel->getActiveSheet()->getColumnDimension( 'B' )->setWidth( 25 ); // Set width kolom B
	$excel->getActiveSheet()->getColumnDimension( 'C' )->setWidth( 15 ); // Set width kolom C
	$excel->getActiveSheet()->getColumnDimension( 'D' )->setWidth( 30 ); // Set width kolom D
	$excel->getActiveSheet()->getColumnDimension( 'E' )->setWidth( 15 ); // Set width kolom E
	$excel->getActiveSheet()->getColumnDimension( 'F' )->setWidth( 30 ); // Set width kolom F

	// Set orientasi kertas jadi LANDSCAPE
	$excel->getActiveSheet()->getPageSetup()->setOrientation( PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE );

	// Set judul file excel nya
	$excel->getActiveSheet( 0 )->setTitle( "Laporan Data Siswa " . $tingkat );
	$excel->setActiveSheetIndex( 0 );

	// Proses file excel
	header( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
	header( 'Content-Disposition: attachment; filename="Data Siswa ' . $tingkat . '.xlsx"' ); // Set nama file excel nya
	header( 'Cache-Control: max-age=0' );

	$write = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
	$write->save( 'php://output' );
	
}


?>