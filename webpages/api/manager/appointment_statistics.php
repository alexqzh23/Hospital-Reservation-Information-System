<?php
// Query nucleic acid test results
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); // Connect to the database
if(!mysqli_connect_errno()) // Check whether the connection is successful
{
	error_reporting(0);
	$year = date('Y') - 1; // Last year
	$start_date = $year.'0101';
	$end_date = $year.'1231';
	$Mon = 0;
	$Tue = 0;
	$Wed = 0;
	$Thur = 0;
	$Fri = 0;
	$Sat = 0;
	$Sun = 0;
	$t1 = microtime(true); // Query start time
	for ($today=$start_date; strtotime($today)<=strtotime($end_date); $today = date("Y-m-d",strtotime("+1 day",strtotime($today)))) {
		$sql = "select count(*) as today_appointments from appointment where date = '$today'";
		$result = $db->query($sql);
		$table = mysqli_fetch_all($result,MYSQLI_ASSOC);
		$today_appointments = $table[0][today_appointments];
		switch (date("w",strtotime($today)))
		{
		case 1:
			$Mon+=$today_appointments;
			break;  
		case 2:
			$Tue+=$today_appointments;
			break;
		case 3:
			$Wed+=$today_appointments;
			break;  
		case 4:
			$Thur+=$today_appointments;
			break;
		case 5:
			$Fri+=$today_appointments;
			break;  
		case 6:
			$Sat+=$today_appointments;
			break;
		case 0:
			$Sun+=$today_appointments;
			break;  
		default:
			echo "error";
		}
	}
	$t2 = microtime(true); // Query end time
	$time = round($t2-$t1,4); // Total Query time
	echo json_encode([$Mon, $Tue, $Wed, $Thur, $Fri, $Sat, $Sun, $time]);
} else{
	echo json_encode(["500", "Connection failed!"]);
}
// written by Alex Qi
?>