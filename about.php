<?php
	session_start();
	require_once('common-definitions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>About - Team Manager</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="/styles/style.css" /> 
	</head>

	<body id="about-body">
		<div id="container">
			<div id="about-header">
			      <h1>About</h1>
			</div>

<?php
	include("includes/navbar.php");
?>
      
			<div id="about-content">
				<p>You can manage your team here.</p>
			</div>

<?php
	include("includes/footer.php");
?>
		</div> <!-- end container -->
	</body>
</html>
