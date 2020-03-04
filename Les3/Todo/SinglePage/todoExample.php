<?php
//todoExample.php

$host = "localhost";
$databaseName = "TodoDb";
$dns = "mysql:host=$host;dbname=$databaseName";
$username = "root";     //for mamp
$password = "root";     //for mamp

$rowToEdit = null;

$errors = [];

$conn = null;

$description = "";
$done = false;

try {
    $conn = new PDO($dns, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["ACTION"])) {
            $action = $_POST["ACTION"];

            if ($action === "AddTodo") {
                if(!empty($_POST["description"])) {
                    $description = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
                    if($description === false) {
                        $errors[] = "Description has a problem";
                        $description = "";
                    }
                } else {
                    //add item to array $errors
                    $errors[] = "Description is empty";
                }

                if(!empty($_POST["done"])) {
                    $done = filter_var($_POST["done"], FILTER_VALIDATE_BOOLEAN);
                    if($done === false) {
                        //add item to array $errors
                        $errors[] = "Incorrect done";
                        $done = false;
                    }
                }

                if(count($errors) == 0) {
                    $sqlInsert = "INSERT INTO Todos (Description, Done) VALUES (:description, :done)";
                    $stmtInsert = $conn->prepare($sqlInsert);
                    $stmtInsert->bindValue(":description", $description, PDO::PARAM_STR);
                    $stmtInsert->bindValue(":done", $done, PDO::PARAM_BOOL);

                    if ($stmtInsert->execute()) {
                        if($stmtInsert->rowCount() == 1) {
                            echo "Added Todo with id: {$conn->lastInsertId()}" ;
                        } else {
                            echo "Not Updated";
                        }
                    } //else is error thrown (PDOException)
                }
            } else if ($action === "DeleteTodo") {
                if(!empty($_POST["todoId"])) {
                    $todoId = filter_var($_POST["todoId"], FILTER_VALIDATE_INT);
                    //$todoId = (int)$_POST["todoId"]; //cast is done by filter_var to correct type, if successful

                    if($todoId === false) {
                        //add item to array $errors
                        $errors[] = "invalid todoId";
                    } else {
                        $sqlDelete = "DELETE FROM Todos WHERE TodoId = :todoId";

                        $stmtDelete = $conn->prepare($sqlDelete);
                        $stmtDelete->bindValue(":todoId", $todoId, PDO::PARAM_INT);

                        if ($stmtDelete->execute()) {
                            if($stmtDelete->rowCount() == 1) {
                                echo "Record deleted successful";
                            } else {
                                echo "Record not deleted";
                            }
                        } //else is error thrown (PDOException)
                    }
                } else {
                    //add item to array $errors
                    $errors[] = "todoId is empty";
                }
            } else if ($action === "EditTodo") {
                if (isset($_POST["todoId"])) {

                    $todoId = filter_var($_POST['TodoId'], FILTER_VALIDATE_INT);
                    if($todoId === false) {
                        //add item to array $errors
                        $errors[] = "todoId is has invalid";
                    } else {
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
                        } //else is error thrown (PDOException)
                    }
                } else {
                    $errors[] = "todoId is empty";
                }
            } else if ($action === "UpdateTodo") {
                if(!empty($_POST["todoId"])) {
                    $todoId = filter_var($_POST['TodoId'], "TodoId", FILTER_VALIDATE_INT);
                    if($todoId === false) {
                        //add item to array $errors
                        $errors[] = "todoId is has invalid";
                    }
                }

                if(!empty($_POST["description"])) {
                    $description = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
                    if($description === false) {
                        $errors[] = "Description has a problem";
                        $description = "";
                    }
                } else {
                    $errors[] = "Description is empty";
                }

                if(!empty($_POST["done"])) {
                    $done = filter_var($_POST["done"], FILTER_VALIDATE_BOOLEAN);
                    if($done === false) {
                        $errors[] = "incorrect done";
                        $done = false;
                    }
                }

                if(count($errors) == 0) {
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
                    } //else is error thrown (PDOException)
                }
            }
        }
    } else if ($_SERVER["REQUEST_METHOD"] === "GET") {
        if (isset($_GET["todoId"])) {
            $todoId = filter_var($_GET['todoId'], FILTER_VALIDATE_INT);
            if($todoId === false) {
                //add item to array $errors
                $errors[] = "todoId is has invalid";
            } else {
                $sqlEdit = "SELECT TodoId, Description, Done FROM Todos WHERE TodoId = :todoId";

                $stmtEdit = $conn->prepare($sqlEdit);
                $stmtEdit->bindValue(":todoId", $todoId, PDO::PARAM_INT);

                if ($stmtEdit->execute()) {
                    $rowToEdit = $stmtEdit->fetch();
                } //else is error thrown (PDOException)
            }
        }
    }

    $sql = "SELECT TodoId, Description, Done FROM Todos ORDER BY TodoId";

    $stmtSelect = $conn->prepare($sql);
    $stmtSelect->execute();

    $rows = $stmtSelect->fetchAll();

    $numRecords1 = $stmtSelect->rowCount();

    //count with SQL
    $stmtCount = $conn->prepare("SELECT COUNT(1) FROM Todos WHERE Done = TRUE");
    $stmtCount->execute();
    $numRecords2 = $stmtCount->fetchColumn();

} catch (PDOException $ex) {
    echo "PDOException:  $ex";
    die();
} finally {
    if($conn != null) {
        $conn = null;
    }
}
?>

<?
    if(count($errors) > 0) {
        echo "<h1>Errors:</h1>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
?>

<h1>Num of Todos (in total): <?= $numRecords1 ?></h1>
<h1>Num of Todos (completed): <?= $numRecords2 ?></h1>

<ul>
    <? foreach ($rows as $row) { ?>
        <li>
            <?= $row["Description"] ?> --- <?= $row["Done"] ?>
            <form method="post">
                <input type="hidden" name="todoId" value="<?= $row["TodoId"] ?>">
                <button type="submit" name="ACTION" value="DeleteTodo">Delete</button>
                <button type="submit" name="ACTION" value="EditTodo">Edit</button>
            </form>
            <a href="todoExample.php?action=EditTodo&todoId=<?= $row['TodoId'] ?>">Edit</a>
        </li>
        <hr>
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
