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

    <h2><?= $name ?></h2>
    <?= !empty($nickName) ? "<h3>$nickName</h3>" : '' ?>

    <h4>Phone</h4>
    <p><?= $phone ?></p>
    <h4>Email</h4>
    <p><?= $email ?></p>
    <h4>Gender</h4>
    <p><?= $gender ?></p>

<?php if ($teams): ?>
    <hr />

    <p><span class="bold"><?= !empty($nickName) ? $nickName : $firstName ?></span>'s current and past teams:</p>
    <ul>
    <?php foreach ($teams as $team): ?>
        <li><a href="<?= getTeamURI($team) ?>"><?= getTeamName($team) ?></a></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php

$content = ob_get_clean();

require dirname(__FILE__) . '/../templates/layout.php';

