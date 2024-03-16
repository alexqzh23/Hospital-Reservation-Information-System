<?php
//	document intro
//in: NULL
//out: list
//find out all item and return in a list

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");

$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); //Connect to database
if(!mysqli_connect_errno()){//Check connection
	error_reporting(0);
	
	$sql = "
		select *
		from examitem 
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
		$item = [$table, $time];
	   	echo json_encode($item);
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