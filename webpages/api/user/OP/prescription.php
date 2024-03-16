<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
$db = new mysqli('localhost', 'Kingsley', '123456', 'test');
if(!mysqli_connect_errno())
{	
	error_reporting(0);
	$idnumber = $_POST['idnumber'];
	$sql = "select user.name as user_name, idnumber, inspection_item, examitem.fee as inspection_cost, drugname, medicine.price as drug_cost, (examitem.fee + medicine.price) as total_cost from user, examitem, medicine, prescriptions 
	where prescriptions.user_id = user.id and prescriptions.medicine_id = medicine.id and prescriptions.testing_id = examitem.id and idnumber = '$idnumber'";
	$t1 = microtime(true); // 查询开始时间
	$result = $db->query($sql);
	$t2 = microtime(true); // 查询结束时间
	$number = mysqli_num_rows($result);
	if ($number) {
		$user = mysqli_fetch_all($result,MYSQLI_ASSOC);
	   	$res = [$user, $t2-$t1, 200];
	}  else{
		$sql = "select idnumber,name from user where idnumber = '$idnumber'";
		$t1 = microtime(true);
		$result = $db->query($sql);
		$t2 = microtime(true);
		$user = mysqli_fetch_all($result,MYSQLI_ASSOC);
		$res = [$user, $t2-$t1, 404];
	}
	echo json_encode($res);
} else{
	echo "500";
}
// written by Alex Qi
?>