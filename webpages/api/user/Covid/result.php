<?php
// Query nucleic acid test results
header("Access-Control-Allow-Origin: *");
$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); // Connect to the database
if(!mysqli_connect_errno()) // Check whether the connection is successful
{
	error_reporting(0);
	$idnumber = $_POST['idnumber'];
	$today = $_POST['date'];
	if($idnumber && $today){
		$t1 = microtime(true); // Query start time
		$sql_1 = "select id as user_id from user where idnumber = '$idnumber'";
		$result_1 = $db->query($sql_1);
		$table_1 = mysqli_fetch_all($result_1,MYSQLI_ASSOC);
		$user_id = $table_1[0][user_id]; // Get the user ID according to the user ID number
		$sql_2 = "SELECT name, age, gender FROM user where id = $user_id";
		$result_2 = $db->query($sql_2);
		$table_2 = mysqli_fetch_all($result_2,MYSQLI_ASSOC);

		$sql_3= "SELECT date, isPositive FROM covid_result where user_id = '$user_id' and date <= $today ORDER BY date DESC LIMIT 0,1"; // Perform select operation
		$result_3 = $db->query($sql_3);
		$table_3 = mysqli_fetch_all($result_3,MYSQLI_ASSOC);
		
		$t2 = microtime(true); // Query end time
		$time = round($t2-$t1,4); // Total Query time
		$res = [$table_2, $table_3, $time];
		echo json_encode($res);
	}
	else{
		echo "Failed to register! (Please try to check your network)";
	}
} else{
	echo json_encode(["500", "Connection failed!"]);
}
// written by Alex Qi
?>