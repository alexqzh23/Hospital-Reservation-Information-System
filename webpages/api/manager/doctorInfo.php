<?php
//	document intro
//in: id
//out: list
//search all infos of the doctor with the id and then return in a list

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");

$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); //Connect to database
if(!mysqli_connect_errno()){//Check connection
	error_reporting(0);
	
	$id = $_POST['id'];//catch post
	$sql = "
		select doctor.id, doctor.name, doctor.age, doctor.gender, doctor.phone_number, doctor.location, doctor.fee, doctor.email
			, doctor.department, doctor.position, avg(rating.rating) as avg_rating, doctorworktime.Mon, doctorworktime.Tue, doctorworktime.Wed
			, doctorworktime.Thur, doctorworktime.Fri, doctorworktime.Sat, doctorworktime.Sun
		from doctor, doctorworktime, rating
		where doctor.id = '$id' and doctorworktime.doctor_id = '$id' and rating.doctor_id = '$id'
	";
	
	$t1 = microtime(true); //get start time
	$result = $db->query($sql); //Execute SQL
	$t2 = microtime(true); //get end time
	
	$getRows = mysqli_num_rows($result); //Get the number of returned rows
	
	//If not empty
	if ($getRows) {
		//Get all rows from the result set as an associative array
		$table = mysqli_fetch_all($result,MYSQLI_ASSOC);
		//Total Query time
		$time = round($t2-$t1,4);
		
		//Return results
		$data = [$table, $time];
	   	echo json_encode($data);
	} 
	//If empty
	else{
		echo json_encode(["404", "The query result is empty!"]);
	}
} 
else{
	echo json_encode(["500", "Connection failed!"]);
}

//created by Jerry Pang
?>