<?php 

$path = __dir__;
$dir = dir($path);

while ($file = $dir->read()) {
    if($file != '.' && $file != '..' && $file != "index.php"){
        require "$path/$file";
    }
}