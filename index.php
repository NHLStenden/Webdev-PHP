<?php
function getFileList($dir)
{
    // array to hold return value
    $retval = [];

    // add trailing slash if missing
    if(substr($dir, -1) != "/") {
        $dir .= "/";
    }

    // open pointer to directory and read list of files
    $d = dir($dir) or die("getFileList: Failed opening directory {$dir} for reading");
    while(FALSE !== ($entry = $d->read())) {
        // skip hidden files
        if($entry{0} == ".") continue;
        if(is_dir("{$dir}{$entry}")) {
            $retval[] = [
                'name' => "{$dir}{$entry}/",
                'type' => filetype("{$dir}{$entry}"),
                'size' => 0,
                'lastmod' => filemtime("{$dir}{$entry}"),
                'is_dir' => true,
                'children' => getFileList("{$dir}{$entry}/")
            ];
        } elseif(is_readable("{$dir}{$entry}")) {
            $pathInfo = pathinfo("{$dir}{$entry}");
            $retval[] = [
                'name' => "{$dir}{$entry}",
                'filename' => "{$entry}",
                'type' => mime_content_type("{$dir}{$entry}"),
                'size' => filesize("{$dir}{$entry}"),
                'lastmod' => filemtime("{$dir}{$entry}"),
                'is_dir' => false,
                'extension' => $pathInfo['extension']
            ];
        }
    }
    $d->close();

    return $retval;
}

function displayTree(array $tree, string $rootDir) {
    //sort on name
    usort($tree, function($a, $b) {return strcmp($a['name'], $b['name']);});

    echo "<ul>";
    foreach ($tree as $node) {
        if(isset($node['name'])) {
            $relativePath =  substr($node['name'], strlen($rootDir)+1);
            if($node['is_dir']) {
                echo "<li>" .$relativePath ."</li>";
            } else {
                echo "<li><a href='$relativePath'>"  .$node['filename']   ."</a></li>";
            }

            if($node['is_dir']) {
                displayTree($node['children'], $rootDir);
            }
        }
    }
    echo "</ul>";
}

$rootDir = __DIR__;
$tree = getFileList($rootDir);

displayTree($tree, $rootDir);