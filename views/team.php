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

$title = 'Team Profile';

ob_start();

?><img id="team-img" title="<?= $teamName ?>" src="/img/team-no-image.png" />
	<h2><span style="color: #<?= $priColor ?>; background-color: #<?= $secColor ?>"><?= $teamName ?></span></h2>
	<h4>Motto</h4>
	<p><?= $motto ?></p>
	<h4>Mission Statement</h4>
	<p><?= $missionStatement ?></p>
	<!-- <h6>Notes</h6>
	<p><?= $notes ?></p> -->
	<?php if ($isLoggedIn) { ?>
		<p>Manager: <a href="/player/<?= $mgrID ?>"><?= $mgrName ?></a></p>
	<?php } ?>

	<?php if ($leagues) { ?>
		<p><?php echo $teamName ?> have played in these leagues:<br />
			<ul>
				<?php foreach ($leagues as $league) { ?>
					<li>TODO</li>
				<?php } ?>
			</ul>
		</p>
	<?php }

$content = ob_get_clean();

require '../templates/layout.php';
