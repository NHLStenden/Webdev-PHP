<?php

include "TodoDb.php";

function validate($str) {
    return trim(htmlspecialchars($str));
}

require_once ($_SERVER['DOCUMENT_ROOT'] .'/vendor/autoload.php');

//$twig->addExtension(new \Twig\Extension\EscaperExtension("html"));
$rowToEdit = null;

$todoDb = new TodoDb();

if($_SERVER["REQUEST_METHOD"] === "POST")
{
    if (isset($_POST["ACTION"]))
    {
        $action = $_POST["ACTION"];

        if ($action === "DeleteTodo" && isset($_POST["todoId"]) &&
            !filter_input(INPUT_POST, "TodoId", FILTER_VALIDATE_INT))
        {
            $todoId = (int)$_POST["todoId"];

            $todoDb->deleteTodo($todoId);
        }
        else if ($action === "AddTodo")
        {
            if (isset($_POST["description"]) && !empty($_POST["description"]))
            {
                $description = validate($_POST["description"]);
                $done = validate($_POST["done"] ?? false);

                $todoDb->addTodo($description, $done);
            }
        }
        else if ($action === "UpdateTodo")
        {
            if (isset($_POST["todoId"], $_POST["description"]) &&
                !filter_input(INPUT_POST, "TodoId", FILTER_VALIDATE_INT) &&
                !empty(validate($_POST["description"])))
            {
                $todo = new Todo();
                $todo->todoId = (int)$_POST["todoId"];
                $todo->description = validate($_POST["description"]);
                $todo->done = isset($_POST["done"]);

                $todoDb->updateTodo($todo);
            }
        }
        else if ($action === "EditTodo")
        {
            if (isset($_POST["todoId"]) &&
                !filter_input(INPUT_POST, "TodoId", FILTER_VALIDATE_INT))
            {
                $todoId = (int)$_POST["todoId"];
                $rowToEdit = $todoDb->getTodo($todoId);
            }
            else
            {
                echo "Invalid Input";
            }
        }
    }
}
else if ($_SERVER["REQUEST_METHOD"] === "GET") //kan net zo goed met een post (beide aanwezig in voorbeeld)
{
    if (isset($_GET["todoId"]))
    {
        if(!filter_input(INPUT_GET, "TodoId", FILTER_VALIDATE_INT))
        {
              $todoId = (int)$_GET["todoId"];
              $rowToEdit = $todoDb->getTodo($todoId);
        }
        else
        {
          echo "Invalid Input";
        }
    }
}

$loader = new \Twig\Loader\FilesystemLoader('Templates');
$twig = new \Twig\Environment($loader);

$template = $twig->load('todo.twig');

$todos = TodoDb::getTodos($todoDb);

echo $template->render(['todos'=> $todos, 'rowToEdit' => $rowToEdit]);