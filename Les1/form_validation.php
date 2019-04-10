<?php
    $nameErr = $ageErr = "";
    $name = $age = "";
    $error = true;

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $error = false;

        if(empty($_POST["name"])) {
            $nameErr = "name is required";
            $error = true;
        } else {
            $name = test_input($_POST["name"]);
        }

        if(empty($_POST["age"])) {
            $ageErr = "age is required";
            $error = true;
        } else {
            $age = test_input($_POST["age"]);
            //$age is still a string

            if(is_int($age)) {
                $age = (int)$age; //bad programing practice to change type of a variable!
                if($age < 18) {
                    $ageErr = "to young";
                    $error = true;
                }
            } else {
                $ageErr = "no integer";
            }
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>

<form method="post">
    Name: <input type="text" name="name">* <?php echo $nameErr ?>
    Age: <input name="age">* <?= $ageErr ?>
    <button type="submit">Submit</button>
</form>

<?php
    if(!$error) {
        echo "Name: $name <br/> Age: $age ";
    }
?>