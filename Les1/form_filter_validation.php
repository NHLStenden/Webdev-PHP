<!-- form_filter_validation.php -->
<?php
    $name = $price = $description = $email = "";
    $errorPrice = $errorDescription = $errorEmail = $errorName = "";

    $minPrice = 1; $maxPrice = 100;

    $error = false;

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        if(empty($name)) {
            $errorName = "Required";
            $error = true;
        }

        $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, array("options" => array("min_range"=>$minPrice, "max_range"=>$maxPrice)));
        if($price === false) {
            $errorPrice = "No valid Price between $minPrice and $maxPrice";
            $error = true;
        }


        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        if($description === false) {
            $errorDescription = "Error in Description";
            $error = true;
        }
        if(empty($description)) {
            $errorDescription = "Description is empty";
            $error = true;
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if($email === false) {
            $errorEmail = "Invalid Email";
            $error = true;
        }
    }
?>


<? if($error) {
    print "<b>Invalid input</b>";
}
?>

<form method="post">
    <label>Name:</label> <input type="text" name="name" value="<?= $name ?>">
    <span class="error"><?= $errorName ?></span>
    <br/>

    <label>Description</label>  <input type="text" name="description" value="<?= $description ?>">
    <? if(isset($errorDescription)) { ?>
        <span class="error"><?= $errorDescription ?></span>
    <? } ?>
    <br/>

    <label>Price</label> <input type="text" name="price" value="<? echo $price ?>">
    <span class="error"><?= $errorPrice ?></span>
    <br/>

    <label>Email</label> <input type="text" name="email" value="<?= $email ?>">
    <?= isset($errorEmail) ? "<span class='error'>$errorEmail</span>" : '' ?>
    <br/>

    <button type="submit">Add Product</button>
</form>

<style>
    .error {
        background-color: red;
    }
</style>