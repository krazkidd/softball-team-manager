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

//TODO this won't work without a require, but i want to avoid doing that.
//     can i make a standard include with basic stuff in it like this?
$isLoggedIn = isLoggedIn()

?><div id="navbar">
	<ul>
		<li><a href="/" title="Home">Home</a></li>
		<!-- <li<?= !$isLoggedIn ? ' class="navNotLoggedIn"' : "" ?>><a href="/roster">Roster</a></li> -->
		<?= $isLoggedIn ? '<li><a href="/my-teams">My Teams</a></li>' : "" ?>
		<li><a href="/calendar">Calendar</a></li>
		<li><a href="/about" title="About this site">About</a></li>
		<li><a href="/help" title="How to use this site">Help</a></li>
	</ul>

	<p id="navLoginName"><?= $isLoggedIn ? "You are logged in as " . getLoginName() . ". <a href=\"/logout\" title=\"Log out\">Log out</a>"
                                         : "You are not logged in. <a href=\"/login\" title=\"Log in or Register\">Log in or Register</a>" ?>
    </p>
</div>
