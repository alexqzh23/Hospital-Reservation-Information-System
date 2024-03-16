<?php
//document intro
//:NULL

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");

$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); //Connect to database
if(!mysqli_connect_errno()){//Check connection
	error_reporting(0);
	
	$sql1 = "
		select count(date) from appointment where date like '%2018%'
	";
	$sql2 = "
		select count(date) from appointment where date like '%2019%'
	";
	$sql3 = "
		select count(date) from appointment where date like '%2020%'
	";
	
	$t1 = microtime(true); //get start time
	//Execute SQL
	$result1 = $db->query($sql1);
	$result2 = $db->query($sql2);
	$result3 = $db->query($sql3);
	$t2 = microtime(true); //get end time
	
	//Get the number of returned rows
	$getRows1 = mysqli_num_rows($result1);
	$getRows2 = mysqli_num_rows($result2);
	$getRows3 = mysqli_num_rows($result3);
	
	//If not empty
	if ($getRows1 !=0 && $getRows2 !=0 && $getRows3 !=0) {
		//Get all rows from the result set as an associative array
		$table1 = mysqli_fetch_row($result1);
		$table2 = mysqli_fetch_row($result2);
		$table3 = mysqli_fetch_row($result3);
		$appoint2018 = (int)$table1[0];
		$appoint2019 = (int)$table2[0];
		$appoint2020 = (int)$table3[0];
		
		//Total Query time
		$time = $t2-$t1;
		//Return results
		$res = [$appoint2018, $appoint2019, $appoint2020, $time];
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