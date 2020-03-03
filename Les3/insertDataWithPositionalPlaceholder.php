<?php
//insertDataWithPositionalPlaceholder.php
$host = "localhost";
$databaseName = "TodoDb";
$connectionString = "mysql:host=$host;dbname=$databaseName";
$username = "student";     //root is default in most cases
$password = "student";     //root is default in most cases

$description = $_POST["description"] ?? false;
$done = $_POST["done"] ?? false;
if($done === "on") {
    $done = true;
}

if($description !== false) {
    $description = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
    if($description === false) {
        echo "Error in description";
        die();
    }

    //default username, password for wamp is root, empty/blank
    $conn = null;
    try {
        $conn = new PDO($connectionString, $username, $password);

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
        echo "PDOException:  $ex";
    } finally {
        if(isset($conn)) {
            $conn = null;
        }
    }
}

?>

<form method="post">
    <input name="description" type="text">
    <input name="done" type="checkbox">
    <button name="AddTodo" type="submit">Add Todo</button>
</form>
