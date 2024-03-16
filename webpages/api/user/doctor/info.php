<?php
// Get specific information about the designated doctor
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); // Connect to the database
if(!mysqli_connect_errno()) // Check whether the connection is successful
{
	error_reporting(0);
	$doctor_id = $_POST['doctor_id'];
		$sql_1 = "SELECT id AS doctor_id, doctor.name AS doctor_name, gender, age, department, position, AVG(rating.rating) AS rating, fee AS appointment_cost, email
		FROM doctor, rating WHERE doctor.id = rating.doctor_id and doctor.id = $doctor_id GROUP BY doctor.id";
		$sql_2 = "SELECT Mon, Tue, Wed, Thur, Fri, Sat, Sun FROM doctorworktime WHERE doctor_id = $doctor_id";
		$t1 = microtime(true); // Query start time
		$result_1 = $db->query($sql_1);
		$result_2 = $db->query($sql_2);
		$t2 = microtime(true); // Query end time
		$table_1 = mysqli_fetch_all($result_1,MYSQLI_ASSOC); // Get all rows from the result set as an associative array
		$table_2 = mysqli_fetch_all($result_2,MYSQLI_ASSOC);
		$time = round($t2-$t1,4); // Total Query time
		$res = [$table_1, $table_2, $time];
		echo json_encode($res); // Return the results
} else{
	echo json_encode(["500", "Connection failed!"]);
}
// written by Alex Qi
?>