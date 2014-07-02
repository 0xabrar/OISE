<?php

 
//Get information about user
$username = $_POST['username'];
$password = $_POST['password'];

//Convert password into a hash
$salt = rand_string(25);
$hash = hash('sha256', $salt) . hash('sha256', $password);
 
$con = mysqli_connect('localhost', 'root', 'candy12', 'students');
//Check if the user exists already in the database.
$query = "SELECT id, username, password, salt
        FROM member
        WHERE username = '$username';";
$result = mysqli_query($con, $query);
if(mysqli_num_rows($result) == 0) //User doesn't already exist
{
	//Add user to the database
	$query = "INSERT INTO member (username, password, salt)
		VALUES ('$username', '$hash', '$salt')"; 
	$result = mysqli_query($con, $query);
} 
mysqli_close($con);
header('Location: index.html');

function rand_string( $length ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
    $size = strlen( $chars );
    for( $i = 0; $i < $length; $i++ ) {
        $str .= $chars[ rand( 0, $size - 1 ) ];
    }
    return $str;
}
?>