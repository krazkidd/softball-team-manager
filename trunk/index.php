<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
	<title>Home - Team Manager</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="styles/style.css" /> 
<?php
	require_once("common-definitions.php");
?>
	</head>

	<body id="index-body">
		<div id="container">

			<div id="index-header">
			      <h1>Home</h1>
			</div>

<?php
	include("includes/navbar.php");
?>
      
			<div id="index-content">
				<p>Welcome to a team management website. Are you impressed?</p>
			</div>

<?php
	include("includes/login-module.php");

	include("includes/footer.php");
?>
		</div> <!-- end container -->
	</body>
</html>
