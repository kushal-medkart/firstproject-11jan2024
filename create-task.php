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
	$sql = sprintf("INSERT INTO tasks VALUES (\"%s\", \"%s\")", $_REQUEST["title"], $_REQUEST["description"]);
	if ($conn->query($sql) === TRUE) {
		echo "New Record Created Successfully";
	}
	else {
		echo "Error: " . $sql . "<br>". $conn->error;
	}
}

$conn->close();
?>
  </head>
  <body>
    <h3>NEW TASK CREATION</h3>
    <form method="post" action="<?php echo $_SERVER[" PHP_SELF "];?>">
      <span>Title:</span>
      <input type="text" name="title">
      <span>Description:</span>
      <textarea name="description"></textarea>
	<br><br>
	<input type=submit value=submit>
    </form>
  </body>
</html>
