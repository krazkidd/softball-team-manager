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
require_once dirname(__FILE__) . '/../models/roster.php';

$title = 'Manage';

ob_start();

?>
    <img id="team-img" title="<?= $teamName ?>" style="border-color: #<?= $secColor ?>" src="<?= $imageURI ?>" />

    <h2 style="color: #<?= $priColor ?>; background-color: #<?= $secColor ?>">
        <?= $teamName ?>
    </h2>

<?php if ($leagueList): ?>
    <hr />
    <p>Rosters (ordered by league start date):</p>
    <ul>
    <?php foreach ($leagueList as $roster): ?>
        <li><a href="<?= $app_dir . getRosterURI($teamID, $roster['ID']) ?>"><?= getLeagueDescription($roster) ?></a></li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>This team has no active rosters.</p>
<?php endif; ?> 
<?php

$content = ob_get_clean();

require dirname(__FILE__) . '/../views/begin-view.php';

require dirname(__FILE__) . '/../templates/layout.php';

