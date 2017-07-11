<?php

// inserts an email address from request param if not a duplicate

// get db pw from config file
$configFile = "../../../config/sc_db_pw.txt";
$fh = fopen($configFile, 'r');
$db_pw = fread($fh, filesize($configFile));
fclose($fh);

$servername = "localhost";
$username = "webmondc_star";
$password = $db_pw;
$db = "webmondc_starcharm";
$address = urldecode($_REQUEST['email']);
$error = "";

if (filter_var($address, FILTER_VALIDATE_EMAIL)) {
    // Create connection
    $conn = mysql_connect($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        $error = "Connection failed: " . $conn->connect_error;
    } else {
        if (! mysql_select_db($db)) {
            $error = "Unable to select database";
        } else {
            $address = mysql_real_escape_string($address);

            $result = mysql_query("SELECT count(*) as count from email where `email` = '$address'");
            $is_duplicate = mysql_result($result, 0);
            if ($is_duplicate) {
                $error = "Duplicate email";
            } else {
                @mysql_query("INSERT INTO `email`(`email`) VALUES ('$address')");

                if (mysql_errno()) {
                    $error = "Database insert failed. " . mysql_error();
                }
            }
        }
        mysql_close();
    }
} else {
    $error = "Not a valid email address";
}

if (! $error) {
    echo "success";
} else {
    echo $error;
}

?>