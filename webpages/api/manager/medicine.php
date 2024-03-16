<?php
// Enter the medicine ID to find the medicine information
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); // Connect to the database
if(!mysqli_connect_errno()) // Check whether the connection is successful
{
	error_reporting(0);
	$id = $_POST['id'];
	$page = $_POST['page'];
	$num = $_POST['num'];
	$start = ($page - 1) * $num; // start page
	if($id){
		$sql = "SELECT * FROM medicine WHERE id = $id";
	}
	else{
		$sql = "SELECT * FROM medicine LIMIT $start,$num";
	}
	$t1 = microtime(true); // Query start time
	$result = $db->query($sql);
	$t2 = microtime(true); // Query end time
	$number = mysqli_num_rows($result); // Get the number of returned rows
	if ($number) { // If the query result is not empty
		$table = mysqli_fetch_all($result,MYSQLI_ASSOC); // Get all rows from the result set as an associative array
		$time = round($t2-$t1,4); // Total Query time
		$res = [$table, $time];
	   	echo json_encode($res);
	}  else{
		echo json_encode(["404", "The query result is empty!"]);
	}
} else{
	echo json_encode(["500", "Connection failed!"]);
}
// written by Alex Qi
?>