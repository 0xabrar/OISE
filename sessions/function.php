<?php
ob_start();
session_start();
 
$username = $_POST['username'];
$password = $_POST['password'];
 
$con = mysqli_connect('localhost', 'root', 'candy12', 'students');
$query = "SELECT id, username, password, salt
        FROM member
        WHERE username = '$username';";
 
//Check if the user exists or not.
$result = mysqli_query($con, $query);
if(mysqli_num_rows($result) == 0) 
{
	mysqli_close($con);
	header('Location: index.html');
}
 
//Match the password hash to the one entered in the form. 
$userData = mysqli_fetch_array($result, MYSQL_ASSOC);
$hash = hash('sha256', $userData['salt']) . hash('sha256', $password) ;
echo "<br>" . $hash;
if($hash != $userData['password']) // Incorrect password. So, redirect to login_form again.
{
    header('Location: index.html');
}else{ // Redirect to home page after successful login.
	session_regenerate_id();
	$_SESSION['sess_user_id'] = $userData['id'];
	$_SESSION['sess_username'] = $userData['username'];
	session_write_close();
	header('Location: home.php');
}
?>