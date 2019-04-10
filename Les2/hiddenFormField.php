<?php
    $count = (int)($_POST["count"] ?? 0);

    $count++;
?>

<?= $count ?>
<hr/>

<form method="post">
    <input type="hidden" name="count" value="<?= $count ?>"/>

    <button>Inc</button>
</form>

