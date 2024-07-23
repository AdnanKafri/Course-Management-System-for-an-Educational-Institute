<?php

$hostName = "localhost";
$port=3306;
$dbUser = "webapps";
$dbPassword = "fourthyear";
$dbName = "courses";
$conn = new PDO("mysql:host=$hostName;port=$port;dbname=$dbName",$dbUser,$dbPassword);
if (!$conn) {
    die("Something went wrong;");
}
else{
//    echo "Connected";
}

?>