<?php

$error = NULL;

if(isset($_POST['submit'])){
    //get form data
    $p = $_POST['p'];
    $p2 = $_POST['p2'];
    $e = $_GET['email'];
    
    if($p2 != $p){
        $error .= "<p>Your passwords do not match</p>";
    }else{
        //form is valid
        
        //conect to database
        $mysqli = NEW MySQLi('localhost', 'georgeka_user', 'theteng1098', 'georgeka_emailV');
        
        //sanitize form data
        $p = $mysqli->real_escape_string($p);
        $p = password_hash($p, PASSWORD_DEFAULT);
        
        
        //update password in the database
        $insert = $mysqli->query("UPDATE accounts SET password='$p' WHERE email='$e'");
        
        if($insert){
            
            header('location:resetsuccess.php');
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
                    <td align="right">New Password:</td>
                    <td><input type="PASSWORD" name="p" required/></td>
                </tr>
                <tr>
                    <td align="right">Repeat Password:</td>
                    <td><input type="PASSWORD" name="p2" required/></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="SUBMIT" name="submit" value="Submit" required/></td>
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