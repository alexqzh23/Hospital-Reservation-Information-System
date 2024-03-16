<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");

$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); //Connect to database
if(!mysqli_connect_errno()){//Check connection
	error_reporting(0);
	
	$sql = "
		select medicine.drugname, count(medicine_id) as times
		from prescriptions,medicine
		where prescriptions.medicine_id = medicine.id and not prescriptions.medicine_id = 0
		group by medicine_id
		order by times desc
		limit 10
	";	
	
	$t1 = microtime(true);
	$result = $db->query($sql);
	$t2 = microtime(true); 
	$getRows = mysqli_num_rows($result);
	
	//If not empty
	if ($getRows != 0){
		$table = mysqli_fetch_all($result);
		
		//Total Query time
		$time = $t2-$t1;
		echo json_encode([$table,$time]);
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