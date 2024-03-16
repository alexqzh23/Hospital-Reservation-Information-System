<?php
	header("Access-Control-Allow-Origin: *");
	$db = new mysqli('localhost', 'Kingsley', '123456', 'test');
	if(!mysqli_connect_errno()) {
		error_reporting(0);
		$sql = "select max(id) from user";
		$t1 = microtime(true);
		$result = $db->query($sql);
		$number = mysqli_num_rows($result);
		$res = [];
		$max = 0;
		$res = mysqli_fetch_all($result,MYSQLI_ASSOC);
		$id = $res[0]['max(id)'] + 1;
		$name = $_POST['name'];
		$age = $_POST['age'];
		$gender = $_POST['gender'];
		$phone_number = $_POST['phone_number'];
		$martial_status = $_POST['marital_status'];
		$password = $_POST['password'];
		$idnumber = $_POST['idnumber'];
		$fever = 0;
		$high_risk_area= 0;
		$sql = "insert into user(id, name, age, gender, phone_number, marital_status, password, idnumber, fever, high_risk_area, vaccine_times ) values ('$id', '$name', '$age' , '$gender', '$phone_number', '$marital_status', '$password', '$idnumber', '$fever', '$high_risk_area', '')";
		$result = $db->query($sql);
		$t2 = microtime(true);
		if ($result) {
			$res = [200, $t2-$t1];
			echo json_encode($res);
		}
	} else {
		echo 500;
	}
?>