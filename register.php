<?php
	session_start();
	require_once('common-definitions.php');

//TODO in case the user did something while not logged in, try to save as much of their session as is reasonable
	if (isset($_SESSION['loginname']))
	{
		// user is already logged in
		header('Location: index.php');
		exit(0);
	}

	if (isset($_POST['btnRegister']))
	{
//TODO is an empty field ever NULL, or just an empty string?
//TODO don't allow blank password. do some basic password enforcement
		if ($_POST['loginName'] != NULL && $_POST['loginName'] != "" && $_POST['password1'] == $_POST['password2'])
		{
//TODO sanitize input. also don't allow only differences in case or spacing for login names
			
			$db_con = connectToDB();

			$ret = mysqli_query($db_con, 'INSERT INTO `User` VALUES (\'' . $_POST['loginName'] . '\', \'' . password_hash($_POST['password1'], PASSWORD_DEFAULT) . '\', NULL)');

			if ($ret)
			{
				// save login name to session
				$_SESSION['loginname'] = $_POST['loginName'];
			}
//DEBUG
else
	error_log('Could not register user \'' . $_POST['loginName'] . '\'. (Could not INSERT into User table.)');
//END DEBUG
			closeDB($db_con);
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Register - Team Manager</title>
		<meta http-equiv="content-type" 
			content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="styles/style.css" /> 
	</head>

	<body id="register-body">
		<div id="container">
			<div id="register-header">
				<h1>Register</h1>
			</div> <!-- register-header -->

<?php
	include('includes/navbar.php');
?>

			<div id="register-content">
<?php
	// if user was trying to register and they now have a login name, show success message
	if (isset($_POST['btnRegister']) && isset($_SESSION['loginname']))
	{
?>
<!--TODO use fancier success message. add green color and junk -->
				<p>Your registration was successful!</p>
<?php
	}
	else
	{
?>
				<p>Make sure cookies are enabled in your browser.</p>

				<p><span class="warning">Do NOT use the same login name/password combination that you use on another site.</span>
				    I cannot make any guarantees on the security of your data here. Even though I salt + hash your password before
				    saving it, it is still transmitted in plaintext across the Internet before doing so. I need an SSL certificate
				    to prevent that.</p>

				<form action="register.php" method="post">
					<div id="frmLogin">
						<label for="loginName">Login name:</label>
						<input type="text" name="loginName" id="loginName" value="<?= isset($_POST['loginName']) ? $_POST['loginName'] : '' ?>" /><br />

						<label for="password1">Password:</label>
						<input type="password" name="password1" id="password1" /><br />

						<label for="password2">Re-enter password:</label>
						<input type="password" name="password2" id="password2" /><br />

						<input type="submit" value="Register" name="btnRegister" />
					</div>
				</form>
<?php
		if (isset($_POST['btnRegister']) && !isset($_SESSION['loginname']))
		{
?>
<!--TODO warn user if a field was missing or passwords don't match. -->
				<p class="error">Your registration was unsuccessful. Try again.</p>
<?php
		}
	}
?>
			</div> <!-- login-content -->

<?php
	include('includes/footer.php');
?>
		</div> <!-- end container -->
	</body>
</html>
