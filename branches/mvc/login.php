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
	if (isset($_POST['btnLogIn']))
	{
//TODO sanitize input
		if ($_POST['loginName'] != NULL && $_POST['loginName'] != "" && $_POST['password'] != NULL && $_POST['password'] != "")
		{
			$db_con = connectToDB();

			$ret = mysqli_query($db_con, 'SELECT * FROM `User` WHERE Login = \'' . $_POST['loginName'] . '\'');

			$result = mysqli_fetch_array($ret);

			if ($ret)
			{
				if (password_verify($_POST['password'], $result['PasswordHash']))
				{
					// save login name to session
					$_SESSION['loginname'] = $_POST['loginName'];
				}
			}
//DEBUG
else
{
	echo "DB result was NULL...";
}
//END DEBUG
			closeDB($db_con);
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Login - Team Manager</title>
		<meta http-equiv="content-type" 
			content="text/html;charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="styles/style.css" /> 
	</head>

	<body id="login-body">
		<div id="container">
			<div id="login-header">
				<h1>Login</h1>
			</div> <!-- login-header -->

<?php
	include('includes/navbar.php');
?>

			<div id="login-content">
<?php
	// if user was trying to log in and they now have a login name, show success message
	if (isset($_POST['btnLogIn']) && isset($_SESSION['loginname']))
	{
?>
<!--TODO use fancier success message. add green color and junk -->
				<p>You were successfully logged in!</p>
<?php
	}
	else
	{
?>
				<p>Make sure cookies are enabled in your browser.</p>

				<form action="login.php" method="post">
					<div id="frmLogin">
						<label for="loginName">Login name:</label>
						<input type="text" name="loginName" id="loginName" value="<?= isset($_POST['loginName']) ? $_POST['loginName'] : '' ?>"/><br />

						<label for="password">Password:</label>
						<input type="password" name="password" id="password" /><br />

						<input type="submit" value="Log In" name="btnLogIn" />
					</div>
				</form>

				<p> or <a href="register.php" title="Register">Register</a></p>

<?php
		if (isset($_POST['btnLogIn']) && !isset($_SESSION['loginname']))
		{
?>
<!--TODO warn user if a field was missing or passwords don't match. -->
				<p class="error">Your login was unsuccessful. Try again.</p>
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
