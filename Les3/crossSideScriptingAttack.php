<?php
//insertCrossSideScriptingAttack.php
$host = "localhost";
$databaseName = "TodoDb";
$connectionString = "mysql:host=$host;dbname=$databaseName";
$username = "student";     //root is default in most cases
$password = "student";     //root is default in most cases

if(!empty($_POST["description"]))
{
    $description = $_POST["description"];
    $done = isset($_POST["done"]) ? true : false; //this is a trick (only possible with checkbox)

    $conn = null;
    try {
        $conn = new PDO($connectionString, $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO Todos (Description, Done) VALUES (:description, :done)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam("description", $description, PDO::PARAM_STR);
        $stmt->bindParam("done", $done, PDO::PARAM_BOOL);

        if($stmt->execute()) {
            $todoId = $conn->lastInsertId();

            echo "Inserted record with TodoId: $todoId";
        } else {
            //never executed, exception is thrown
            echo "Inserted failed";
        }
    } catch (PDOException $ex) {
        echo "PDOException:  $ex";
    } finally {
        if(isset($conn)) {
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
