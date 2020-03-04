<?php
$host = "localhost";
$databaseName = "TodoDb";
$connectionString = "mysql:host=$host;dbname=$databaseName";
$username = "student";     //root is default in most cases
$password = "student";     //root is default in most cases

// ?? =	Null coalescing operator (google for explanation!)
$todoId = $_POST["todoId"] ??
            $_GET["todoId"] ?? false;

if($todoId === false) {
    echo "Incorrect input";
    die();
}

$todoId = filter_var($todoId, FILTER_VALIDATE_INT);
if($todoId === false) {
    echo "Incorrect input";
    die();
}

try {
    $conn = new PDO($connectionString, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $deleteStmt = $conn->prepare("DELETE FROM Todos WHERE TodoId = :todoId");
    $deleteStmt->bindValue(":todoId", $todoId);

    $deleteStmt->execute();

    //redirect to index.php
    header("Location: index.php");
} catch (PDOException $ex) {
    echo "PDOException $ex";
} finally {
    if($conn != null) {
        $conn = null;
    }
}