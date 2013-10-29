<?php
/*
 * File : fb_reg.php
 * Description : Registration Page using Facebook
 * File Version : 0.03
 * Revision date : 2-10-13
 */
require ("includes/config.php");
$regOptionFields = array( array('name' => 'name'), array('name' => 'email'), array('name' => 'password'), array('name' => 'birthday'), array('name' => 'gender'), array('name' => 'location'), array('name' => 'phone', 'description' => 'Contact Number', 'type' => 'text'), array('name' => 'type', 'description' => 'You are a', 'type' => 'select', 'options' => array('student' => 'Student', 'teacher' => 'Tutor')), array('name' => 'tnc', 'description' => 'Agree with Generic Terms & Conditions.', 'type' => 'checkbox', 'default' => 'checked'), array('name' => 'captcha'));
$regOptionFields_to_encode = json_encode($regOptionFields);
$urlEncode_from_json_encode = urlencode($regOptionFields_to_encode);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Registration | Generic</title>
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="viewport" content="width=device-width; initial-scale=1.0" />

        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
        <style type="text/css" media="screen">
            #loadImg{position:relative;z-index:999;}
            #loadImg div{display:table-cell;width:120px;height:32px;background:#fff;text-align:center;vertical-align:middle;margin-left: 200px; margin-top: 30px;}
        </style>
    </head>
    <body>
        <div>
            <header>
                <h4 align="center">Registration using facebook.</h4>
            </header>
                <div id="fb-registration" align="center">
                    <div id="loadImg"><div><img src="media/loading.gif"/></div></div>
                    <iframe id="registration" src="http://www.facebook.com/plugins/registration.php?client_id=<?php echo APP_ID; ?>&redirect_uri=<?php echo REDIRECT_URL; ?>&fields=<?php echo $urlEncode_from_json_encode; ?>" scrolling="auto" frameborder="no" style="border:none" allowTransparency="true" width="600" height="600" onload="document.getElementById('loadImg').style.display='none';"></iframe>
                </div>               
            <footer>
            </footer>
        </div>
    </body>
</html>