<?php

/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/*::                                                                         :*/
/*::  This routine calculates the distance between two points (given the     :*/
/*::  latitude/longitude of those points). It is being used to calculate     :*/
/*::  the distance between two locations using GeoDataSource(TM) Products    :*/
/*::                                                                         :*/
/*::  Definitions:                                                           :*/
/*::    South latitudes are negative, east longitudes are positive           :*/
/*::                                                                         :*/
/*::  Passed to function:                                                    :*/
/*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
/*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
/*::    unit = the unit you desire for results                               :*/
/*::           where: 'M' is statute miles (default)                         :*/
/*::                  'K' is kilometers                                      :*/
/*::                  'N' is nautical miles                                  :*/
/*::  Worldwide cities and other features databases with latitude longitude  :*/
/*::  are available at https://www.geodatasource.com                          :*/
/*::                                                                         :*/
/*::  For enquiries, please contact sales@geodatasource.com                  :*/
/*::                                                                         :*/
/*::  Official Web site: https://www.geodatasource.com                        :*/
/*::                                                                         :*/
/*::         GeoDataSource.com (C) All Rights Reserved 2018                  :*/
/*::                                                                         :*/
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

function getDistanceBetween($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Mi') 
{ 
	$theta = $longitude1 - $longitude2; 
	$distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)))  + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
	$distance = acos($distance); 
	$distance = rad2deg($distance); 
	$distance = $distance * 60 * 1.1515; 
	switch($unit) 
	{ 
		case 'Mi': break; 
		case 'Meter' : $distance = $distance * 1.609344 * 1000; 
	} 
	return (round($distance,2)); 
}

function haversineGreatCircleDistance( $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius =6371000 ) {
	// convert from degrees to radians
	$latFrom = deg2rad( $latitudeFrom );
	$lonFrom = deg2rad( $longitudeFrom );
	$latTo = deg2rad( $latitudeTo );
	$lonTo = deg2rad( $longitudeTo );

	$latDelta = $latTo - $latFrom;
	$lonDelta = $lonTo - $lonFrom;

	$angle = 2 * asin( sqrt( pow( sin( $latDelta / 2 ), 2 ) + cos( $latFrom ) * cos( $latTo ) * pow( sin( $lonDelta / 2 ), 2 ) ) );
	return $angle * $earthRadius;
}

function distance( $lat1, $lon1, $lat2, $lon2, $unit ) {
	if ( ( $lat1 == $lat2 ) && ( $lon1 == $lon2 ) ) {
		return 0;
	} else {
		$theta = $lon1 - $lon2;
		$dist = sin( deg2rad( $lat1 ) ) * sin( deg2rad( $lat2 ) ) + cos( deg2rad( $lat1 ) ) * cos( deg2rad( $lat2 ) ) * cos( deg2rad( $theta ) );
		$dist = acos( $dist );
		$dist = rad2deg( $dist );
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper( $unit );

		if ( $unit == "K" ) {
			return ( $miles * 1.609344 );
		} else if ( $unit == "N" ) {
			return ( $miles * 0.8684 );
		} else if ( $unit == "J" ) {
			return ( $miles * 1609.344 );
		} else {
			return $miles;
		}
	}
}

echo distance( 32.9697, -96.80322, 29.46786, -98.53506, "M" ) . " Miles<br>";
echo distance( 32.9697, -96.80322, 29.46786, -98.53506, "K" ) . " Kilometers<br>";
echo distance( 32.9697, -96.80322, 29.46786, -98.53506, "N" ) . " Nautical Miles<br>";
echo round(distance( -6.930479, 107.654442, -6.930475, 107.654190, "J" ),3) . " Meters<br>";
echo round(haversineGreatCircleDistance( -6.930479, 107.654442, -6.930475, 107.654190 ),3). " Meter(M)<br>";
//echo getDistanceBetween(32.9697, -96.80322, 29.46786, -98.53506, 'Meter'). " M";
?>