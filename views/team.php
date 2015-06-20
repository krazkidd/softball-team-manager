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

?>
    <img id="team-img" title="<?= $teamName ?>" src="<?= $teamImageURI ?>" />

    <h1 style="color: #<?= $priColor ?>; background-color: #<?= $secColor ?>">
        <?= $teamName ?>
    </h1>
<?php if ($isLoggedIn): ?>
    <?php if (isset($mgrURI) && isset($mgrName)): ?>
    <p>Manager: <a href="<?= $mgrURI ?>"><?= $mgrName ?></a></p>
    <?php else: ?>
    <p>Manager: None</p>
    <?php endif; ?>
<?php endif; ?>

    <h4>Motto</h4>
    <p><?= $motto ?></p>

    <h4>Mission Statement</h4>
    <p><?= $missionStatement ?></p>

    <hr />

<?php if ($leagueList): ?>
    <p><?php echo $teamName ?> have played in these leagues:</p>
    <ul>
    <?php foreach ($leagueList as $league): ?>
        <li><?= getLeagueDescription($league) ?></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php 

$content = ob_get_clean();

require dirname(__FILE__) . '/../templates/layout.php';

