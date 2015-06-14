<?php

  /**************************************************************************

  This file is part of Team Manager.

  Copyright © 2013 Mark Ross <krazkidd@gmail.com>

  Team Manager is free software: you can redistribute it and/or modify
  it under the terms of the GNU Affero General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  Team Manager is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU Affero General Public License for more details.

  You should have received a copy of the GNU Affero General Public License
  along with Team Manager.  If not, see <http://www.gnu.org/licenses/>.
  
  **************************************************************************/

$title = 'Register';

ob_start();
	
?><?php if ( !empty($action) && $action == 'reg-success') { ?>
	<p class='success-msg'>Your registration was successful! You are now logged in.</p>
<?php }	else { // show registration form ?>
	<p>This website uses cookies to keep track of your session.</p>

	<p class="warning">Do NOT use the same login name/password combination that you use on another site.</span></p>

	<p>I cannot make any guarantees on the security of your data here. Even though I salt + hash your password before
	    saving it, it is still transmitted in plaintext across the Internet before doing so. (I need an SSL certificate
	    to prevent that.)</p>

	<form action="/register" method="post">
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

	<?php if ( !empty($action) && $action == 'reg-fail') { ?>
		<p class="fail-msg">Registration failed. Try again.</p>
	<?php } ?>
<?php }

$content = ob_get_clean();

require '../templates/layout.php';
