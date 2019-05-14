<?php
//connectToDatabaseAndClose.php
$host = "localhost";
$databaseName = "TodoDb";
$dns = "mysql:host=$host;dbname=$databaseName";
$username = "root";     //for mamp
$password = "root";     //for mamp

//default username, password for wamp is root, empty/blank

$conn = null;

try {
    $conn = new PDO($dns, $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    echo "Connected successful";
} catch (PDOException $ex) {
    echo "Connection failed:  $ex";
} finally {
    if($conn != null) {
        $conn = null;
    }
}
?>