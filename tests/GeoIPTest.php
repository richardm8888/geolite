<?php

require_once(__DIR__ . '/../models/DB.php');
require_once(__DIR__ . '/../models/GeoIP.php');

class GeoIPTest extends PHPUnit_Framework_TestCase
{
    /**
     * check the IP address is valid
     */
    public function testIPIsValid()
    {
        $settings = require(__DIR__ . '/../src/settings.php');
        $geo_ip = new GeoIP($settings['settings']);

        $this->assertTrue($geo_ip->validateIP('10.0.0.1'));
    }

    /**
     * check the IP address isn't valid
     */
    public function testIPIsNotValid()
    {
        $settings = require(__DIR__ . '/../src/settings.php');
        $geo_ip = new GeoIP($settings['settings']);

        $this->assertFalse($geo_ip->validateIP('10.0.0'));
    }

    /**
     * check that the IP address returns as expected to be from GB
     */
    public function testIPCountry()
    {
        $settings = require(__DIR__ . '/../src/settings.php');
        $geo_ip = new GeoIP($settings['settings']);

        $country = $geo_ip->getIPCountry('90.221.55.209');
        $this->assertEquals('GB', $country['countrycode']);
    }
}