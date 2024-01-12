<!doctype html>
<html>
<head>
	<title>Edit Delete Task</title>
<?php

$servername="localhost";
$username="user";
$password="password";
$dbname="todo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_REQUEST["delete"])) {

	} else if (isset($_REQUEST["edit"])) {

	}
	echo var_dump($_REQUEST);
}
?>

<style>
table tr td{
border: 1px solid black;
}

table { 
    border-spacing: 0px;
    border-collapse: separate;
}
</style>

</head>
<body>

<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
<?php

$sql=sprintf("select * from tasks");
$resultanthtml = "<table>";
$result = $conn->query($sql);

$rows = $result->fetch_all();

for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
	$resultanthtml .= sprintf ('<tr><td>%s</td><td>%s</td>', $rows[$rowIndex][0], $rows[$rowIndex][1]);

	$option = array("EDIT", "DELETE", "START", "FINISH");
	for ($i = 0; $i < count($option); $i++)
		$resultanthtml .= sprintf('<td>
		<button type="submit" name="%s" value="%s">%s</button></td></td>', $option[$i], $rowIndex, $option[$i]); 
	$resultanthtml .= '</tr>';
}
echo $resultanthtml . "</table>";
?>
</form>


<?PHP $conn->close(); ?>
</body>
</html>
