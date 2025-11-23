
<?php

$serverName = "localhost";
// change the database username
$username = "root";
// change the database password
$password = "";
// change the database name
$DBName = "php_project";

global $connection;

try {

    $options = array (
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    );

    $connection = new PDO ("mysql:host=$serverName;dbname=$DBName", $username, $password, $options);
    return $connection;

} catch (PDOException $ERROR) {
    
    die ("Error : " . $ERROR->getMessage());

}