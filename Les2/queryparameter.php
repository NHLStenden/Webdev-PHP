<!-- queryparameter.php -->
<?php
$count = (int)($_GET["count"] ?? 0);

$count++;
?>
<?= $count ?>
<hr>
<form method="get">
    <input type="hidden" name="count" value="<?= $count ?>"/>
    <button type="submit">Inc</button>
</form>
</hr>
<a href="queryparameter.php?count=<?= $count ?>">Inc</a>
