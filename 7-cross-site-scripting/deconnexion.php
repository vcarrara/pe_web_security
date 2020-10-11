<?php
session_start();
$_SESSION = array();
session_destroy();

header('Location: /7-cross-site-scripting/index.php');
