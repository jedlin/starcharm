<?php

// prints out emails stored in starcharm email database

$servername = "localhost";
$username = "webmondc_star";
$password = "[private]";
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

@mysql_query("BEGIN");
$query = "SELECT * from email;";
$result=mysql_query($query);
mysql_close();

echo $header;
echo "<h3>Starcharm saved emails</h3>";
echo "<table border='1' cellspacing='0' cellpadding='4'>";

while ($row = mysql_fetch_assoc($result)) {
    $email = $row['email'];
    $create_time = $row['create_time'];
    $line = $email . " </td><td>" . $create_time . "<br>";
    echo "<tr> <td>" . $line . "</td> </tr>";
}

echo "</table>";
echo $footer;

?>