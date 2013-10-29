<?php
/*
 * File: verify.php
 * Description: This file performs verification and activation of user accounts.
 * File version: 0.01
 * Revision date : 5-10-13  
 */
 require ('includes/config.php');
 require ('includes/MySQLDB.php');

 if(isset($_REQUEST['email']) && isset($_REQUEST['hash']) && $_REQUEST['email']!="" && $_REQUEST['hash']!=""){
     $verifyData = array(
                    'email'=>$_REQUEST['email'],
                    'hash'=>$_REQUEST['hash']
                   );
 }else{
     echo "<strong>Error :</strong> Illegal access to this page.";
     exit;
 }
 
 $mysql_operation = new MySQLDB();
 $conn = $mysql_operation->ConnectDatabase(DBHOST_URL, DBHOST_UNAME, DBHOST_PASSW, DBHOST_DBNAME);
 $queryResult = $mysql_operation->PerformQuery('verify', DBHOST_DBNAME, DBHOST_TABNAME, $verifyData, $conn);
 
 if($queryResult){
     $title = "Verified!";
     $message = "You are now verified user.\n\nYou may now login your account.";
 }else{
     $title = "Well that's embarrassing";
     $message = "Aww! something went wrong.\nKindly contact system Administrator.";
 }
?>
<!DOCTYPE html5>
<html>
    <head>
        <title>Verifying data | Generic</title>
        <script type="text/javascript">
            window.history.forward();
        </script>
    </head>
    <body oncontextmenu="return false;">
        <div align="center" style="margin-top: 100px;">
            <img width=300 height=70 src='http://www.Generic.com/logo.jpg' align="center" alt='logo-Generic'></img>
            <br>
            <div>
                <?php echo $title; ?>
            </div>
            <div>
                <?php echo $message; ?>
            </div>
            <br>
        </div>
    </body>
</html>
