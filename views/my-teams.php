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

$title = 'My Teams';

ob_start();

//TODO show team colors and small icon; remove list bullets
?>
<?php if ($managedTeamsList): ?>
    <p>Teams I manage (click to go to team's management interface):</p>
    <ul>
    <?php foreach ($managedTeamsList as $team ): ?>
        <li><a href="<?= $app_dir . getManageURI($team) ?>"><?= getTeamName($team) ?></a></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($rosteredTeamsList): ?>
    <p>Teams I play on (click to go to team's profile):</p>
    <ul>
    <?php foreach ($rosteredTeamsList as $teamLeague): ?>
        <li><a href="<?= $app_dir . getTeamURI($teamLeague) ?>"><?= getTeamName($teamLeague) ?></a></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php

$content = ob_get_clean();

require dirname(__FILE__) . '/../views/begin-view.php';

require dirname(__FILE__) . '/../templates/layout.php';

