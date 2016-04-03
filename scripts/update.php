<?php
	$settings = require('../src/settings.php');
	$settings = $settings['settings'];

	$db = new mysqli($settings['db']['host'], $settings['db']['username'], $settings['db']['password'], $settings['db']['dbname']);

	$db_url = "http://geolite.maxmind.com/download/geoip/database/GeoIPCountryCSV.zip";

	$tmp_file = "tmp/GeoIPCountryCSV.zip";

	$zip_file = fopen($tmp_file, "w");

	// Get The Zip File From Server
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $db_url);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_FILE, $zip_file);
	$page = curl_exec($ch);
	if(!$page) {
		echo "Error :- ".curl_error($ch);
	}
	curl_close($ch);

	$zip = new ZipArchive;

	if ( $zip->open($tmp_file) === TRUE )
	{
		$zip->extractTo('tmp/');
		$zip->close();
	}

	$csv_file = fopen('tmp/GeoIPCountryWhois.csv', 'r');

	if ( $csv_file !== FALSE )
	{
		while ( $data = fgetcsv($csv_file) )
		{
			$sql = "
					INSERT INTO
						ip_countries
					(
						startip,
						endip,
						startipnumber,
						endipnumber,
						countrycode,
						countryname
					)
					VALUES
					(
						'" . quote_sql($data[0]) . "',
						'" . quote_sql($data[1]) . "',
						" . (int)$data[2] . ",
						" . (int)$data[3] . ",
						'" . quote_sql($data[4]) . "',
						'" . quote_sql($data[5]) . "'
					)
					ON DUPLICATE KEY UPDATE 
						countrycode = '" . quote_sql($data[4]) . "',
						countryname = '" . quote_sql($data[5]) . "'
			";

			$db->query($sql);
		}
	}
	else
	{
		echo "Error :- csv file not extracted";
	}

	function quote_sql($sql)
    {
        return str_replace("'", "''", $sql);
    }