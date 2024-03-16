<?php
// Query nucleic acid test results
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); // Connect to the database
if(!mysqli_connect_errno()) // Check whether the connection is successful
{
	error_reporting(0);
	$sql1 = "SELECT COUNT(age) AS V FROM user WHERE age >= 14 AND age <= 24";
    $sql2 = "SELECT COUNT(age) AS V FROM user WHERE age >= 25 AND age <= 34";
    $sql3 = "SELECT COUNT(age) AS V FROM user WHERE age >= 35 AND age <= 44";
    $sql4 = "SELECT COUNT(age) AS V FROM user WHERE age >= 45 AND age <= 54";
    $sql5 = "SELECT COUNT(age) AS V FROM user WHERE age >= 55 AND age <= 64";
    $sql6 = "SELECT COUNT(age) AS V FROM user WHERE age >= 65 AND age <= 74";
    $sql7 = "SELECT COUNT(age) AS V FROM user WHERE age >= 75";
    $t1 = microtime(true);
    $result1 = $db->query($sql1);
    $result2 = $db->query($sql2);
    $result3 = $db->query($sql3);
    $result4 = $db->query($sql4);
    $result5 = $db->query($sql5);
    $result6 = $db->query($sql6);
    $result7 = $db->query($sql7);
    $t2 = microtime(true); 
    $table1 = mysqli_fetch_all($result1,MYSQLI_ASSOC);
    $table2 = mysqli_fetch_all($result2,MYSQLI_ASSOC);
    $table3 = mysqli_fetch_all($result3,MYSQLI_ASSOC);
    $table4 = mysqli_fetch_all($result4,MYSQLI_ASSOC);
    $table5 = mysqli_fetch_all($result5,MYSQLI_ASSOC);
    $table6 = mysqli_fetch_all($result6,MYSQLI_ASSOC);
    $table7 = mysqli_fetch_all($result7,MYSQLI_ASSOC);
    echo json_encode([200, $table1, $table2, $table3, $table4, $table5, $table6, $table7, $t2-$t1]);
} else{
	echo json_encode(["500", "Connection failed!"]);
}
// written by Alex Qi
?>