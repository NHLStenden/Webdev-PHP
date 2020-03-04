<!-- form_validation2.php -->
<?php
    $name = $price = $description = $email = "";
    $errorPrice = $errorDescription = $errorEmail = $errorName = "";

    $minPrice = 1.0; $maxPrice = 100.0;

    $error = false;

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        //SANITIZE
        if(empty($_POST['name'])) {
            $errorName = "Name Required";
            $error = true;
        } else {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            if($name === false) {
                $errorName = "Error in name";
                $error = true;
                $name = "";
            }
        }

        //SANITIZE
        if(empty($_POST['description'])) {
            $errorDescription = "Description is empty";
            $error = true;
        } else {
            $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
            if($description === false) {
                $errorDescription = "Error in Description";
                $error = true;
            }
        }

        //VALIDATE FLOAT!
        if(!empty($_POST['price'])) {
            $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);

            if($price === false) {
                $errorPrice = "No valid Price between $minPrice and $maxPrice";
                $error = true;
            }
        }

        //VALIDATE EMAIL!
        if(!empty($_POST['email'])) {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            if($email === false) {
                $errorEmail = "Invalid Email";
                $error = true;
            }
        }
    }
?>


<? if($error) {
    print "<b>Invalid input</b>";
}
?>

<form method="post">
    <label>Name*</label> <input type="text" name="name" value="<?= $name ?>">
    <span class="error"><?= $errorName ?></span>
    <br/>

    <label>Description*</label>  <input type="text" name="description" value="<?= $description ?>">
    <? if(!empty($errorDescription)) { ?>
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