<?php

if(isset($_GET['vkey'])){
    //process verification
    $vkey = $_GET['vkey'];
    
    $mysqli = NEW MySQLi('localhost', 'georgeka_user', 'theteng1098', 'georgeka_emailV');
        
    $resultSet = $mysqli-> query("SELECT verified, vkey FROM accounts WHERE verified = 0 AND vkey = '$vkey' LIMIT 1");
    
    if($resultSet->num_rows == 1){
        //validate the  email
        $update = $mysqli->query("UPDATE accounts SET verified = 1 WHERE vkey = '$vkey' LIMIT 1");
        
        if($update){
            echo "Your account has been verified. You may now login.";
            $link = "http://georgekassar.offyoucode.co.uk/emailVerification/login.php";
            echo "   ";
            echo "<a href='".$link."'>Login</a>";
        }else {
            echo $mysqli->error;
        }
        
    }else {
        echo "This account is invalid or already verified";
    }
    
}else {
    die("Something went wrong");
}

?>
<html>
    <head>
        <!--<link href="style.css" rel="stylesheet" type="text/css" />-->
    </head>
    <body>
        
        <center>
            
        </center>
    </body>
</html>