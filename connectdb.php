<?php
	require dirname(__FILE__).'/config.inc';
	$db = new mysqli(
		$dbConfig['host'], 
		$dbConfig['user'], 
		$dbConfig['pass'], 
		$dbConfig['database']
	);
	if ($db->connect_errno) {
		echo 'เกิดข้อผิดพลาดขณะเชื่อมต่อฐานข้อมูล';
		if(ISTEST){
			echo ' : ';
			echo $mysqli->connect_error;
		}
		exit;
	}