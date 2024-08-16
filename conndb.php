<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=lab4php", "root", "511911");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo("hi ");
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>