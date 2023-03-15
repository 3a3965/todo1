<?php
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}else{
    exit();
}

$app = new \Psixoz\Todo\App();