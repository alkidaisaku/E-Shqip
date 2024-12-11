<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>HOME</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
     <a href="proxhekti/home.html" class="kreu">Vazhdo me E-Shqip</a>
     <a href="logout.php" class="kreu">Logout</a>

</body>
</html>

<?php 
}else{
     header("Location: index.php");
     exit();
}
 ?>