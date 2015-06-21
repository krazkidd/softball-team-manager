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

require_once dirname(__FILE__) . '/../models/league.php';

$title = 'Team Profile';

ob_start();

?>
    <img id="team-img" title="<?= $teamName ?>" style="border-color: #<?= $secColor ?>" src="<?= $teamImageURI ?>" />

    <h2 style="color: #<?= $priColor ?>; background-color: #<?= $secColor ?>">
        <?= $teamName ?>
    </h2>

    <h4>Manager</h4>
    <p>
<?php if ($isLoggedIn): ?>
    <?php if (isset($mgrURI) && isset($mgrName)): ?>
        <a href="<?= $mgrURI ?>"><?= $mgrName ?></a>
    <?php else: ?>
        None
    <?php endif; ?>
<?php else: ?>
    [<a href="<?= getLoginURI() ?>">Log in</a> to view]
<?php endif; ?>
    </p>

<?php if (!empty($motto)): ?>
    <h4>Motto</h4>
    <p><?= $motto ?></p>
<?php endif; ?>

<?php if (!empty($missionStatement)): ?>
    <h4>Mission Statement</h4>
    <p><?= $missionStatement ?></p>
<?php endif; ?>

    <hr />

<?php if ($leagueList): ?>
    <p><span class="bold"><?= $teamName ?></span> have played in these leagues:</p>
    <ul>
    <?php foreach ($leagueList as $league): ?>
        <li><a href="<?= getLeagueURI($league) ?>"><?= getLeagueDescription($league) ?></a></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php 

$content = ob_get_clean();

require dirname(__FILE__) . '/../views/begin-view.php';

require dirname(__FILE__) . '/../templates/layout.php';

