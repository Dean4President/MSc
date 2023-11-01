<?php
/*
Make a program, based on the lesson examples, that:
- use both session and database.
- after logging in, list the users, edit, delete and create new ones
- have a message in all cases, successful or unsuccessful
- the database/table creation upload should be automatic (either included in php or exported from the database and the export file uploaded separately)
*/
// we need to start the session, to get $_SESSION array
session_start();

//here we can log out, or if it is first time, we make a new variable
if (!isset($_SESSION['enter']) || isset($_GET['exit'])){
	$_SESSION['enter']=false; // we set it default value
}

if (isset($_POST['submit'])){
// need to connect to the database	
$link=mysqli_connect('localhost','root','', 'php');
// make a query, check the user and pass
$sql='SELECT `name`, `pass` FROM `user` WHERE `name`="'.$_POST['user'].'" and `pass`="'.$_POST['pass'].'"';
// get results from the database, using our query
$result=mysqli_query($link, $sql);
// if our query has only one row in result, we can login, if it is 0, we cannot
if (mysqli_num_rows($result)==1){
	$_SESSION['enter']=true;
}
mysqli_close($link);	

}

// if we entered, we get a welcome message, and and exit link
// if the $_SESSION['enter'] is false, we need the form
if ($_SESSION['enter']==true){
	echo 'You are logged in:';
	echo '<a href="login.php?exit=on">EXIT</a>';
} else {
	echo '<FORM NAME="form1" action="login.php" method="POST">
	<INPUT TYPE="text" name="user">
	<INPUT TYPE="password" name="pass">
	<INPUT TYPE="submit" name="submit" value="ENTER">
</FORM>';
}
?>