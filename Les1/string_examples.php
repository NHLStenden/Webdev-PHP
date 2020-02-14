<pre>
<?php

$hw = "Hello World";

$h = "Hello";
$s = " ";
$w = "World";
$hw2 = $h . $s . $w;     //concat
$hw3 = "Hello $w";    //string interpolation

echo $hw2 ."\n";
print($hw3 ."\n");

//string functions
echo strlen("Hello World!\n");
echo str_word_count("Hello world!\n");
echo strrev("Hello world!") ."\n";

//https://www.w3schools.com/php7/php7_ref_string.asp

echo "test $h \n";
//echo "test $(1+2)"; not possible
?>
</pre>
