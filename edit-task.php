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

if (($_SERVER["REQUEST_METHOD"] == "POST") && $_REQUEST["description"] != "") {
	$stmt=$conn->prepare("UPDATE tasks SET description=? where title=?");
	$stmt->bind_param("ss", $_REQUEST["description"], $_REQUEST["title"]);
	$stmt->execute();
	$stmt->close();
	$conn->close();
	header('Location: /list-task.php');
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
	<?php echo '<input readonly="readonly" type="text" name="title" value='.htmlspecialchars($_REQUEST["title"]).'>'; ?>
	</div>
	<div style="display:flex;">
      <span>Description:</span>
	<?php echo '<textarea name="description">'.htmlspecialchars($_REQUEST['description']).'</textarea>'; ?>
	</div>
	<br>
	<input type=submit value=submit>
    </form>
<?php bannerbottom(); ?>
  </body>
</html>
