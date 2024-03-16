<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); // Connect to the database
if(!mysqli_connect_errno()) // Check whether the connection is successful
{
	error_reporting(0);
	$num = $_POST['num'];
	$date = $_POST['date'];
	$week = $_POST['week'];
	$page = $_POST['page'];
	$num = $_POST['num'];
	$department = $_POST['department'];
	$start = ($page - 1) * $num; // start page
	if(!$department){
		$sql_1 = "SELECT doctor.id AS doctor_id, doctor.name AS doctor_name, gender, age, department, position, AVG(rating.rating) AS rating, fee AS appointment_cost, location, email
		FROM doctor, rating, doctorworktime WHERE doctor.id = rating.doctor_id AND doctor.id = doctorworktime.doctor_id AND doctorworktime.$week = '1'
		AND doctor.id NOT IN(SELECT doctor_id FROM appointment WHERE date = '$date' and isAppointed = '1' GROUP BY doctor_id HAVING COUNT(*) >= 4) GROUP BY doctor.id";
		$sql_2 = "SELECT doctor.id AS doctor_id, doctor.name AS doctor_name, gender, age, department, position, AVG(rating.rating) AS rating, fee AS appointment_cost, location, email
		FROM doctor, rating, doctorworktime WHERE doctor.id = rating.doctor_id AND doctor.id = doctorworktime.doctor_id AND doctorworktime.$week = '1'
		AND doctor.id NOT IN(SELECT doctor_id FROM appointment WHERE date = '$date' and isAppointed = '1' GROUP BY doctor_id HAVING COUNT(*) >= 4) GROUP BY doctor.id ORDER BY doctor_id LIMIT $start,$num";
	}
	else{
		$sql_1 = "SELECT doctor.id AS doctor_id, doctor.name AS doctor_name, gender, age, department, position, AVG(rating.rating) AS rating, fee AS appointment_cost, location, email
		FROM doctor, rating, doctorworktime WHERE doctor.id = rating.doctor_id AND doctor.id = doctorworktime.doctor_id AND doctorworktime.$week = '1' AND department LIKE '%$department%'
		AND doctor.id NOT IN(SELECT doctor_id FROM appointment WHERE date = '$date' and isAppointed = '1' GROUP BY doctor_id HAVING COUNT(*) >= 4) GROUP BY doctor.id";
		$sql_2 = "SELECT doctor.id AS doctor_id, doctor.name AS doctor_name, gender, age, department, position, AVG(rating.rating) AS rating, fee AS appointment_cost, location, email
		FROM doctor, rating, doctorworktime WHERE doctor.id = rating.doctor_id AND doctor.id = doctorworktime.doctor_id AND doctorworktime.$week = '1' AND department LIKE '%$department%'
		AND doctor.id NOT IN(SELECT doctor_id FROM appointment WHERE date = '$date' and isAppointed = '1' GROUP BY doctor_id HAVING COUNT(*) >= 4) GROUP BY doctor.id ORDER BY doctor_id LIMIT $start,$num";
	}
	$t1 = microtime(true); // Query start time
	$result_1 = $db->query($sql_1); // Execute the SQL statement
	$result_2 = $db->query($sql_2);
	$t2 = microtime(true); // Query end time
	$number = mysqli_num_rows($result_1); // Get the number of returned rows
	if ($number) { // If the query result is not empty
		$table = mysqli_fetch_all($result_2,MYSQLI_ASSOC); // Get all rows from the result set as an associative array
	   	$time = round($t2-$t1,4); // Total Query time
		$res = [$number, $table, $time];
		echo json_encode($res); // Return the results
	}  else{
		echo json_encode(["404", "The query result is empty!"]);
	}
} else{
	echo json_encode(["500", "Connection failed!"]);
}
// written by Alex Qi
?>