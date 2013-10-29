<?php
/*
 * File : config.php
 * Description : Configuration file for the Application.
 * File version : 0.01
 * Revision Date : 2-10-13
 */

/* Facebook application connection details */
define('APP_ID', '546788682057503');
define('APP_SECRET', '1f4aa1022a216f37e0f5fb346b066e18');
define('BASE_URL', 'http://code.freeserver.me/fb-reg/');
define('REDIRECT_URL', 'http://code.freeserver.me/fb-reg/fb-handler.php');

/* MySQL database connection details*/
define('DBHOST_URL', 'mysql.2freehosting.com');
define('DBHOST_UNAME', 'u668409289_01');
define('DBHOST_PASSW', 'abc123');
define('DBHOST_DBNAME', 'u668409289_01');
define('DBHOST_TABNAME', 'userData');

/* SMTP mail connection details */
define('SMTP_PROTOCOL', 'smtp');
define('SMTP_HOST', 'ssl://md-54.webhostbox.net');
define('SMTP_PORT', '465');
define('SMTP_UNAME', 'webmaster@generic.com');
define('SMTP_PASSW', 'abc123');
