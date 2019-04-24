<?php

$description = $_POST["description"] ?? false;

if($description !== false) {
    $host = "localhost";
    $databaseName = "TodoDb";
    $dns = "mysql:host=$host;dbname=$databaseName";
    $username = "root";     //for mamp
    $password = "root";     //for mamp

    //default username, password for wamp is root, empty/blank

    try {
        $conn = new PDO($dns, $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO Todos (Description) VALUES ('$description')";

        $conn->exec($sql);

        echo "Inserted Record";
    } catch (PDOException $ex) {
        echo "Connection failed:  $ex";
    }
}

?>

<form method="post">
    <input name="description" type="text">
    <button name="AddTodo" type="submit">Add Todo</button>
</form>
