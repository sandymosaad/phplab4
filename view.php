<?php
require 'conndb.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stm = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stm->execute([$id]);
    $user = $stm->fetch(PDO::FETCH_ASSOC);

    $stmSkills = $pdo->prepare("SELECT * FROM userSkills WHERE userId = ?");
    $stmSkills->execute([$id]);
    $skills = $stmSkills->fetchAll(PDO::FETCH_ASSOC);

    if ($user) {
        echo "<h2>User Information</h2>";
        echo "<ul>";
        foreach ($user as $key => $value) {
            echo "<li><strong>$key:</strong> $value</li>";
        }
        foreach ($skills as $skill) {
            echo "<li><strong>Skill:</strong> " .($skill['skill']) . "</li>";
        }
        echo "</ul>";
    } 
} 
?>