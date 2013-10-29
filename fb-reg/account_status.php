<?php
 require ('includes/config.php');   
 require ('includes/FB_ReqHandler.php');
 $handler = $fb_handler = new FB_ReqHandler();
 $title = "Account Status";
if (isset($_REQUEST['status']) && $_REQUEST['status']!="") {
    if ($_REQUEST['status']=="success") {
        $message = "Registration Success!\n\nKindly verify your account, check email.";
    } else if ($_REQUEST['status']=="failed") {
        $message = "Registration Failed!\n\nNothing can be done.Sorry!";
    } else if ($_REQUEST['status']=="db_failed") {
        $message = "Database seems to be failed to process query.";
    } else if ($_REQUEST['status']=="illegal_access") {
        $message = "OMG!! OMG!!, Its illegal access.";
    }else if($_REQUEST['status']="already_exist"){
        $message = "Humm, Its seems that your account already exist.";
    }
} else {
    $message = "Illegal Access";
}
?>
<!DOCTYPE html5>
<html>
    <head>
        <title>Account status | Generic</title>
    </head>
    <body>
        <div align="center" style="margin-top: 200px;border">
            <label align="center" style="font-style: italic;"><?php echo $title; ?></label>
            <br>
            <br>
            <label align="center" style="font-style: italic;"><?php echo $message; ?></label>
        </div>
    </body>
</html>