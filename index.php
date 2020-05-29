<?php

$error = NULL;

if(isset($_POST['submit'])){
    //get form data
    $u = $_POST['u'];
    $p = $_POST['p'];
    $p2 = $_POST['p2'];
    $e = $_POST['e'];
    
    
    //conect to database
    $mysqli = NEW MySQLi('localhost', 'georgeka_user', 'theteng1098', 'georgeka_emailV');
    
    $sel_query = "SELECT email FROM accounts WHERE email='$e' LIMIT 1";
    $results = mysqli_query($mysqli, $sel_query);
    
    if(strlen($u) < 5){
        $error = "<p>Your username should be at least 5 characters</p>";
    }elseif($p2 != $p){
        $error .= "<p>Your passwords do not match</p>";
    }elseif(!mysqli_num_rows($results) == ""){
        $error .= "<p>This email already exists.</p>";
    }else{
        //form is valid
        
        
        
        //sanitize form data
        $u = $mysqli->real_escape_string($u);
        $p = $mysqli->real_escape_string($p);
        $p = password_hash($p, PASSWORD_DEFAULT);
        $e = $mysqli->real_escape_string($e);
        
        //generate vkey
        $vkey = md5(time().$u);
        
        
        //insert accounts into the database
        
        $insert = $mysqli->query("INSERT INTO accounts (username, password, email, vkey) VALUES ('$u', '$p', '$e', '$vkey')");
        
        if($insert){
            //send email
            $to = $e;
            $subject = "Email Verification";
            $message = "<a href='http://georgekassar.offyoucode.co.uk/emailVerification/verify.php?vkey=$vkey'>Register Account</a>";
            $headers = "From: georgekassar92@gmail.com \r\n";
            $headers .= "MIME-Version: 1.0". "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8". "\r\n";
            
            mail($to, $subject, $message, $headers);
            
            header('location:thankyou.php');
        }else{
            echo $mysqli->error;
        }
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
                    <td><input type="TEXT" name="u" required/></td>
                </tr>
                <tr>
                    <td align="right">Password:</td>
                    <td><input type="PASSWORD" name="p" required/></td>
                </tr>
                <tr>
                    <td align="right">Repeat Password:</td>
                    <td><input type="PASSWORD" name="p2" required/></td>
                </tr>
                <tr>
                    <td align="right">Email Address:</td>
                    <td><input type="EMAIL" name="e" required/></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="SUBMIT" name="submit" value="Register" required/></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><a href="login.php">Login</a></td>
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