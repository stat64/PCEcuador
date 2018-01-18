<?php
session_start();
error_reporting(E_PARSE);
if (!$_SESSION['nombreUser'] == "") {
    
} else {
    header("Location: index.php");
    exit();
}