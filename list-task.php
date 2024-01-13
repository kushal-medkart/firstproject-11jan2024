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
		$sql = sprintf('SET @row_number = -1;');
		$conn->query($sql);
		$sql = sprintf("select title,description,status from (SELECT title, description, status, (@row_number:=@row_number + 1) AS row_num FROM tasks) as t where row_num=%s", $_REQUEST["START"]);
		$result = $conn->query($sql);
		$row = $result->fetch_row();
		if ($row[2] == FALSE)
		{
			$sql=sprintf("UPDATE tasks set status=TRUE where title='%s'", $row[0]);
			$conn->query($sql);
			echo "TASK STARTED";

		} else {
			echo "TASK ALREADY STARTED";
		}
	} else if (isset($_REQUEST["FINISH"])) {
		$sql = sprintf('SET @row_number = -1;');
		$conn->query($sql);
		$sql = sprintf("select title,description,status from (SELECT title, description, status, (@row_number:=@row_number + 1) AS row_num FROM tasks) as t where row_num=%s", $_REQUEST["FINISH"]);
		$result = $conn->query($sql);
		$row = $result->fetch_row();
		if ($row[2] == TRUE)
		{
			$sql=sprintf("UPDATE tasks set status=FALSE where title='%s'", $row[0]);
			$conn->query($sql);
			echo "TASK COMPLETED";
		} else {
			echo "TASK ALREADY COMPLETED";
		}

	}
}
?>
<link rel=stylesheet href=list-task.css>
</head>
<body>
<div class="banner">
<img src="/images/todo_list.png" class=titleimg>
<div>
<div class=todotitle>Todo.net</div>
<div class=maketodotitle>Make your Todo here and let it available everywhere</div></div>
</div>

<div class=todocontainer>
<div class=stylestimg></div>
<div class=stylestimg1></div>
<div class=todocontainerbox>
<div class=entrytext>Please validate todo</div>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">

<?php

$sql=sprintf("select * from tasks");
$resultanthtml = "<div>";
$result = $conn->query($sql);

$rows = $result->fetch_all();

for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
	$resultanthtml .= sprintf ('<div><div class=cardtitle><div class=notetitle>%s</div><div class=notedescription>%s</div>', $rows[$rowIndex][0], $rows[$rowIndex][1]);

	$option = array("EDIT", "DELETE", "START", "FINISH");
	for ($i = 0; $i < count($option); $i++)
		$resultanthtml .= sprintf('<div>
		<button type="submit" class=cardbutton name="%s" value="%s">%s</button></div>', $option[$i], $rowIndex, $option[$i]); 
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
