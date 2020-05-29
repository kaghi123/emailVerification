<?php

$error = NULL;

if(isset($_POST['submit'])){
    //get form data
    $e = $_POST['e'];
    $e = filter_var($e, FILTER_SANITIZE_EMAIL);
    
    //conect to database
    $mysqli = NEW MySQLi('localhost', 'georgeka_user', 'theteng1098', 'georgeka_emailV');
    
    $sel_query = "SELECT email FROM accounts WHERE email='$e' LIMIT 1";
    $results = mysqli_query($mysqli, $sel_query);
    
    
    //if eamil is not is table then error, else send email to email address
    if(mysqli_num_rows($results) == ""){
        $error .= "<p>This email address do not exsit in our system</p>";
        
    }else{
        //form is valid

        //send email
        $to = $e;
        $subject = "Reset Password";
        $message = "<a href='http://georgekassar.offyoucode.co.uk/emailVerification/resetpassword.php?email=$e'>Reset Password</a>";                              
        $headers = "From: georgekassar92@gmail.com \r\n";
        $headers .= "MIME-Version: 1.0". "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8". "\r\n";
            
        mail($to, $subject, $message, $headers);
            
        header('location:thankyouresetpassword.php');
    }
}

?>
<html>
    <head>
        
    </head>
    <body>
        <form method="POST" action="">
            <table border="0" align="center" cellpadding="5">
                <tr>
                    <p>Enter your email address and we will send you a link to reset your password</p>
                    <td align="right">Email Address:</td>
                    <td><input type="EMAIL" name="e" required/></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="SUBMIT" name="submit" value="Send" required/></td>
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