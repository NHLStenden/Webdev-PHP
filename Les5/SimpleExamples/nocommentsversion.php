<?php

?>

<!-- Import JQUERY -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

<p id="text-load"></p>
<p id="text-post"></p>
<p id="text-json"></p>

<script>
    $(document).ready(function() {

        $("#text-load").load("textGenerator.php", {
            action: "load",
            food: "pizza"
        });

        $.post("textGenerator.php", {
            action: "calculateSum",
            number1: 5,
            number2: 6
        }, function(data) {
            $("#text-post").text("Sum: " + data);
        });

        $.post("textGenerator.php", {
            action: "sendPersonInfo"
        }, function(data, status) {
            if (status != "success") {
                // You can output an error message here if something went wrong with the request
            }

            else {
                $("#text-json").text("Name: " + data.name + ", Age: " + data.age + ", Country: " + data.country);
            }
        }, "json")

    });
</script>
