<?php
	session_start();
	require_once('common-definitions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Help - Team Manager</title>
	<meta http-equiv="content-type" 
		content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="styles/style.css" /> 
	</head>

	<body id="help-body">
		<div id="container">

			<div id="help-header">
			      <h1>Help</h1>
			</div>

<?php
	include('includes/navbar.php');
?>
      
			<div id="help-content">
				<p>Do you need some help, little baby? Do you want me to call the Waaaaaaaahhhmbulance?</p>
			</div>

<?php
	include('includes/footer.php');
?>
		</div> <!-- end container -->
	</body>
</html>
