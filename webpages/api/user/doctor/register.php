<?php
// Enter ID number, registration time and doctor ID to register.
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); // Connect to the database
if(!mysqli_connect_errno()) // Check whether the connection is successful
{
	error_reporting(0);
	$idnumber = $_POST['idnumber'];
	$doctor_id = $_POST['doctor_id'];
	$date = $_POST['date'];
	if(!strtotime($date)){
		echo "You can only make an appointment with the doctor within this month!";
	}
	else{
		if($idnumber && $doctor_id && $date){
			$t1 = microtime(true); // Query start time
			$sql_1 = "select id as user_id from user where idnumber = '$idnumber'";
			$result_1 = $db->query($sql_1);
			$table_1 = mysqli_fetch_all($result_1,MYSQLI_ASSOC);
			$user_id = $table_1[0][user_id]; // Get the user ID according to the user ID number.
			
			$sql_2 = "select max(id) as id_max from appointment";
			$result_2 = $db->query($sql_2);
			$table_2 = mysqli_fetch_all($result_2,MYSQLI_ASSOC);
			$appointment_id = $table_2[0][id_max] + 1; // Get the ID that should be set for the new appointment
			
			$sql_check1 = "select * from appointment where user_id = $user_id and date = '$date' and isAppointed = 1";
			$result_check1 = $db->query($sql_check1);
			$number_1 = mysqli_num_rows($result_check1); // check whether the user already has an appointment on that day
			
			$sql_check2 = "SELECT doctor_id FROM appointment WHERE date = '$date' and doctor_id = $doctor_id and isAppointed = '1' GROUP BY doctor_id HAVING COUNT(*) >= 4";
			$result_check2 = $db->query($sql_check2);
			$number_2 = mysqli_num_rows($result_check2); // Check if the doctor has less than 4 appointments on that day
			
			if(!$number_2){
				if(!$number_1){
					$sql_3 = "insert into appointment values ($appointment_id, $date, $user_id, $doctor_id, '1')"; // Perform insert operation
					$result = $db->query($sql_3);
					$t2 = microtime(true); // Query end time
					$time = round($t2-$t1,4); // Total Query time
					echo json_encode([200, "Register successfully!", $time]);
				}
				else{
					echo "Failed to register! (You can't make two appointments in one day)";
				}
			}
			else{
				echo "Failed to register! (The doctor's appointment is full on $date)";
			}
		}
	}
} else{
	echo json_encode(["500", "Connection failed!"]);
}
// written by Alex Qi
?>