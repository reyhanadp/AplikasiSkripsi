<?php

    $req = curl_init();
	curl_setopt($req, CURLOPT_URL,"http://slbcsukapura.info/admin/ajax_ambil_data_device_dari_api.php");
	curl_exec($req);

//require '../sms_gateway/autoload.php';
//
//use SMSGatewayMe\ Client\ ApiClient;
//use SMSGatewayMe\ Client\ Configuration;
//use SMSGatewayMe\ Client\ Api\ DeviceApi;
//
//// Configure client
//$config = Configuration::getDefaultConfiguration();
//$config->setApiKey( 'Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU0Mjc1OTI1MywiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjY0MzE0LCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.PyBLVXdPAhWPzbP4PPISIziDQXC0EMQLsmIWCAhYAL8' );
//$apiClient = new ApiClient( $config );
//
//// Create device client
//$deviceClient = new DeviceApi( $apiClient );
//
///**
// *   Device Search
// *
// *   Valid Fields: id, type, name, phone_number, make, model, provider, country
// *
// *   Filters is a multidimensional array.
// *   Each array inside of $filters is a query group.
// *   An 'and' is done for items within the same group. and an 'or' between groups.
// */
//$devices = $deviceClient->searchDevices( [] );
//echo( $devices );
?>