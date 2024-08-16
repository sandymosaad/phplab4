<?php
session_start();

function validate($data) {
    if (is_string($data)) {
        $data = trim($data);
        $data = addslashes($data);
        //$data = htmlspecialchars($data);
    }
    return $data;
}

function validatePassword($password) {
    $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    return preg_match($pattern, $password);
}

if (isset($_POST['page']) && $_POST['page'] == 'register') {
    $uname = validate($_POST['username']);
    $pass = validate($_POST['password']);
    $fname = validate($_POST['fname']);
    $lname = validate($_POST['lname']);
    $address = validate($_POST['address']);
    $country = validate($_POST['country']);
    $gender = validate($_POST['gender']);
    $dep = validate($_POST['department']);
    $img = $_FILES['img'];
    $skills = isset($_POST['skills']) && is_array($_POST['skills']) ? $_POST['skills'] : [];

    $errors = [];

    if (empty($uname)) {
        $errors['username'] = "Username is required.";
    }
    if (empty($pass)) {
        $errors['password'] = "Password is required.";
    }
    if (empty($fname)) {
        $errors['fname'] = "First name is required.";
    }
    if (empty($lname)) {
        $errors['lname'] = "Last name is required.";
    }
    if (empty($address)) {
        $errors['address'] = "Address is required.";
    }
    if (empty($country)) {
        $errors['country'] = "Country is required.";
    }
    if (empty($gender)) {
        $errors['gender'] = "Gender is required.";
    }
    if (empty($skills)) {
        $errors['skills'] = "At least one skill must be selected.";
    }
    if (empty($dep)) {
        $errors['department'] = "Department is required.";
    }

    if (strlen($fname) < 2) {
        $errors['fname'] = "First name must be more than 2 characters.";
    }
    if (strlen($lname) < 2) {
        $errors['lname'] = "Last name must be more than 2 characters.";
    }
    if (strlen($uname) < 8) {
        $errors['username'] = "Username must be more than 7 characters.";
    }
    if (!validatePassword($pass)) {
        $errors['password'] = "Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.";
    }

    
    if ($img['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($img["name"]);
        if (move_uploaded_file($img["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($img["name"])) . " has been uploaded.";
        } else {
            $errors['img'] = "Sorry, there was an error uploading your file.";
        }
    } elseif ($img['error'] != UPLOAD_ERR_NO_FILE) {
        $errors['img'] = "Error uploading file.";
    } 

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header("Location: registration.php");
        exit();
    } else {
        require("conndb.php");

        $stm = $pdo->prepare("INSERT INTO users (username, password, firstname, lastname, address, country, gender, department, img) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stm->execute([$uname, $pass, $fname, $lname, $address, $country, $gender, $dep, $targetFile]);

        $userId = $pdo->lastInsertId();
        $stm = $pdo->prepare("INSERT INTO userSkills (skill, userid) VALUES (?, ?)");
        foreach ($skills as $skill) {
            $stm->execute([$skill, $userId]);
        }

        header("Location: userlist.php");
        exit();
    } }
    elseif(isset($_POST['page']) && $_POST['page']  == 'login') {
            $uname=validate($_POST['uname']);
            $pass =($_POST['password']);
        
            $errors=[];
        
        if (empty($uname)) {
            $errors['username'] = "Username is required.";
        }
        if (empty($pass)) {
            $errors['password'] = "Password is required.";
        }
        if(strlen($uname)<8){
            $errors['uname']="user name must be more than 7 char";
        }
        if (!validatePassword($pass)) {
            $errors['password'] = "Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.";
        }
        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors; 
            header("Location: login.php");
            exit();
        } else {
        require("conndb.php");
        header("Location: userlist.php");
        }
        
            function validate($data){
                if (is_string($data)) {
                    $data = trim($data);
                    $data = addslashes($data);
                    $data = htmlspecialchars($data);
                }
                return $data;
            }
            function validatePassword($password) {
                $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
                return preg_match($pattern, $password);
            }
        }
?>