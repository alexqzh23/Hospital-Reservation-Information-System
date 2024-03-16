<?php
// Query nucleic acid test results
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); // Connect to the database
if(!mysqli_connect_errno()) // Check whether the connection is successful
{
	error_reporting(0);
	$idnumber = $_POST['idnumber'];
	$fever = $_POST['fever'];
	$risk = $_POST['risk'];
	if($idnumber){
		$t1 = microtime(true); // Query start time
		$sql_1 = "update user set fever = $fever where idnumber = '$idnumber'";
		$db->query($sql_1);
		$sql_2 = "update user set high_risk_area = $risk where idnumber = '$idnumber'";
		$db->query($sql_2);
		$t2 = microtime(true); // Query end time
		$time = round($t2-$t1,4); // Total Query time
		echo json_encode([200, $time]);
	}
	else{
		echo "Failed to register! (Please try to check your network)";
	}
} else{
	echo json_encode(["500", "Connection failed!"]);
}
// written by Alex Qi
?>