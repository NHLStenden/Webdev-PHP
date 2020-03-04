<!-- form_validation.php -->
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
            $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
        }

        if(empty($_POST["age"])) {
            $ageErr = "age is required";
            $error = true;
        } else {
            $age = filter_var($_POST["age"], FILTER_VALIDATE_INT);

            if($age === false) {
                $ageErr = "age is incorrect";
                $age = "";
                $error = true;
            } else {
                if($age < 18) {
                    $ageErr = "to young";
                    $error = true;
                }
            }
        }
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