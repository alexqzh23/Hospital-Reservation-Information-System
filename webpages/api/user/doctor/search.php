<?php
// Search all available doctors and their information according to the date selected by the user
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); // Connect to the database
if(!mysqli_connect_errno()) // Check whether the connection is successful
{
	error_reporting(0);
	$name = $_POST['name'];
	$sql = "SELECT id as doctor_id, doctor.name AS doctor_name FROM doctor WHERE doctor.name LIKE '%$name%'";
	$t1 = microtime(true); // Query start time
	$result = $db->query($sql);
	$t2 = microtime(true); // Query end time
	$number = mysqli_num_rows($result); // Get the number of returned rows
	if ($number) { // If the query result is not empty
		$table = mysqli_fetch_all($result,MYSQLI_ASSOC); // Get all rows from the result set as an associative array
	   	$time = round($t2-$t1,4); // Total Query time
		$res = [200, $table, $time];
		echo json_encode($res); // Return the results
	}  else{
		echo json_encode(["404", "The query result is empty!"]);
	}
} else{
	echo json_encode(["500", "Connection failed!"]);
}
// written by Alex Qi
?>