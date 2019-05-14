<?php
//todoExample.php

function validate($str) {
    return trim(htmlspecialchars($str));
}

$host = "localhost";
$databaseName = "TodoDb";
$dns = "mysql:host=$host;dbname=$databaseName";
$username = "root";     //for mamp
$password = "root";     //for mamp

//I had problems with $options to get it working
//$options = [
//    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,           //I think this is the default fetch mode?
//    PDO::ATTR_EMULATE_PREPARES   => false,
//];

$rowToEdit = null;

$conn = null;
try {
    $conn = new PDO($dns, $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["ACTION"])) {
            $action = $_POST["ACTION"];

            if ($action === "AddTodo") {
                if (isset($_POST["description"]) && !empty($_POST["description"])) {
                    $sqlInsert = "INSERT INTO Todos (Description, Done) VALUES (:description, :done)";

                    $description = validate($_POST["description"]);
                    $done = false;

                    $stmtInsert = $conn->prepare($sqlInsert);
                    $stmtInsert->bindValue(":description", $description, PDO::PARAM_STR);
                    $stmtInsert->bindValue(":done", $done, PDO::PARAM_BOOL);

                    if ($stmtInsert->execute()) {
                        if($stmtInsert->rowCount() == 1) {
                            echo "Added Todo with id: {$conn->lastInsertId()}" ;
                        } else {
                            echo "Not Updated";
                        }
                    } else {
                        echo "Error";
                    }
                } else {
                    echo "Invalid input";
                }
            } else if ($action === "DeleteTodo") {
                if (isset($_POST["todoId"]) && !filter_input(INPUT_POST, "TodoId", FILTER_VALIDATE_INT)) {
                    $todoId = (int)$_POST["todoId"];

                    $sqlDelete = "DELETE FROM Todos WHERE TodoId = :todoId";

                    $stmtDelete = $conn->prepare($sqlDelete);
                    $stmtDelete->bindValue(":todoId", $todoId, PDO::PARAM_INT);

                    if ($stmtDelete->execute()) {
                        if($stmtDelete->rowCount() == 1) {
                            echo "Record deleted successful";
                        } else {
                            echo "Record not deleted";
                        }
                    } else {
                        echo "Error";
                    }
                } else {
                    echo "Invalid Input";
                }
            } else if ($action === "EditTodo") {
                if (isset($_POST["todoId"]) && !filter_input(INPUT_POST, "TodoId", FILTER_VALIDATE_INT)) {
                    $todoId = (int)$_POST["todoId"];

                    $sqlEdit = "SELECT TodoId, Description, Done FROM Todos WHERE TodoId = :todoId";

                    $stmtEdit = $conn->prepare($sqlEdit);
                    $stmtEdit->bindValue(":todoId", $todoId, PDO::PARAM_INT);

                    //$stmtEdit->setFetchMode(PDO::FETCH_ASSOC); ////not needed, set with $options, but enables you to change fetch mode from default specified

                    if ($stmtEdit->execute()) {
                        if($stmtEdit->rowCount() == 1) {
                            $rowToEdit = $stmtEdit->fetch(PDO::FETCH_ASSOC); //not needed parameter, set with $options, but enables you to change fetch mode from default (another way)
                        } else {
                            $rowToEdit = null;
                            echo "Record not found";
                        }
                    } else {
                        echo "Error";
                    }
                } else {
                    echo "Invalid Input";
                }
            } else if ($action === "UpdateTodo") {
                if (isset($_POST["todoId"], $_POST["description"]) &&
                    !filter_input(INPUT_POST, "TodoId", FILTER_VALIDATE_INT) &&
                    !empty(validate($_POST["description"]))) {
                    $todoId = (int)$_POST["todoId"];

                    $description = validate($_POST["description"]);

                    $done = isset($_POST["done"]);

                    $sqlEdit = "UPDATE Todos SET Description = :description, Done = :done WHERE TodoId = :todoId";

                    $stmtEdit = $conn->prepare($sqlEdit);

                    $stmtEdit->bindValue(":description", $description, PDO::PARAM_STR);
                    $stmtEdit->bindValue(":done", $done, PDO::PARAM_BOOL);
                    $stmtEdit->bindValue(":todoId", $todoId, PDO::PARAM_INT);

                    if ($stmtEdit->execute()) {
                        if($stmtEdit->rowCount() == 1) {
                            echo "Updated";
                        } else {
                            echo "Not Updated";
                        }
                    } else {
                        echo "Error";
                    }
                } else {
                    echo "Invalid Input";
                }
            }
        }
    } else if ($_SERVER["REQUEST_METHOD"] === "GET") {
        if (isset($_GET["todoId"]) && !filter_input(INPUT_GET, "TodoId", FILTER_VALIDATE_INT)) {
            $todoId = (int)$_GET["todoId"];

            $sqlEdit = "SELECT TodoId, Description, Done FROM Todos WHERE TodoId = :todoId";

            $stmtEdit = $conn->prepare($sqlEdit);
            $stmtEdit->bindValue(":todoId", $todoId, PDO::PARAM_INT);

            if ($stmtEdit->execute()) {
                $rowToEdit = $stmtEdit->fetch();
            } else {
                echo "Error";
            }
        } else {
            echo "Invalid Input";
        }
    }

    $sql = "SELECT TodoId, Description, Done FROM Todos ORDER BY TodoId";

    $stmtSelect = $conn->prepare($sql);
    $stmtSelect->execute();

    $result = $stmtSelect->setFetchMode();

    $rows = $stmtSelect->fetchAll();

    $numRecords1 = $stmtSelect->rowCount();

    //count with SQL
    $stmtCount = $conn->prepare("SELECT COUNT(1) FROM Todos");
    $stmtCount->execute();
    $numRecords2 = $stmtCount->fetchColumn();

} catch (PDOException $ex) {
    echo "Connection failed:  $ex";
    die();
} finally {
    if($conn != null) {
        $conn = null;
    }
}
?>

<h1>Num of Todos method1: <?= $numRecords1 ?></h1>
<h1>Num of Todos method2: <?= $numRecords2 ?></h1>

<ul>
    <? foreach ($rows as $row) { ?>
        <li>
            <?= $row["Description"] ?>
            <form method="post">
                <input type="hidden" name="todoId" value="<?= $row["TodoId"] ?>">
                <button type="submit" name="ACTION" value="DeleteTodo">Delete</button>
                <button type="submit" name="ACTION" value="EditTodo">Edit</button>
            </form>
            <a href="todoExample.php?action=EditTodo&todoId=<?= $row['TodoId'] ?>">Edit</a>
        </li>
    <? } ?>
</ul>

<form method="post">
    <? if($rowToEdit === null) { ?>
        <input type="hidden" name="ACTION" value="AddTodo">
    <? } else { ?>
        <input type="hidden" name="todoId" value="<?= $rowToEdit["TodoId"] ?>" >
        <input type="hidden" name="ACTION" value="UpdateTodo">
    <? } ?>


    <input name="description" type="text" <?= $rowToEdit != null ? "value=${rowToEdit['Description']}" : "" ?> >
    <input name="done" type="checkbox" <?= $rowToEdit != null && $rowToEdit["Done"] ? "checked" : "" ?> >
    <button type="submit">
        <?= $rowToEdit === null ? "Add" : "Update" ?>
    </button>
</form>
