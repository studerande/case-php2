<?php

class Database
{

    public $db;

    public function __construct()
    {

        // credentials
        $servername = "mysql";
        $database = "db_lecture";
        $username = "db_user";
        $password = "db_password";

        // data source name
        $dsn = "mysql:host=$servername;dbname=$database";

        try {

            // connect to database
            $this->db = new PDO($dsn, $username, $password);

            // set the PDO error mode to exception
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // echo "Connected successfully";
        } catch (PDOException $e) {
            // ett fel som visar 'hemligheter' loggas till en fil för att inte visa för mycket
            // echo "Connection failed: " . $e->getMessage();
            echo "Connection failed: ";
        }
    }
}
