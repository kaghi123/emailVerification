<?php
session_start();

$error = NULL;

if(isset($_SESSION['u'])){
    header('location:homepage.php');
}

if(isset($_POST['submit'])){
    //conect to database
    $mysqli = NEW MySQLi('localhost', 'georgeka_user', 'theteng1098', 'georgeka_emailV');
    
    //get form data
    $u = $mysqli->real_escape_string($_POST['u']);
    $p = $mysqli->real_escape_string($_POST['p']);
    
    //query the database
    $resultSet = $mysqli->query("SELECT * FROM accounts WHERE username = '$u' LIMIT 1");
    
    if($resultSet->num_rows !=0){
//        //proccess login
        
        while($row = $resultSet->fetch_assoc()){
            
            if(password_verify($p, $row['password'])){
                $verified = $row['verified'];
                $email = $row['email'];
                $date = $row['createdate'];
                $date = strtotime($date);
                $date = date('M d Y', $date);

                if($verified == 1){
                    //continue proccessing
                    $_SESSION['u'] = $u;
                    
                    if(!empty($_POST['remember'])){
                        setcookie('user', $_POST['u'], time() + (10 * 365 * 24 * 60 * 60));
                        setcookie('pass', $_POST['p'], time() + (10 * 365 * 24 * 60 * 60));
                    }else{
                        if(isset($_COOKIE['user'])){
                            setcookie("user", "");
                        }if(isset($_COOKIE['pass'])){
                            setcookie("pass", "");
                        }
                    }
                    
                    header('location:homepage.php');
                    
                }else{
                    $error = "This account has not yet been verified. An email was sent to $email on $date";
                }
            }else {
                //invalid credentials
                $error = "The username or password you entered is incorrect";
            }
        }
    
    }
    else{
        $error = "The username or password you entered is incorrect";
    }
}

?>
<html>
    <head>
        <!--<link href="style.css" rel="stylesheet" type="text/css" />-->
    </head>
    <body>
        <form method="POST" action="">
            <table border="0" align="center" cellpadding="5">
                <tr>
                    <td align="right">Username:</td>
                    <td><input type="TEXT" name="u" value="<?php if(isset($_COOKIE["user"])) {echo $_COOKIE["user"];} ?>" required/></td>
                </tr>
                <tr>
                    <td align="right">Password:</td>
                    <td><input type="PASSWORD" name="p" value="<?php if(isset($_COOKIE["pass"])) {echo $_COOKIE["pass"];} ?>" required/></td>
                </tr>
                <tr>
                <tr>
                    <td colspan="2" align="center"><label for="remember-me">Remember me: </label><input type="checkbox" name="remember" id="remember" <?php if(isset($_COOKIE["user"])) { ?> checked <?php } ?> /></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="SUBMIT" name="submit" value="Login" required/></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><a href="forgotpassword.php">Forgot Password</a></td>
                </tr>
                <tr>
                    <a href="index.php">Sign Up</a>
                </tr>
            </table>
        </form>
        <center>
            <?php 
                echo $error;
            ?>
        </center>
    </body>
</html>