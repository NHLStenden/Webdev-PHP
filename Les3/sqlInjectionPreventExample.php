<?php
//sqlInjectionPreventExample.php
$host = "localhost";
$databaseName = "TodoDb";
$connectionString = "mysql:host=$host;dbname=$databaseName";
$username = "student";     //root is default in most cases
$password = "student";     //root is default in most cases

function validate($str) {
    return trim(htmlspecialchars($str));
}

if(isset($_GET["searchDescription"]) && $_GET["searchDescription"])
{
    $searchDescription = $_GET["searchDescription"];

    //default username, password for wamp is root, empty/blank
    try {
        $conn = new PDO($connectionString, $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Add the following string to the querystring searchDescription:    "' OR 1 = 1; --"
        //Or something like this: "'; DROP TABLE Todos; --"
        $sql = "SELECT TodoId, Description, Done FROM Todos WHERE Description = :searchDescription AND Done = :done";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue("searchDescription", $searchDescription, PDO::PARAM_STR);
        //$stmt->bindValue("done", true, PDO::PARAM_BOOL);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        foreach ($stmt->fetchAll() as $row) {
            echo $row["Description"]
                ."&nbsp;"
                .($row["Done"] ? "completed" : "")
                ."<br/>";
        }

    } catch (PDOException $ex) {
        echo "PDOException:  $ex";
    }
} else {
    echo "invalid input!";
}
?>

<form method="get">
    <input name="searchDescription" type="text">
    <button type="submit">Search</button>
</form>
