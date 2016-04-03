<?php

/**
 *  GeoIP class to check the format of IP Addresses and check their country against a IP address database
 */
class GeoIP
{
    private $db;

    /**
     * @param array $settings an array of database connecting settings
     */
    public function __construct($settings)
    {
        $this->db = new \DB($settings['db']);
    }

    /**
     * @param  string $ip an IP Address
     * @return boolean whether $ip is valid or not
     */
    public function validateIP($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP);
    }

    /**
     * @param  string $ip an IP Address
     * @return array consisting of 'countrycode' and 'countryname'
     */
    public function getIPCountry($ip)
    {
        $sql = "
            SELECT  countrycode,
                    countryname
            FROM    ip_countries
            WHERE   INET_ATON('" . $this->db->quote_sql($ip) . "') BETWEEN startipnumber And endipnumber
            LIMIT   1
        ";

        return $this->db->query($sql);
    }
}