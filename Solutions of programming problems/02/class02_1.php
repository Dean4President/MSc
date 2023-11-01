<?php
/*
Make a program, based on the lesson examples, that:
- include a form (with 2 inputs: username, password)
- contain a user/password pair set in the code
- if the form has been submitted, check if they match, if not, give an error message!
*/
?>


<?php
session_start();
//here we can log out, or if it is first time, we make a new variable
if (!isset($_SESSION['enter']) || isset($_GET['exit'])){
	$_SESSION['enter']=false;
}

if (isset($_POST['submit'])){
// generate local users
$user[0]['name']='user1';
$user[0]['pass']='pass1';
$user[1]['name']='user2';
$user[1]['pass']='pass2';
$user[2]['name']='user3';
$user[2]['pass']='pass3';
for ($i=0; $i<count($user); $i++){
if ($user[$i]['name']==$_POST['user'] && $user[$i]['pass']==$_POST['pass']){
	$_SESSION['enter']=true;
} 
}
}

// if we entered we get a welcome message, and and exit link
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