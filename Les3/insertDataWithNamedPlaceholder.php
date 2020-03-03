<?php
//insertDataWithNamedPlaceholders.php
$host = "localhost";
$databaseName = "TodoDb";
$connectionString = "mysql:host=$host;dbname=$databaseName";
$username = "student";     //root is default in most cases
$password = "student";     //root is default in most cases

if(!empty($_POST["description"]))
{
    $description = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
    if($description === false) {
        echo "Error in description";
        die();
    }

    $done = isset($_POST["done"]) ? true : false;

    //default username, password for wamp is root, empty/blank
    $conn = null;
    try {
        $conn = new PDO($connectionString, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO Todos (Description, Done) VALUES (:description, :done)";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue("description", $description, PDO::PARAM_STR);
        $stmt->bindValue("done", $done, PDO::PARAM_BOOL);
        if($stmt->execute()) {
            echo "Inserted Record";
        } //else is in the Exception (an error occurred)!
    } catch (PDOException $ex) {
        echo "PDOException:  $ex";
    } finally {
        if($conn != null) {
            $conn = null;
        }
    }
} else {
    echo "invalid input!";
}

?>

<form method="post">
    <input name="description" type="text">
    <input name="done" type="checkbox">
    <button name="AddTodo" type="submit">Add Todo</button>
</form>
