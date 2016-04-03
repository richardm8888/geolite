<?php

/**
 *  DB class to use as a wrapper around the php mysqli objects / functions
 */
class DB
{
    private $db;

    /**
     * @param array $settings an array of database connecting settings
     */
    public function __construct($settings)
    {
        $this->db = new mysqli($settings['host'], $settings['username'], $settings['password'], $settings['dbname']);
    }

    /**
     * @param  string $sql a SQL statement
     * @return array of SQL results
     */
    public function query($sql)
    {
        return $this->db->query($sql)->fetch_assoc();
    }

    /**
     * @param  string $sql a SQL statement
     * @return string escaping string to avoid SQL injection
     */
    public function quote_sql($sql)
    {
        return $this->db->real_escape_string($sql);
    }
}