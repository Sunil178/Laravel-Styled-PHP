<?php
	$db_host = "127.0.0.1";
	$db_user = "root";
	$db_pass = "1234";
	$db_name = "AceDB";
	$conn = mysqli_connect("$db_host", "$db_user", "$db_pass", "$db_name") or die ("Could not connect to MySQL");
