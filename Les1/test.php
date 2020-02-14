<?php

$voornaam = isset($_POST["voornaam"]) ? $_POST["voornaam"] : "Voornaam Leeg";

$achternaam = "Achternaam Leeg";
if(isset($_POST["achternaam"])) {
    $achternaam = $_POST["achternaam"];
}


print "$achternaam $voornaam";

?>

<form method="post">
    <input name="voornaam" type="text"><br>
    <input name="achternaam" type="text"><br>
    <input type="submit" title="Verzenden"/>
<!--    <button type="submit">Verzenden</button>-->
</form>
