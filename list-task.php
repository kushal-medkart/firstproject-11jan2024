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
echo "<table>";
$result = $conn->query($sql);
$value=0;

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
	echo sprintf ('<tr><td>%s</td><td>%s</td>
		<td><button type="submit" name="edit" value="%s">EDIT</button></td>
		<td><button type="submit" name="delete" value="%s">DELETE</button>
	</td></tr>', $row["title"], $row["description"], $value, $value);
$value+=1;
}

echo "</table>";
?>
</form>


<?PHP $conn->close(); ?>
</body>
</html>
