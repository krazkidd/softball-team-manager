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

$title = 'Login';

ob_start();

?>
    <p>This website uses cookies to track your session.</p>

    <form action="<?= $app_dir ?>/login" method="post">
        <div id="frmLogin">
            <label for="loginName">Login name:</label>
            <input type="text" name="loginName" id="loginName" value="<?= isset($failedLoginName) ? $failedLoginName : '' ?>"/><br />

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" /><br />

            <!-- TODO <input type="checkbox" name="rememberme" value="rememberme" /><label for="rememberme">Remember me on this computer</label><br /> -->

            <input type="submit" value="Log In" name="btnLogIn" />
        </div>
    </form>

<?php if (isset($failedLoginName)): ?>
    <p class='msg-failure'>Login failed!</p>
<?php endif; ?>

    <p>or <a href="<?= $app_dir ?>/register" title="Register">Register</a></p>
<?php

$content = ob_get_clean();

require dirname(__FILE__) . '/../views/begin-view.php';

require dirname(__FILE__) . '/../templates/layout.php';

