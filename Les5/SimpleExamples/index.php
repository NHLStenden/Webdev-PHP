<?php

?>

<!-- Import JQUERY -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

<p id="text-load"></p>
<p id="text-post"></p>
<p id="text-json"></p>

<script>
    $(document).ready(function() {

        // Load: Loads data and inserts it into an element
        // https://www.w3schools.com/jquery/jquery_ajax_load.asp
        // Syntax: $(selector).load(URL,data,callback);
        // URL: file to load (can be php, txt or other things)
        // data: data that gets sent
        // callback: optional function to do after the request is complete

        $("#text-load").load("textGenerator.php", {
            // Here is data that gets sent as key value pairs
            // "action" is not a required thing, it's a variable I use myself so that textGenerator.php
            //  knows what action to do. You can give it a different name or not use it at all.
            action: "load",
            food: "pizza"
        });

        // Post: Makes a POST request
        // https://www.w3schools.com/jquery/ajax_post.asp
        // Syntax: $.post(URL,data,callback);
        // Again, callback is an optional function of what to do after the request
        $.post("textGenerator.php", {
            // Data
            action: "calculateSum",
            number1: 5,
            number2: 6
        }, function(data) {
            // This is the code that happens after the request
            // By using "data" as parameter (though you can give it any name you want, as long as it's the first argument)
            // you can access data that gets returned
            $("#text-post").text("Sum: " + data);
        });

        // It's also possible to receive a JSON object as data, and include a "status" parameter
        $.post("textGenerator.php", {
            action: "sendPersonInfo"
        }, function(data, status) {
            if (status != "success") {
                // You can output an error message here if something went wrong with the request
            }

            else {
                // With a JSON object you can access different parameters with a dot, like data.name
                $("#text-json").text("Name: " + data.name + ", Age: " + data.age + ", Country: " + data.country);
            }
        }, "json") // Make sure to include json here if you use json

    });
</script>
