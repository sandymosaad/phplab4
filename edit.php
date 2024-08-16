<?php
require 'conndb.php';
session_start();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = isset($_POST['username']) ? $_POST['username'] : '';
    $pass = isset($_POST['password']) ? $_POST['password'] : '';
    $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
    $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $dep = isset($_POST['department']) ? $_POST['department'] : '';
    $skills = isset($_POST['skills']) ? implode(',', $_POST['skills']) : '';

    if ($id > 0) {
        try {
            if ($pass) {
                $stm = $pdo->prepare("UPDATE users SET username = ?, password = ?, firstname = ?, lastname = ?, address = ?, country = ?, gender = ?, department = ? WHERE id = ?");
                $result = $stm->execute([$uname, $pass, $fname, $lname, $address, $country, $gender, $dep, $id]);
            } else {
                $stm = $pdo->prepare("UPDATE users SET username = ?, firstname = ?, lastname = ?, address = ?, country = ?, gender = ?, department = ? WHERE id = ?");
                $result = $stm->execute([$uname, $fname, $lname, $address, $country, $gender, $dep, $id]);
            }

            $stmskill = $pdo->prepare("UPDATE userskills SET skill = ? WHERE userId = ?");
            $stmskill->execute([$skills, $id]);
            
            if ($result && $stmskill) {
                echo "Record updated successfully";
                header("Location: userlist.php");
                exit();
            } else {
                echo "Error updating record.";
            }
        } catch (PDOException $e) {
            echo "Error updating record: " . $e->getMessage();
        }
    } else {
        echo "Invalid ID.";
    }
} else {
    $user = null;
    $skills = [];
    if ($id > 0) {
        $stm = $pdo->prepare("SELECT username, firstname, lastname, address, country, gender, department FROM users WHERE id = ?");
        $stm->execute([$id]);
        $user = $stm->fetch(PDO::FETCH_ASSOC);
        
        $stmskill = $pdo->prepare("SELECT skill FROM userskills WHERE userId = ?");
        $stmskill->execute([$id]);
        $skillRow = $stmskill->fetch(PDO::FETCH_ASSOC);
        $skills = [];
        if ($skillRow !== false) {
            $skills = explode(',', $skillRow['skill']);
        }
    }
}
?>

<form method="POST" action="edit.php?id=<?php echo ($id); ?>" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo ($id); ?>">

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?php echo ($user['username'] ?? ''); ?>" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>

    <label for="fname">First Name:</label>
    <input type="text" id="fname" name="fname" value="<?php echo ($user['firstname'] ?? ''); ?>" required><br><br>

    <label for="lname">Last Name:</label>
    <input type="text" id="lname" name="lname" value="<?php echo ($user['lastname'] ?? ''); ?>" required><br><br>

    <label for="address">Address:</label>
    <textarea id="address" name="address" rows="4" cols="50"
        required><?php echo ($user['address'] ?? ''); ?></textarea><br><br>

    <label for="country">Country:</label>
    <select id="country" name="country" required>
        <option value="">Select Country</option>
        <option value="Egypt" <?php echo ($user['country'] ?? '') == 'Egypt' ? 'selected' : ''; ?>>Egypt</option>
        <option value="USA" <?php echo ($user['country'] ?? '') == 'USA' ? 'selected' : ''; ?>>USA</option>
    </select><br><br>

    <label>Gender:</label>
    <input type="radio" id="male" name="gender" value="male"
        <?php echo ($user['gender'] ?? '') == 'male' ? 'checked' : ''; ?>>
    <label for="male">Male</label>
    <input type="radio" id="female" name="gender" value="female"
        <?php echo ($user['gender'] ?? '') == 'female' ? 'checked' : ''; ?>>
    <label for="female">Female</label><br><br>

    <label>Skills:</label><br>
    <input type="checkbox" id="php" name="skills[]" value="PHP"
        <?php echo in_array('PHP', $skills) ? 'checked' : ''; ?>>
    <label for="php">PHP</label><br>
    <input type="checkbox" id="mysql" name="skills[]" value="MySQL"
        <?php echo in_array('MySQL', $skills) ? 'checked' : ''; ?>>
    <label for="mysql">MySQL</label><br>
    <input type="checkbox" id="j2se" name="skills[]" value="J2SE"
        <?php echo in_array('J2SE', $skills) ? 'checked' : ''; ?>>
    <label for="j2se">J2SE</label><br>
    <input type="checkbox" id="postgresql" name="skills[]" value="PostgreSQL"
        <?php echo in_array('PostgreSQL', $skills) ? 'checked' : ''; ?>>
    <label for="postgresql">PostgreSQL</label><br><br>

    <label for="department">Department:</label>
    <input type="text" id="department" name="department" value="<?php echo ($user['department'] ?? ''); ?>"><br><br>

    <label for="img">Upload your picture:</label>
    <input type="file" id="img" name="img"><br><br>

    <button type="submit" name="update">Submit</button>
    <button type="reset">Reset</button>
</form>