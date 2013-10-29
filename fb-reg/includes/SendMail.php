<?php
/*
 * File : sendMail.php
 * Description : Send mail on registration of user.
 * File version : 0.01
 * Revision date : 5-10-13
 */
require ('config.php');

class SendMail {
    public function send_mail($senddata) {
        $baseurl = BASE_URL;
        $to = $senddata['to'];
        $hash = $senddata['hash'];
        $header = "From: Generic Webmaster <webmaster@Generic.com\r\nContent-Type: text/html";
        $subject = "Verify your email address @ Generic.com";
        $message = "
         <img width=251 height=68 src='http://www.Generic.com/logo.jpg' alt='logo-Generic'></img><br/><br/>
         Dear user,<br/>
         Greetings!<br/>
         We welcome you to our website and thank you for the creating account.<br/>
         Your account will not be active unless your email is verified.<br/><br/>
         Kindly verify email by clicking over the following link.<br/><br/>
         " . $baseurl . "verify.php?email=" . $to . "&hash=" . $hash . "<br/><br/>
         Thank You,<br/>
         Team<br/>";

        $mail_status = mail($to, $subject, $message, $header);
        if ($mail_status) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
