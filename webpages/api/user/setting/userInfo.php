<?php
	header("Access-Control-Allow-Origin: *");
	$db = new mysqli('localhost', 'Kingsley', '123456', 'test');
	if(!mysqli_connect_errno()) {
		error_reporting(0);
		$idnumber = $_POST['idnumber'];
		$sql = "select* from user where idnumber = '$idnumber'";
		$t1 = microtime(true);
		$result = $db->query($sql);
		$t2 = microtime(true);
		$number = mysqli_num_rows($result);
		$data = [];
		if ($number) {
			$data = mysqli_fetch_all($result,MYSQLI_ASSOC);
			$res = [$data, $t2-$t1];
	   		echo json_encode($res);
		} else {
			echo 404;
		}
	} else {
		echo 500;
	}
?>