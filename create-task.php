<!DOCTYPE html>
<html>
  <head>
    <title>Title of the document</title>
<link rel=stylesheet href="/create-task.css">
<?php
include_once("background.php");
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
	$sql = sprintf("INSERT INTO tasks VALUES (\"%s\", \"%s\", FALSE)", $_REQUEST["title"], $_REQUEST["description"]);
	if ($conn->query($sql) === TRUE) {
		$conn->close();
		header('Location: /list-task.php');
	}
	else {
		echo "Error: " . $sql . "<br>". $conn->error;
	}
	exit();
}
?>
<link rel=stylesheet href="/background.css">
  </head>
  <body>
<?php bannertop(); ?>
<div class=entrytext>Please Enter Title and Description</div>
<div class="createtaskbox">
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
	<div style="display:flex;">
      <span>Title:</span>
      <input type="text" name="title">
	</div>
	<div style="display:flex;">
      <span>Description:</span>
      <textarea name="description"></textarea>
	</div>
	<br>
	<input type=submit value=submit>
    </form>
<?php bannerbottom(); ?>
  </body>
</html>
