<?php
    // creates connection to database    

    function db_connect()
    {
        require "config.php";
        $connection = new mysqli($host, $db_username, $db_pw, $dbname);
        return $connection;
    }
?>