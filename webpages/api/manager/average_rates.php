<?php
//	document intro
//in: NULL
//out: list
//search and calculate infos in rating table and then return result in a list

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");

$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); //Connect to database
if(!mysqli_connect_errno()){//Check connection
	error_reporting(0);
	
	$sql = "
		select avg(rating.rating) as average_number, count(rating.user_id) as rates_number, count(distinct rating.user_id) as user_number
		from rating
		where 1
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
		$res = [$table, $time];
	   	echo json_encode($res);
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