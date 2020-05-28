<?php
$host = "localhost";
$databaseName = "TodoDb";
$connectionString = "mysql:host=$host;dbname=$databaseName";
$username = "student";     //root is default in most cases
$password = "student";     //root is default in most cases

$errors = [];
$description = "";
$done = false;

$todoId = ($_POST["todoId"] ??
            $_GET["todoId"] ??
                false);
if($todoId === false) {
    echo "TodoId: $todoId is incorrect!";
    die();
}

$todoId = filter_var($todoId, FILTER_VALIDATE_INT);
if($todoId === false) {
    echo "TodoId: $todoId is incorrect!";
    die();
}

if(isset($_POST["ACTION"]) && $_POST["ACTION"] === "EditTodo")
{
    //filter description
    if(!empty($_POST["description"])) {
        $description = filter_var($_POST["description"],FILTER_SANITIZE_STRING);
        if($description === false) {
            $errors["description"] = "incorrect description";
            $description = $_POST["description"];
        }
    } else {
        $errors["description"] = "description can not be empty";
    }

    //filter done
    if(!empty($_POST["done"])) {
        $done = filter_var($_POST["done"], FILTER_VALIDATE_BOOLEAN);
        if($done === false) {
            $errors["done"] = "incorrect done";
            $done = $_POST["done"];
        }
    }

    if(count($errors) == 0) {
        try {
            $conn = new PDO($connectionString, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sqlSelect = "INSERT INTO Todos (Description, Done) VALUES (:description, :done)";

            $stmtSelectTodo = $conn->prepare($sqlSelect);
            $stmtSelectTodo->bindValue(":description", $description, PDO::PARAM_STR);
            $stmtSelectTodo->bindValue(":done", $done, PDO::PARAM_BOOL);

            $stmtSelectTodo->execute();
            if ($stmtSelectTodo->rowCount() == 1) {
                echo "Added</br>";
                echo "Description: $description Done: $done </br>";
                echo "With id: {$conn->lastInsertId()}";
            } else {
                echo "Not Updated";
            }
        } catch (PDOException $exception) {
            echo "PDOException: $exception";
        } finally {
            if($conn != null) {
                $conn = null;
            }
        }
    } else {
        echo "<h1>Errors:</h1>";
        foreach ($errors as $error) {
            echo $error . "</br>";
        }
    }
} else {
    try {
        $conn = new PDO($connectionString, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sqlSelect = "SELECT TodoId, Description, Done FROM Todos WHERE TodoId = :todoId";

        $stmtSelectTodo = $conn->prepare($sqlSelect);
        $stmtSelectTodo->bindValue(":todoId", $todoId, PDO::PARAM_INT);
        $stmtSelectTodo->execute();
        $row = $stmtSelectTodo->fetch();

        $description = $row["Description"];
        $done = $row["Done"];
    } catch (PDOException $exception) {
        echo "PDOException: $exception";
    } finally {
        if($conn != null) {
            $conn = null;
        }
    }
}

function displayError($inputName) {
    global $errors; //liever geen globals gebruiken! Hier kan het niet anders :-(

    if(isset($errors[$inputName])) {
        return $errors[$inputName];
    }
}
?>

<h1>Create Todo Item</h1>
<form method="post">
    <input type="hidden" name="ACTION" value="EditTodo">
    <input type="hidden" name="todoId" value="<?= $todoId ?>">

    <?= displayError("description") ?>
    <input name="description" type="text" value="<?= $description ?>">
    <?= displayError("done") ?>
    <input name="done" type="checkbox" <? if($done) { echo "checked"; } ?> >
    <button type="submit">Add</button>
</form>
</hr>
<h1><a href='index.php'>Terug naar het overzicht</a></h1><br>