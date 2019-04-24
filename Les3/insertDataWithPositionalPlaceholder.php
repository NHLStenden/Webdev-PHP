<?php

$description = $_POST["description"] ?? false;
$done = $_POST["done"] ?? false;
if($done === "on") {
    $done = true;
}

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

        $sql = "INSERT INTO Todos (Description, Done) VALUES (?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $description, PDO::PARAM_STR);
        $stmt->bindParam(2, $done, PDO::PARAM_BOOL);

        $stmt->execute();

        //chain
        //$conn->prepare($sql)->execute([$description]);

        echo "Inserted Record";
    } catch (PDOException $ex) {
        echo "Connection failed:  $ex";
    }
}

?>

<form method="post">
    <input name="description" type="text">
    <input name="done" type="checkbox">
    <button name="AddTodo" type="submit">Add Todo</button>
</form>
