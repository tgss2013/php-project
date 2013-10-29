<?php
/*
 * File : MySqlDB.php
 * Description : This is the database class file.
 *
 * Build on Facebook SDK version : 3.2.2
 * Revision Date : 30-9-13
 */
class MySQLDB {
    public function CreateDatabase($dbname, $conn) {
        try {
            $result = PerformQuery('create_db', $dbname, "", "", $conn);
            return $result;
        } catch (Exception $e) {
            error_log("Error : " . $e);
        }
    }

    public function ConnectDatabase($dbhosturl, $dbuname, $dbpass, $dbname) {
        try {
            $conn = mysqli_connect($dbhosturl, $dbuname, $dbpass, $dbname);
            return $conn;
        } catch (Exception $e) {
            error_log("Error : " . $e);
        }
    }

    public function DisconnectDatabase($conn) {
        try {
            mysqli_close($conn);
        } catch (Exception $e) {
            error_log("Error : " . $e);
        }
    }

    public function PerformQuery($qtype, $dbname, $tabname, $arrdata, $conn) {
        $date = date("m-d-Y");
        try {
            switch ($qtype) {
                case 'create_db' :
                    try {
                        $query = "CREATE DATABASE $dbname;";
                        if (!mysqli_query($conn, $query)) {
                            $message = "Failed with 'Create Database' Query.";
                            return $message;
                        }
                    } catch (Exception $e) {
                        error_log("Error : " . $e);
                    }

                    break;
                case 'insert' :
                    try {
                        $query = "INSERT INTO $tabname 
                                    VALUES('" . $arrdata['profileid']."',
                                           '" . $arrdata['name']."',
                                           '" . $arrdata['email']."',
                                           '" . $arrdata['password']."',
                                           '" . $arrdata['birthday']."',
                                           '" . $arrdata['gender']."',
                                           '" . $arrdata['type']."',
                                           '" . $arrdata['location_id']."',
                                           '" . $arrdata['location']."',
                                           '" . $arrdata['location_street']."',
                                           '" . $arrdata['location_zip']."',
                                           '" . $arrdata['location_lat']."',
                                           '" . $arrdata['location_lon']."',
                                           '" . $arrdata['phone']."',
                                           '" . $arrdata['country']."',
                                           '" . $arrdata['locale']."',
                                           '" . $arrdata['verified']."',
                                           '" . $arrdata['hash']."',
                                           '" . $date."');";

                        if (mysqli_query($conn, $query)) {
                            return true;
                        } else {
                            return false;
                        }
                    } catch (Exception $e) {
                        error_log("Error : " . $e);
                    }
                    break;
                case 'update' :
                    $query = "UPDATE $tabname 
							SET 
                            name='" . $arrdata['name'] . "',
                            password='" . $arrdata['password'] . "',
                            birthday='" . $arrdata['birthday'] . "',
                            gender='" . $arrdata['gender'] . "',
                            type='" . $arrdata['type'] . "',
                            location_id='" . $arrdata['location_id'] . "',
                            location='" . $arrdata['location'] . "',
                            location_street='" . $arrdata['location_street'] . "',
                            location_zip='" . $arrdata['location_zip'] . "',
                            location_lat='" . $arrdata['location_lat'] . "',
                            location_lon='" . $arrdata['location_lon'] . "',
                            phone='" . $arrdata['phone'] . "',
                            country='" . $arrdata['country'] . "',
                            locale='" . $arrdata['locale'] . "',
                            WHERE id=" . $arrdata['email'] . ";";
                    if (mysqli_query($conn, $query)) {
                        return true;
                    } else {
                        return false;
                    }
                case 'verify' :
                    $query = "UPDATE $tabname
                	           SET verified='1'
                	           WHERE email='".$arrdata['email']."' AND hash='".$arrdata['hash']."';";
                    if (mysqli_query($conn, $query)) {
                        return true;
                    } else {
                        return false;
                    }
                    break;
                case 'verify_exist':
                    $query = "SELECT * 
                                FROM $tabname WHERE email='".$arrdata['email']."';";
                    if(mysqli_query($conn,$query)){
                        return true;
                    }else{
                        return false;
                    }
                    break;
            }
        } catch (Exception $e) {
            error_log("Error : " . $e);
        }
    }

}
