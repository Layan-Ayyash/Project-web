<?php
$databaseHost = 'localhost';
$databaseName = 'project1';
$databaseUsername = 'root';
$databasePassword = '';

try {
    $pdo = new PDO("mysql:host=$databaseHost;dbname=$databaseName", $databaseUsername, $databasePassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch(PDOException $e) {
    $e->getMessage();
    die();
}
?>
