<?php
//	document intro
//in: idnumber, password
//out: bool value
//search user and change the password, if idnumber exists in database, return Ture, otherwise return False

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");

$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); //Connect to database
if(!mysqli_connect_errno()){//Check connection
	error_reporting(0);
	
	$idnumber = $_POST['idnumber'];//catch idnumber
	$password = $_POST['password'];//catch password
	
	//change password
	$sql = "
		update user
		set password = '$password'
		WHERE idnumber= '$idnumber'
	";
	$t1 = microtime(true); //get start time
	//change the password
	$db->query($sql);
	$t2 = microtime(true); //get end time
	//Total Query time
	$time = $t2-$t1;
	//Return results
	$data = [200, $time];
	echo json_encode($data);
} 
else{
	echo json_encode(["500", "Connection failed!"]);
}

//created by Jerry Pang
?>