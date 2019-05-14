<?php
//insertDataWithNamedPlaceholders.php
function validate($str) {
    return trim(htmlspecialchars($str));
}


if(!empty($_POST["description"]))
{
    $description = validate(filter_var($_POST["description"], FILTER_SANITIZE_STRING));
    $done = isset($_POST["done"]) ? true : false;

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

        $sql = "INSERT INTO Todos (Description, Done) VALUES (:description, :done)";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue("description", $description, PDO::PARAM_STR);
        $stmt->bindValue("done", $done, PDO::PARAM_BOOL);
        $stmt->execute();

//        $stmt->execute(array("description" => $description, "done" => $done));

        //chain
        //$conn->prepare($sql)->execute([$description]);

        echo "Inserted Record";
    } catch (PDOException $ex) {
        echo "Connection failed:  $ex";
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
