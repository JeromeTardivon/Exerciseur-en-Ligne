<?php
header('Location: /index.php');
session_start();
$_SESSION = array();
session_destroy();
exit();