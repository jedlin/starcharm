<?php

// prints out emails stored in starcharm email database

// get db pw from config file
$configFile = "../../../config/sc_db_pw.txt";
$fh = fopen($configFile, 'r');
$db_pw = fread($fh, filesize($configFile));
fclose($fh);

$servername = "localhost";
$username = "webmondc_star";
$password = $db_pw;
$db = "webmondc_starcharm";

$header = "<html> <head><title>Starcharm saved emails</title> </head> </html> <body style='font-family: sans-serif'>";
$footer = "</body> </html>";

// Create connection
$conn = mysql_connect($servername,$username,$password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysql_select_db($db) or die( "Unable to select database");

$query1 = "SELECT count(*) as num_emails from email;";
$result1=mysql_query($query1);
while ($row1 = mysql_fetch_assoc($result1)) {
    $email_count = number_format($row1["num_emails"]);
}

$query2 = "SELECT * from email;";
$result2=mysql_query($query2);

mysql_close();

echo $header;
echo "<h3>" . $email_count . " Starcharm saved emails</h3>";
echo "<table border='1' cellspacing='0' cellpadding='4'>";

while ($row = mysql_fetch_assoc($result2)) {
    $email = $row['email'];
    $create_time = $row['create_time'];
    $line = $email . " </td><td>" . $create_time . "<br>";
    echo "<tr> <td>" . $line . "</td> </tr>";
}

echo "</table>";
echo $footer;

?>