<?php
//queryData.php

$host = "localhost";
$databaseName = "TodoDb";
$dns = "mysql:host=$host;dbname=$databaseName";
//default username, password for wamp is root, empty/blank
$username = "root";     //for mamp
$password = "root";     //for mamp

$conn = null;
try {
    $conn = new PDO($dns, $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT TodoId, Description, Done FROM Todos";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach ($stmt->fetchAll() as $row) {
        echo $row["Description"]
            ."&nbsp;"
            .($row["Done"] ? "completed" : "") ."<br/>";
    }
} catch (PDOException $ex) {
    echo "Connection failed:  $ex";
} finally {
    $conn = null;
}
?>