<!doctype html>
<html>
<head>
<title>Edit Delete Task</title>
<link rel=stylesheet href="/background.css">
<?php
include_once "background.php";

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

function findTitleFromRowNum($conn, $row_num) {
	$sql = 'SET @row_number = -1';
	$conn->query($sql);
	$stmt = $conn->prepare("select title,description from (SELECT title, description, (@row_number:=@row_number + 1) AS row_num FROM tasks) as t where row_num=?");

	$stmt->bind_param("s", $row_num);
	$stmt->execute();

	// get result
	$result = $stmt->get_result();
	return $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_REQUEST["DELETE"]) && $_REQUEST["DELETE"] != "null") {
		$sql = sprintf('SET @row_number = -1;');
		$conn->query($sql);
		// search with row number
		$stmt = $conn->prepare("delete from tasks where title=(select title from (SELECT title, (@row_number:=@row_number + 1) AS row_num FROM tasks) as t where row_num=?)");

		$stmt->bind_param("s", $_REQUEST["DELETE"]);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		header('Location: /list-task.php');
		exit();
	} else if (isset($_REQUEST["EDIT"])) {
		$row = findTitleFromRowNum($conn, $_REQUEST["EDIT"]);
		header('Location: /edit-task.php?title='.$row['title'].'&description='.$row['description']);
	} else if (isset($_REQUEST["START"])) {

		$row = findTitleFromRowNum($conn, $_REQUEST["START"]);
		if ($row["status"] == FALSE)
		{
			// update status value for given title
			$stmt=$conn->prepare("UPDATE tasks set status=TRUE where title=?");
			$stmt->bind_param("s", $_REQUEST["title"]);
			$stmt->execute();
			$stmt->close();
			echo "TASK STARTED";

		} else {
			echo "TASK ALREADY STARTED";
		}
	} else if (isset($_REQUEST["FINISH"])) {
		$row=findTitleFromRowNum($conn, $_REQUEST["FINISH"]);
		// finish
		if ($row["status"] == TRUE)
		{
			$stmt=$conn->prepare("UPDATE tasks set status=FALSE where title=?");
			$stmt->bind_param("s", $_REQUEST["title"]);
			$stmt->execute();
			$stmt->close();
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

<?php bannertop(); ?>
<div class=entrytext>Please validate todo</div>
<div class=todocontainerchildbox>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">

<?php
// list all title and description for todo
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
<?php bannerbottom(); ?>

<?PHP $conn->close(); ?>
<script> 
const deleteElems = document.querySelectorAll("button[name=DELETE]");
for (const deleteElem of deleteElems)
{
deleteElem.addEventListener("click", function(e) {
if (confirm('Please confirm deletion') === false) {
	e.srcElement.value = null;
}
});
}
</script>
</body>
</html>
