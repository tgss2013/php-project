<?php
/*
 * File : fb-handler.php
 * Description : handles the data captured from the facebook.
 * File Version : 0.02
 * Revision Date : 2-10-13
 */
require ('includes/FB_ReqHandler.php');
require ('includes/MySQLDB.php');
require ('includes/SendMail.php');
require ('includes/config.php');
?>
<!DOCTYPE html5>
<html>
    <head>
        <title>Processing data | Generic</title>
        <script type="text/javascript">
            window.history.forward();
        </script>
    </head>
    <body oncontextmenu="return false;">
        <div align="center" style="margin-top: 200px;">
            <img src="media/loading.gif" align="center"/>
            <br>
            <label align="center" style="font-style: italic;">Please wait storing data to database.</label>
            <br>
            <br>
            <label>You will be automatically redirected when operation is complete.</label>
        </div>
    </body>
</html>
<?php
$fb_handler = new FB_ReqHandler();
$mysql_operation = new MySQLDB();
$send_mail = new SendMail();

if ($_REQUEST) {
    $response = $fb_handler -> parse_signed_request($_REQUEST['signed_request'], APP_SECRET);

    /* Save the parsed response from signed request */
    $name = $response['registration']['name'];
    $email = $response['registration']['email'];
    $password = md5($response['registration']['password']);
    $birthday = $response['registration']['birthday'];
    $gender = $response['registration']['gender'];
    $location = $response['registration']['location']['name'];
    $location_id = $response['registration']['location']['id'];
    $phone = $response['registration']['phone'];
    $type = $response['registration']['type'];
    $user_country = $response['user']['country'];
    $user_locale = $response['user']['locale'];
    $user_profile = $response['user_id'];
    $generated_hash = md5(rand(0, 1000));

    /* Save the parsed response from the graph api */
    $extra_decoded_content = $fb_handler -> parse_json_places_request($location_id);
    $location_street = $extra_decoded_content['location']['street'];
    $location_zip = $extra_decoded_content['location']['zip'];
    $location_latitude = $extra_decoded_content['location']['latitude'];
    $location_longitude = $extra_decoded_content['location']['longitude'];

    /* Perform the saving of the data */

    $userdata = array(
                    'name' => $name, 
                    'email' => $email, 
                    'password' => $password, 
                    'birthday' => $birthday, 
                    'gender' => $gender, 
                    'type' => $type, 
                    'location_id' => $location_id, 
                    'location' => $location, 
                    'location_street' => $location_street, 
                    'location_zip' => $location_zip, 
                    'location_lat' => $location_latitude, 
                    'location_lon' => $location_longitude, 
                    'phone' => $phone, 
                    'country' => $user_country, 
                    'locale' => $user_locale, 
                    'profileid' => $user_profile, 
                    'verified' => 0, 
                    'hash' => $generated_hash);

    $conn = $mysql_operation -> ConnectDatabase(DBHOST_URL, DBHOST_UNAME, DBHOST_PASSW, DBHOST_DBNAME);

    /*
    $verifyuserdata = array('email' => $email,'hash'=> $generated_hash);
    $precheckup = $mysql_operation->PerformQuery('verify_exist',DBHOST_DBNAME, DBHOST_TABNAME, $verifyuserdata, $conn);
    if ($precheckup){
        $fb_handler->redirectUrl(BASE_URL.'account_status.php?status=already_exist');
    }
    */    

    $queryresult = $mysql_operation -> PerformQuery('insert', DBHOST_DBNAME, DBHOST_TABNAME, $userdata, $conn);
    
    if ($queryresult) {
        $senddata = array('to' => $email, 'hash' => $generated_hash);
        $sendmail_result = $send_mail->send_mail($senddata);         
        if ($sendmail_result) {
            $fb_handler->redirectUrl(BASE_URL.'account_status.php?status=success');
        } else {
            $fb_handler->redirectUrl(BASE_URL.'account_status.php?status=failed');
        }
    } else {
        echo '<strong>Error :</strong> Insert Query Failed.';
        $fb_handler->redirectUrl(BASE_URL.'account_status.php?status=db_failed');
    }
    $mysql_operation -> DisconnectDatabase($conn);
} else {
    echo '$_REQUEST is empty';
    $fb_handler->redirectUrl(BASE_URL.'account_status.php?status=illegal_access');
}
?>