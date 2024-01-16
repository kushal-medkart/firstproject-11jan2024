<!doctype html>
<html>
<head>
<title></title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- redirect to create-task page -->

    <?php
/*
    function printError() {
	header('WWW-Authenticate: Basic realm="My Realm"');
	header('HTTP/1.0 401 Unauthorized');
	exit;
}


if (!isset($_SERVER['PHP_AUTH_USER'])) {
	printError();
} else {
	$sql = sprintf("select * from register where user='%s'", $_SERVER['PHP_AUTH_USER']);
	$result = $mydb->query($sql);
	$row = $result->fetchArray();

	// count number entry
	if ($row) {
		if ($row['password'] != $_SERVER['PHP_AUTH_PW'])
			printError();
		// when password is equal do nothing
	}
	else {
		if (strlen($_SERVER['PHP_AUTH_USER']) > 40 || strlen($_SERVER['PHP_AUTH_PW']) > 40)
			printError();

		$sql = sprintf("insert into register values ('%s', '%s')", $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
		$mydb->query($sql);
	}
}*/
?>
<script >location.href="/create-task.php"</script> 
</div>
</body>
</html>

