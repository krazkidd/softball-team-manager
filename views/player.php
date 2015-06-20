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

require_once dirname(__FILE__) . '/../models/team.php';
require_once dirname(__FILE__) . '/../models/league.php';

$title = 'Player Profile';

ob_start();

?>
    <img id="player-img" title="<?= $name ?>" src="/img/player-no-image.gif" />

	<h1><?= $name ?></h1>
	<?= !empty($nickName) ? '<h2>"' . $nickName . '"</h2>' : '' ?>

	<p><span class="bold">Phone:</span> <?= $phone ?><br />
    <span class="bold">Email:</span> <?= $email ?><br />
    <span class="bold">Gender:</span> <?= $gender ?></p>

<?php
if ($teams)
{
?>
    <hr />

	<p><?= !empty($nickName) ? $nickName : $firstName ?>'s current and past teams:</p>
    <ul>
<?php
    foreach ($teams as $teamLeague)
    {
?>
        <li><a href="<?= getTeamURI($teamLeague) ?>"><?= getTeamName($teamLeague) . ' - ' . getLeagueDescription($teamLeague) ?></a></li>
<?php
    }
?>
    </ul>
<?php
}

$content = ob_get_clean();

require dirname(__FILE__) . '/../templates/layout.php';
