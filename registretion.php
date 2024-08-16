<?php
session_start();

if (isset($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $key => $error) {
        echo "<p style='color:red;'>{$error}</p>";
    }
    unset($_SESSION['errors']); 
}
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user = null;

if ($id > 0) {
    $stm = $pdo->prepare("SELECT username, fname, lname, address, country, gender, department FROM users WHERE id = ?");
    $stm->execute([$id]);
    $user = $stm->fetch(PDO::FETCH_ASSOC);
}
?>

<form method="POST" action="controller.php" enctype="multipart/form-data">
    <input type="hidden" name="page" value="register">

    <label for="firstname">First Name:</label>
    <input type="text" id="firstname" name="fname" required><br><br>

    <label for="lastname">Last Name:</label>
    <input type="text" id="lastname" name="lname" required><br><br>

    <label for="address">Address:</label>
    <textarea id="address" name="address" rows="4" cols="50" required></textarea><br><br>

    <label for="country">Country:</label>
    <select id="country" name="country" required>
        <option value="">Select Country</option>
        <option value="Egypt">Egypt</option>
        <option value="USA">USA</option>
    </select><br><br>

    <label>Gender:</label>
    <input type="radio" id="male" name="gender" value="male" required>
    <label for="male">Male</label>
    <input type="radio" id="female" name="gender" value="female" required>
    <label for="female">Female</label><br><br>


    <label>Skills:</label><br>
    <input type="checkbox" id="php" name="skills[]" value="PHP">
    <label for="php">PHP</label><br>
    <input type="checkbox" id="mysql" name="skills[]" value="MySQL">
    <label for="mysql">MySQL</label><br>
    <input type="checkbox" id="j2se" name="skills[]" value="J2SE">
    <label for="j2se">J2SE</label><br>
    <input type="checkbox" id="postgresql" name="skills[]" value="PostgreSQL">
    <label for="postgresql">PostgreSQL</label><br><br>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="department">Department:</label>
    <input type="text" id="department" name="department" value="OpenSource"><br><br>

    <label for="img">Upload your picture:</label>
    <input type="file" id="img" name="img"><br><br>

    <button type="submit" name="register">Submit</button>
    <button type="reset">Reset</button>

</form>