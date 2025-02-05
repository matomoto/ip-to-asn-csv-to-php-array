<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/*
DP IP
IP to ASN Lite
https://db-ip.com/db/download/ip-to-asn-lite
CC BY 4.0
*/

$csv_filename = "dbip-asn-lite-2025-02.csv";

// CSV to Array - BEGIN
$fopen_path_csv = __DIR__ .  "/" . $csv_filename;

$csv_array = array();
$csv_ASN_array = array();
$csv_ASN_name_array = array();
if (file_exists($fopen_path_csv)) {
	if (($fopen_stream_csv = fopen($fopen_path_csv, "r")) !== false) {
		
		while (($csv_row = fgetcsv($fopen_stream_csv, null, ",", "\"", "\\")) !== false) {
			
			$csv_IP_start = trim($csv_row[0]);
			$csv_IP_end = trim($csv_row[1]);
			$csv_ASN = trim($csv_row[2]);
			$csv_ASN_name = trim($csv_row[3]);
			
			// ASN Name dont exist
			if (in_array($csv_ASN_name, $csv_ASN_name_array) === false) {
				
				// Dump Push ASN Name
				array_push($csv_ASN_name_array, $csv_ASN_name);
				
				$csv_ASN_key = array_search($csv_ASN_name, $csv_ASN_name_array);
				
				// ASN Name dont exist ASN dont exist
				if (in_array($csv_ASN, $csv_ASN_array) === false) {
					
					// Dump Push ASN
					array_push($csv_ASN_array, $csv_ASN);
					
					// Initialize Subarray
					$csv_array[$csv_ASN_key] = array();
					
					// Save ASN NAME
					$csv_array[$csv_ASN_key]["name"] = $csv_ASN_name;
					
					// Save Push ASN
					// Initialize Subarray
					$csv_array[$csv_ASN_key]["ASN"] = array();
					array_push($csv_array[$csv_ASN_key]["ASN"], $csv_ASN);
					
					// Save Push IP Range
					// Initialize Subarray
					$csv_array[$csv_ASN_key]["IP"] = array();
					array_push($csv_array[$csv_ASN_key]["IP"], array($csv_IP_start, $csv_IP_end));
					
				} else {
				// ASN NAME dont exist + ASN exist
					
					// Save ASN NAME
					$csv_array[$csv_ASN_key]["name"] = $csv_ASN_name;
					
					// Save Push IP Range
					array_push($csv_array[$csv_ASN_key]["IP"], array($csv_IP_start, $csv_IP_end));
				}
			} else {
			// ASN NAME exist
				
				$csv_ASN_key = array_search($csv_ASN_name, $csv_ASN_name_array);
				
				// ASN NAME exist ASN dont exist
				if (in_array($csv_ASN, $csv_ASN_array) === false) {
					
					// Dump Push ASN
					array_push($csv_ASN_array, $csv_ASN);
					
					// Save Push ASN
					array_push($csv_array[$csv_ASN_key]["ASN"], $csv_ASN);
					
					// Save Push IP Range
					array_push($csv_array[$csv_ASN_key]["IP"], array($csv_IP_start, $csv_IP_end));
					
				} else {
				// ASN NAME exist + ASN exist
					
					// Save Push IP Range
					array_push($csv_array[$csv_ASN_key]["IP"], array($csv_IP_start, $csv_IP_end));
				}
			}
		}
	}
	fclose($fopen_stream_csv);
}

// CSV to Array - END

// var_dump($csv_array);
// echo PHP_EOL;

// echo count($csv_array);
// echo PHP_EOL;

// sort($csv_ASN_name_array); // only for output a sorted name list, because otherwise the reference array keys going lost
// echo implode(PHP_EOL, $csv_ASN_name_array);
// echo PHP_EOL;

?>
