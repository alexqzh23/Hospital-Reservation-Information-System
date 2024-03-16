<?php
// Enter ID number and date to make vaccination.
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
		
		$sql_2 = "select max(date) as date_max from vaccine where user_id = '$user_id'";
		$result_2 = $db->query($sql_2);
		$table_2 = mysqli_fetch_all($result_2,MYSQLI_ASSOC);
		$last_date = $table_2[0][date_max]; // Get the time of last appointment for vaccination

		$dif = (strtotime($date) - strtotime($last_date)) / 86400;
		if($dif >= 180){
			$sql_3 = "insert into vaccine values ($user_id, $date)"; // Perform insert operation
			$db->query($sql_3);
			$t2 = microtime(true); // Query end time
			$time = round($t2-$t1,4); // Total Query time
			echo json_encode([200, "Register successfully!", $time]);
		}
		else{
			echo json_encode([201, "You can only be vaccinated once every six months!"]);
		}
	}
	else{
		echo "Failed to register! (Please try to check your network)";
	}
} else{
	echo json_encode(["500", "Connection failed!"]);
}
// written by Alex Qi
?>