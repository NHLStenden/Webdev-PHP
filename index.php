<html>
<head>
    <title>Overzicht van voorbeelden</title>
</head>
<body>
<h1>Overzicht van voorbeelden, de code staat ook vaak in de  <a href="https://slides.com/jorislops/php#/">slides</a> </h1>

<?php

function getDirContents($dir, &$results = array()){
    $files = scandir($dir);
    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
            $results[] = $path;
        } else if(strpos($value,".") === false) {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }
    return $results;
}

$result = getDirContents(__DIR__);
$directories = glob(__DIR__);
$dir = "";

foreach($result as $file){
    if(!is_dir($file)){
        if($dir != substr($file, 0, strrpos($file, "/")+1) && strpos($file,"Templates") === false){
            $dir = substr($file, 0, strrpos($file, "/")+1);
            $url = substr($dir, strlen(__DIR__));
            echo "<p>$url</p>";
        }
        if(strpos($file ,".twig") === false){
            $filename = substr($file,strrpos($file, "/")+1);
            $url = substr($file, strlen(__DIR__));
            echo "<a href='$url'>$filename</a>";
            echo "</br>";
        }
    }
}
?>
</body>
</html>