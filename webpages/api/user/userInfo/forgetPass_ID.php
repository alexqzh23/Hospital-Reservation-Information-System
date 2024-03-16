<?php
//	document intro
//in: idnumber
//out: bool value
//search user, if idnumber exists in database, return T, otherwise return F

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");

$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); //Connect to database
if(!mysqli_connect_errno()){//Check connection
	error_reporting(0);
	
	$idnumber = $_POST['idnumber'];//catch post
	$sql = "
		select idnumber
		from user
		where idnumber = '$idnumber'
	";
	
	$t1 = microtime(true); //get start time
	$result = $db->query($sql); //Execute SQL
	$t2 = microtime(true); //get end time
	
	$getRows = mysqli_num_rows($result); //Get the number of returned rows
	
	//If not empty
	if ($getRows) {
		//Total Query time
		$time = $t2-$t1;
		//Return results;
		$data = [200, $time];
	   	echo json_encode($data);
	} 
	//If empty
	else{
		$data = [404, "Input number does not exist!"];
		echo json_encode($data);
	}
} 
else{
	echo json_encode(["500", "Connection failed!"]);
}

//created by Jerry Pang
?>