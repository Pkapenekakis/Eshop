<?php
     //used in the initial PDO call
    $host = "localhost"; 
    $db = "webproject";
    $charset = 'utf8mb4';
    //used in the PDO constuctor
    $user = "root";
    $password = "";
    
    //Create a conncetion to the database and check if it succeeded
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //prevents having to get the error message manually
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //Sets the default fetch mode as a assosiative array, TODO check if its better as an object (PDO::FETCH_OBJ)
        PDO::ATTR_EMULATE_PREPARES   => false, //turns off the emulation mode
    ];

    
    //create a pdo connection to the database
    try {
        $conn = new PDO($dsn, $user, $password, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
        
    }
?>