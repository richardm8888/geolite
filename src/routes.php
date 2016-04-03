<?php
// Routes

$app->get('/locationByIP[/{ip}]', function ($request, $response, $args) 
{
    // Sample log message
    $this->logger->info("GeoLite '/' route");

    // Retrieve ip address from URL
    $address = ( (isset($args['ip'])) ? $args['ip'] : false );

    // Return error if IP address not included in URL
    if (!$address)
    {
    	$return = array('error' => 'No IP Address supplied');
    	return $response->withJSON($return, 400);
    }

    // Create GeoIP class
    $geoip = new \GeoIP($this->settings);

    // Validate IP address format
    if (!$geoip->validateIP($address))
    {
    	$return = array('error' => 'Invalid IP Address supplied');
    	return $response->withJSON($return, 400);
    }

    // Retrieve IP address country
    $country = $geoip->getIPCountry($address);

    // If a match is found, return it, otherwise return error
    if ( $country['countrycode'] )
    {
    	return $response->withJSON($country, 200);
    }
    else
    {
    	$return = array('error' => 'Country could not be determined.');
    	return $response->withJSON($return, 400);
    }
});
