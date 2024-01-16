<!DOCTYPE html>
<html>
  <head>
<title>Create Tasks</title>
<link rel="icon" type="image/x-icon" href="/images/todoico.png">

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

// valid title and descriptions are accepted
if (($_SERVER["REQUEST_METHOD"] === "POST") && (($_REQUEST["title"] !== "") && ($_REQUEST["description"] !== ""))) {
	$stmt = $conn->prepare("INSERT INTO tasks VALUES (?, ?, FALSE)");
	$stmt->bind_param("ss", $_REQUEST["title"], $_REQUEST["description"]);

	$stmt->execute();
	$stmt->close();
	$conn->close();
	header('Location: /list-task.php');
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
	<input type=button value=tasks>
	<input type=submit value=submit>
    </form>
<?php bannerbottom(); ?>
<script>
document.querySelector(".createtaskbox input[type=button]").addEventListener("click", function() {
	location.href="/list-task.php";
});
</script>
  </body>
</html>
