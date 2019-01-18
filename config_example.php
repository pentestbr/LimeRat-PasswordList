<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=darkspid_lime', 'darkspider', 'yourpassword');
$baseDir = __DIR__;
$userDir = $baseDir."/Users/"; // Import Users
$password = "DarkSpider"; //For Login