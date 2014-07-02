<?php
//Start session
session_start();
 
//Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
	header("location: index.html");
	exit();
}
?>
<!DOCTYPE html>
<head>
<meta content="text/html; charset=utf-8" />
<title>Home Page</title>
</head>
 
<body>
<h1>Welcome, <?php echo $_SESSION["sess_username"] ?></h1>
</body>
</html>