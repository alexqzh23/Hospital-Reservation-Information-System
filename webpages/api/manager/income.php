<?php
//	document intro
//in: NULL
//out: list
//calculate 3 kind of fee, the total user and the rise in last year, then return in a list

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");

$db = new mysqli('localhost', 'Kingsley', '123456', 'test'); //Connect to database
if(!mysqli_connect_errno()){//Check connection
	error_reporting(0);
	
	$sql1 = "
		select sum(doctor.fee)
		from doctor, prescriptions
		where prescriptions.doctor_id = doctor.id
	";
	$sql2 = "
		select sum(examitem.fee)
		from examitem, prescriptions
		where prescriptions.testing_id = examitem.id
	";
	$sql3 = "
		select sum(medicine.price)
		from medicine, prescriptions
		where prescriptions.medicine_id = medicine.id
	";
	$sql4 = "
		select count(distinct user_id) as user_number
		from prescriptions
	";
	$sql5 = "
		select count(date)
		from appointment
		where date like '%2019%'
	";
	$sql6 = "	
		select count(date)
		from appointment
		where date like '%2020%'
	";
	
	$t1 = microtime(true); //get start time
	//Execute SQLs
	$result1 = $db->query($sql1); 
	$result2 = $db->query($sql2); 
	$result3 = $db->query($sql3); 
	$result4 = $db->query($sql4); 
	$result5 = $db->query($sql5); 
	$result6 = $db->query($sql6); 
	$t2 = microtime(true); //get end time
	
	$getRows1 = mysqli_num_rows($result1); 
	$getRows2 = mysqli_num_rows($result2);
	$getRows3 = mysqli_num_rows($result3);
	$getRows4 = mysqli_num_rows($result4);
	$getRows5 = mysqli_num_rows($result5);
	$getRows6 = mysqli_num_rows($result6);
	
	//If all are not empty
	if ($getRows1 !=0 && $getRows2 !=0 && $getRows3 !=0
		&& $getRows4 !=0 && $getRows5 !=0 &&$getRows6 !=0)
		{
		
		//trans results
		$table1 = mysqli_fetch_row($result1);
		$table2 = mysqli_fetch_row($result2);
		$table3 = mysqli_fetch_row($result3);
		$table4 = mysqli_fetch_row($result4);
		$table5 = mysqli_fetch_row($result5);
		$table6 = mysqli_fetch_row($result6);

		$sumDoctor = (int)$table1[0];
		$sumExamitem = (int)$table2[0];
		$sumMedicine = (int)$table3[0];
		$countUser = (int)$table4[0];
		$appointment2019 = (int)$table5[0];
		$appointment2020 = (int)$table6[0];
		
		//all income sum up
		$sumAll = $sumDoctor + $sumExamitem + $sumMedicine;
		
		//the rise in last year
		if($appointment2020 < $appointment2019){
			$appointment2019 = 0-($appointment2019);
		}
		
		$rise = ($appointment2020-$appointment2019)/$appointment2019;
		
		//Total Query time
		$time = $t2-$t1;
		echo json_encode([$sumAll,$countUser,$rise,$time]);
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