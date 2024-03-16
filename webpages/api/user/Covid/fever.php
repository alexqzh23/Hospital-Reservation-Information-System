<?php
// Enter ID number, registration time and doctor ID to register.
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); // Connect to the database
if(!mysqli_connect_errno()) // Check whether the connection is successful
{
	error_reporting(0);;
	$idnumber = $_POST['idnumber'];
	$date = $_POST['date'];
	$week = $_POST['week'];
	if($idnumber){
		$t1 = microtime(true); // Query start time
		$sql_1 = "select id as user_id from user where idnumber = '$idnumber'";
		$result_1 = $db->query($sql_1);
		$table_1 = mysqli_fetch_all($result_1,MYSQLI_ASSOC);
		$user_id = $table_1[0][user_id]; // Get the user ID according to the user ID number.
		
		$sql_2 = "select max(id) as id_max from appointment";
		$result_2 = $db->query($sql_2);
		$table_2 = mysqli_fetch_all($result_2,MYSQLI_ASSOC);
		$appointment_id = $table_2[0][id_max] + 1; // Get the ID that should be set for the new appointment
		
		$sql_3 = "SELECT doctor.id as doctor_id FROM doctorworktime, doctor where doctorworktime.doctor_id = doctor.id and department = 'infectious diseases' and $week = '1'";
		$result_3 = $db->query($sql_3);
		$doctors = mysqli_fetch_all($result_3,MYSQLI_ASSOC);
		$num = array_rand($doctors,1); // Randomly select a doctor
		$doctor_id = $doctors[$num][doctor_id];
		
		$sql_4 = "insert into appointment values ($appointment_id, $date, $user_id, $doctor_id, '1')"; // Perform insert operation
		$db->query($sql_4);

		$sql_5 = "update user set fever = '1' where id = '$user_id'"; // Perform update operation
		$db->query($sql_5);
		
		$t2 = microtime(true); // Query end time
		$time = round($t2-$t1,4); // Total Query time
		echo json_encode(["Register successfully!", $time]);
	}
	else{
		echo "Failed to register! (Please try to check your network)";
	}
} else{
	echo json_encode(["500", "Connection failed!"]);
}
// written by Alex Qi
?>