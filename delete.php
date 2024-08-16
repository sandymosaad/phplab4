<?php
require 'conndb.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {  
    $stm = $pdo->prepare("DELETE FROM users WHERE id = ?");  
    $stm->execute([$id]);  

    header("Location: userlist.php");  
    exit();  
} else {
    echo "Invalid ID.";  
}
?>