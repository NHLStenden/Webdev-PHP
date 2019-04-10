<html>
<body>

<?php
    if(isset($_GET['name'])) {
        echo $_GET['name'];
    }
?>

<form method="get">
    Name: <input type="text" name="name"><br>
    <input type="submit">
</form>

</body>
</html>