<form method="post" action="Controller.php">
    <input type="hidden" name="page" value="login">

    <label>User Name:</lable>
        <input type="text" name="uname" placeholder="user name"><br><br>
        <label>Password:</lable>
            <input type="password" name="password" placeholder="password"><br><br>
            <input type="submit" value="login" name="login">
</form>
<?php require'conndb.php' ;

if(isset($_GET['err'])) {
    echo 'user name or password';
}


?>