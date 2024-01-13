<!DOCTYPE html>
<html>
  <head>
    <title>Title of the document</title>
    <style>
      input,
      textarea {
        padding: 5px;
      }
      span {
        display: block;
        padding: 15px 0 3px;
      }
      input:focus,
      textarea:focus,
      select:focus {
        outline: none;
      }
.createtaskbox {
	background-color: #030303ff; 
	border: 2px solid #9c7248;
}


 .createtaskbox input[type=submit]{
	font-family: "Lemon-Regular"
}
 .createtaskbox input[type=text]{
	background-color: black;
	border-top: 0;
	border-right: 0;
	border-left: 0;
	color: white;
	border-bottom: 2px white blue;
	margin: 8px;
	font-family: "Lemon-Regular";
}
 .createtaskbox textarea{
	background-color: black;
	border-top: 0;
	border-right: 0;
	border-left: 0;
	color: white;
	border-bottom: 2px white blue;
	font-family: "Lemon-Regular";
}

.createtaskbox {
	padding: 40px;
}
.createtaskbox span{
	color: white;
	font-family: "Lemon-Regular";
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
    </style>
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
<div class="banner">
<img src="/assets/todo_list.png" class=titleimg>
<div>
<div class=todotitle>Todo.net</div>
<div class=maketodotitle>Make your Todo here and let it available everywhere</div>
</div>
</div>

<div class="todocontainer">
<div class="stylestimg" style="left:10%">
</div>
<div class="stylestimg1" style="margin-left: 50%;right:20%">
</div>

<div style="position: absolute;  margin: 0 auto;   left: 20%;
  right: 10%;">
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
</div>
  </body>
</html>
