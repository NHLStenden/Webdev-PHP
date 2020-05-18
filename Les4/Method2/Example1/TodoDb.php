<?php

class Todo {
    public $todoId;
    public $description;
    public $done;
}

class TodoDb
{
    //can be put into include("db.inc.php") and loaded in constructor!
    public $host = "localhost";
    public $databaseName = "TodoDb";
    public $username = "root";     //for mamp
    public $password = "root";     //for mamp

    /**
     * @return string
     */
    private function getConnectionString()
    {
        return "mysql:host=$this->host;dbname=$this->databaseName";
    }

    /**
     * @return PDO
     */
    private function createConnection()
    {
        $conn = new PDO($this->getConnectionString(), $this->username, $this->password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn;
    }

    /**
     * @param TodoDb $instance
     * @return array of Todo items
     */
    public static function getTodos($instance) : array
    {
        $sql = "SELECT todoId, description, done FROM Todos ORDER BY TodoId";

        $conn = $instance->createConnection();
        $stmtSelect = $conn->prepare($sql);
        $stmtSelect->execute();

        $rows = $stmtSelect->fetchAll(PDO::FETCH_CLASS, "Todo");

        $conn = null;
        return $rows;
    }


    /**
     * @param int $todoId
     * @return Todo|null
     */
    public function getTodo(int $todoId) : ?Todo {
        $sqlEdit = "SELECT todoId, description, done FROM Todos WHERE TodoId = :todoId";

        $conn = $this->createConnection();
        $stmtEdit = $conn->prepare($sqlEdit);
        $stmtEdit->bindValue(":todoId", $todoId, PDO::PARAM_INT);

        if ($stmtEdit->execute()) {
            $result = $stmtEdit->fetchObject("Todo");
            if($result === false)
            {
                $result = null;
            }
        } else {
            $result = null;
        }

        $conn = null;
        return $result;
    }

    /**
     * @param $todoId
     * @return bool
     */
    public function deleteTodo(int $todoId) : bool
    {
        $sqlDelete = "DELETE FROM Todos WHERE TodoId = :todoId";

        $conn = $this->createConnection();
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bindValue(":todoId", $todoId, PDO::PARAM_INT);

        $result = false;
        if ($stmtDelete->execute() && $stmtDelete->rowCount() == 1) {
            $result = true;
        }

        $conn = null;
        return $result;
    }

    public function addTodo(string $description, bool $done)
    {
        $sqlInsert = "INSERT INTO Todos (Description, Done) VALUES (:description, :done)";

        $conn = $this->createConnection();
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bindValue(":description", $description, PDO::PARAM_STR);
        $stmtInsert->bindValue(":done", $done, PDO::PARAM_BOOL);

        $result = -1;
        if ($stmtInsert->execute() && $stmtInsert->rowCount() == 1) {
            $result = $conn->lastInsertId();
        }

        $conn = null;
        return $result;
    }

    public function updateTodo(Todo $todo) {
        $sqlEdit = "UPDATE Todos SET Description = :description, Done = :done WHERE TodoId = :todoId";

        $stmtEdit = $conn = $this->createConnection()->prepare($sqlEdit);

        $stmtEdit->bindValue(":description", $todo->description, PDO::PARAM_STR);
        $stmtEdit->bindValue(":done", $todo->done, PDO::PARAM_BOOL);
        $stmtEdit->bindValue(":todoId", $todo->todoId, PDO::PARAM_INT);

        $result = false;
        if ($stmtEdit->execute() && $stmtEdit->rowCount() == 1) {
            $result = true;
        }

        $conn = null;
        return $result;
    }
}