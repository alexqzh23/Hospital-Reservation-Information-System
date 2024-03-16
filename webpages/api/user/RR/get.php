<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
$db = new mysqli('localhost', 'Kingsley', '123456', 'test');
if(!mysqli_connect_errno())
{
	error_reporting(0);
	$idnumber = $_POST['idnumber'];
	$page = $_POST['page'];
	$num = $_POST['num'];
	$start = ($page - 1) * $num; // start page
	$sql_1 = "select user.name as user_name, idnumber, doctor.name as doctor_name, department, date, appointment.id as appointment_id from appointment, 
	doctor, user where appointment.user_id = user.id and appointment.doctor_id = doctor.id and idnumber = '$idnumber' and isAppointed = '1'";
	$sql_2 = "select user.name as user_name, idnumber, doctor.name as doctor_name, department, date, appointment.id as appointment_id from appointment, 
	doctor, user where appointment.user_id = user.id and appointment.doctor_id = doctor.id and idnumber = '$idnumber' and isAppointed = '1' order by date desc LIMIT $start,$num";
	$t1 = microtime(true); // Query start time
	$result_1 = $db->query($sql_1);
	$result_2 = $db->query($sql_2);
	$t2 = microtime(true); // Query end time
	$number = mysqli_num_rows($result_1); // Get the number of returned rows
	if ($number) { // If the query result is not empty
		$table = mysqli_fetch_all($result_2,MYSQLI_ASSOC); // Get all rows from the result set as an associative array
		$time = round($t2-$t1,4); // Total Query time
		$res = [200, $number, $table, $time];
	   	echo json_encode($res); // Return the results
	}  else{
		echo json_encode(["404", "The query result is empty!"]);
	}
} else{
	echo json_encode(["500", "Connection failed!"]);
}