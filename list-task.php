<!doctype html>
<html>
<head>
<title>Edit Delete Task</title>
<link rel=stylesheet href="/background.css">
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
	if (isset($_REQUEST["DELETE"])) {
		$sql = sprintf('SET @row_number = -1;');
		$conn->query($sql);
		$sql = sprintf("delete from tasks where title=(select title from (SELECT title, (@row_number:=@row_number + 1) AS row_num FROM tasks) as t where row_num=%s)", $_REQUEST["DELETE"]);
		$conn->query($sql);
		header('Location: /list-task.php');
		exit();
	} else if (isset($_REQUEST["EDIT"])) {
		$sql = sprintf('SET @row_number = -1;');
		$conn->query($sql);
		$sql = sprintf("select title,description from (SELECT title, description, (@row_number:=@row_number + 1) AS row_num FROM tasks) as t where row_num=%s", $_REQUEST["EDIT"]);
		$result = $conn->query($sql);
		$row = $result->fetch_row();
		header('Location: /edit-task.php?title='.$row[0].'&description='.$row[1]);
	} else if (isset($_REQUEST["START"])) {

	} else if (isset($_REQUEST["FINISH"])) {

	}
}
?>

<style>
table tr td{
border: 1px solid black;
}
table tr:nth-child(1), tr:nth-child(2) {
	font-family: "Salsa-Regular";
}
.card {
background-color: white;
}

.notetitle {
	font-family: "Lemon-regular"
}

.notedescription {
	font-family: "Kanit-ExtraLight";
	padding-left: 2px;
}
.entrytext {
	font-weight: bold;
	font-size: 1.5em;
	margin-top: 1em;
	margin-bottom: 1em;
	color: white;
	text-shadow: 1px 2px #000000;
	font-family: "Lemon-Regular";
}
table { 
    border-spacing: 0px;
    border-collapse: separate;
}
</style>
</head>
<body>
<div class="banner">
<img src="/assets/todo_list.png" class=titleimg>
<div>
<div class=todotitle>Todo.net</div>
<div class=maketodotitle>Make your Todo here and let it available everywhere</div></div>
</div>

<div class="todocontainer">
<div class="stylestimg" style="left:10%">
</div>
<div class="stylestimg" style="margin-left: 50%;right:20%">
</div>
<div style="position: absolute;  margin: 0 auto;   left: 20%;
  right: 10%;">
<div class=entrytext>Please validate todo</div>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">

<?php

$sql=sprintf("select * from tasks");
$resultanthtml = "<div>";
$result = $conn->query($sql);

$rows = $result->fetch_all();

for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
	$resultanthtml .= sprintf ('<div><div style="background-color: white;   box-shadow: 5px 10px #0000003f;padding: 2px; width: 190px; margin: 10px;float: left;"><div class=notetitle>%s</div><div class=notedescription>%s</div>', $rows[$rowIndex][0], $rows[$rowIndex][1]);

	$option = array("EDIT", "DELETE", "START", "FINISH");
	for ($i = 0; $i < count($option); $i++)
		$resultanthtml .= sprintf('<div>
		<button type="submit" style="float: left; margin: 1px;font-family: Kanit-ExtraLight" name="%s" value="%s">%s</button></div>', $option[$i], $rowIndex, $option[$i]); 
	$resultanthtml .= '</div></div>';
}
echo $resultanthtml . "</div>";
?>
</form>
</div>
</div>

<?PHP $conn->close(); ?>
<script> 
const deleteElems = document.querySelectorAll("button[name=DELETE]");
for (const deleteElem of deleteElems)
{

deleteElem.addEventListener("click", function(e) {
if (confirm('Please confirm deletion') === true) {
	const formData = new FormData(document.querySelector("form"));
	fetch("/list-task.php", {
		method:"POST",
		body:formData
	});
} else {
	location.href="/list-task.php";
}
});
}
</script>
</body>
</html>
