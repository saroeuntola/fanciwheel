<?php
$host = $_SERVER['HTTP_HOST'];

if (strpos($host, 'localhost') !== false) {
    $baseURL = '/spinwheel';
} else {
    $baseURL = 'https://fanciwheel.com';
}
?>



