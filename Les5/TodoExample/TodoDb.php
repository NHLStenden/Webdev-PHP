<?php

class Todo {
    public $todoId;
    public $description;
    public $done;

    //Todo: add constructor or properties to make variables strongly typed
    //now problems with typing in JSON result
}

class TodoDb
{
    //can be put into include("db.inc.php") and loaded in constructor!
    public $host = "localhost";
    public $databaseName = "TodoDb";
    public $username = "root";     //for mamp
    public $password = "root";     //for mamp

    private $conn = null;

    /**
     * @return string
     */
    private function getConnectionString()
    {
        $dns = "mysql:host=$this->host;dbname=$this->databaseName";
        return $dns;
    }

    /**
     * @return PDO
     */
    private function getConnection()
    {
        if($this->conn == null) {
            $this->conn = new PDO($this->getConnectionString(), $this->username, $this->password);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        //$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $this->conn;
    }

    /**
     * @return array of Todo items
     */
    public function getTodos() : array
    {
        $sql = "SELECT todoId, description, done FROM Todos ORDER BY TodoId";

        $conn = $this->getConnection();
        $stmtSelect = $conn->prepare($sql);
        $stmtSelect->execute();

        $rows = $stmtSelect->fetchAll(PDO::FETCH_CLASS, "Todo");

        return $rows;
    }


    /**
     * @param int $todoId
     * @return Todo|null
     */
    public function getTodo(int $todoId) : ?Todo {
        $sqlEdit = "SELECT todoId, description, done FROM Todos WHERE TodoId = :todoId";

        $conn = $this->getConnection();
        $stmtEdit = $conn->prepare($sqlEdit);
        $stmtEdit->bindValue(":todoId", $todoId, PDO::PARAM_INT);

        if ($stmtEdit->execute()) {
            $data = $stmtEdit->fetch();

            //$result = $stmtEdit->fetchObject("Todo");

            $result = new Todo();
            $result->todoId = (int)$data["todoId"];
            $result->description = $data["description"];
            $result->done = (boolean)$data["done"];

            //$result->todoId = (int)$result->$todoId;
            if($result === false)
            {
                $result = null;
            }
        } else {
            $result = null;
        }

        return $result;
    }

    /**
     * @param $todoId
     * @return bool
     */
    public function deleteTodo(int $todoId) : bool
    {
        $sqlDelete = "DELETE FROM Todos WHERE TodoId = :todoId";

        $conn = $this->getConnection();
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bindValue(":todoId", $todoId, PDO::PARAM_INT);

        $result = false;
        if ($stmtDelete->execute() && $stmtDelete->rowCount() == 1) {
            $result = true;
        }

        return $result;
    }

    public function addTodo(string $description, bool $done)
    {
        $sqlInsert = "INSERT INTO Todos (Description, Done) VALUES (:description, :done)";

        $conn = $this->getConnection();
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bindValue(":description", $description, PDO::PARAM_STR);
        $stmtInsert->bindValue(":done", $done, PDO::PARAM_BOOL);

        $result = -1;
        if ($stmtInsert->execute() && $stmtInsert->rowCount() == 1) {
            $result = $conn->lastInsertId();
        }

        return $result;
    }

    public function updateTodo(Todo $todo) {
        $sqlEdit = "UPDATE Todos SET Description = :description, Done = :done WHERE TodoId = :todoId";

        $stmtEdit = $conn = $this->getConnection()->prepare($sqlEdit);

        $stmtEdit->bindValue(":description", $todo->description, PDO::PARAM_STR);
        $stmtEdit->bindValue(":done", $todo->done, PDO::PARAM_BOOL);
        $stmtEdit->bindValue(":todoId", $todo->todoId, PDO::PARAM_INT);

        $result = false;
        if ($stmtEdit->execute() && $stmtEdit->rowCount() == 1) {
            $result = true;
        }

        return $result;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}