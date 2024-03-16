<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
$db = new mysqli('localhost', 'Kingsley', '123456', 'test');
if(!mysqli_connect_errno())
{
	error_reporting(0);
	$id = $_POST['id'];
	$sql = "update appointment set isAppointed = '0' where id = '$id'"; // 将预约状态置0
	$t1 = microtime(true); // 更新开始时间
	$db->query($sql);
	$t2 = microtime(true); // 更新结束时间
	$res = [200, $t2-$t1];
	echo json_encode($res);
} else{
	echo "500";
}
// written by Alex Qi
?>