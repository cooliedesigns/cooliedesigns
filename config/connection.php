<?php

function connection(){
    try{
        require 'database.php';
        $conn = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
        //set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully<br>";
    }
    catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage() . "<br>";
    }
    return $conn;
}

?>