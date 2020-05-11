<?php
//insertIdAndResult.php
$host = "localhost";
$databaseName = "TodoDb";
$connectionString = "mysql:host=$host;dbname=$databaseName";
$username = "student";     //root is default in most cases
$password = "student";     //root is default in most cases

//pay attention, isset($_POST["DeleteTodos"]) instead of !empty($_POST["DeleteTodos"])
//because the button has no value
if(isset($_POST["DeleteTodos"]))
{
    $conn = null;
    try {
        $conn = new PDO($connectionString, $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM Todos WHERE Done = true";

        $stmt = $conn->prepare($sql);

        if($stmt->execute()) {
            $deleteCount = $stmt->rowCount();
            echo "Deleted $deleteCount todo records";
        } else {
            //never executed, exception is thrown
            echo "No todos delete";
        }
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
    <button name="DeleteTodos" type="submit">Delete Done Todos</button>
</form>
