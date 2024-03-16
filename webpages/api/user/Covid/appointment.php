<?php
// Query nucleic acid test results
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); // Connect to the database
if(!mysqli_connect_errno()) // Check whether the connection is successful
{
	error_reporting(0);
	$idnumber = $_POST['idnumber'];
	$date = $_POST['date'];
	if($idnumber && $date){
		$t1 = microtime(true); // Query start time
		$sql_1 = "select id as user_id from user where idnumber = '$idnumber'";
		$result_1 = $db->query($sql_1);
		$table_1 = mysqli_fetch_all($result_1,MYSQLI_ASSOC);
		$user_id = $table_1[0][user_id]; // Get the user ID according to the user ID number
		
		$sql_3= "SELECT * FROM covid_result where user_id = $user_id and date = '$date'"; // Perform select operation
		$result_3 = $db->query($sql_3);
		$number = mysqli_num_rows($result_3);
		
		if($number){
			echo json_encode([202, "Failed appointment! (You can't make the appointment twice in one day)"]);
		}
		else{
			$num = array_rand([0,1],1); // Nucleic acid test results
			$sql_2 = "insert into CoViD_result values ($user_id, $date, $num)"; // Perform insert operation
			$db->query($sql_2);
			$t2 = microtime(true); // Query end time
			$time = round($t2-$t1,4); // Total Query time
			echo json_encode([200, $time]);
		}
	}
} else{
	echo json_encode([500, "Connection failed!"]);
}
// written by Alex Qi
?>