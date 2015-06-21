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

$title = 'Game';

ob_start();

?>
    <!--TODO only show for the team the player is on: <p><a href="/field-layout">View Field Layout &gt; &gt;</a></p> -->

    <h3><?= date('l\, F j\, Y', $gameTime) ?> @ <?= date('g\:i a', $gameTime) ?></h3>

<?php if ($showResults): ?>
    <div id="final-score" <?= isset($winColor) ? "style=\"background-color: #$winColor\"" : '' ?>>
        <p class="bold">Final Score</p>
        <p><?= $awayScore ?> - <?= $homeScore ?></p>
    </div> <!-- final-score -->
<?php endif; ?>

    <div id="head-to-head">
        <div id="away-team" style="background-color: #<?= $awaySecColor ?>">
            <h2><a href="<?= getTeamURI($awayInfo) ?>" style="color: #<?= $awayPriColor ?>"><?= getTeamName($awayInfo) ?></a> - Away</h2>
            <img alt="<?= getTeamName($awayTeamInfo) ?>" style="border-color: #<?= $awayPriColor ?>" src="/img/team-no-image.png" />
        </div> <!-- away-team -->

        <div id="home-team" style="background-color: #<?= $homeSecColor ?>">
            <h2>Home - <a href="<?= getTeamURI($homeInfo) ?>" style="color: #<?= $homePriColor ?>"><?= getTeamName($homeInfo) ?></a></h2>
            <img alt="<?= getTeamName($homeTeamInfo) ?>" style="border-color: #<?= $homePriColor ?>" src="/img/team-no-image.png" />
            <!-- TODO show regular season record (whole season or only up to game date?) here. Any other info I can track and display here? -->
        </div> <!-- home-team -->
    </div>
<?php

$content = ob_get_clean();

require dirname(__FILE__) . '/../views/begin-view.php';

require dirname(__FILE__) . '/../templates/layout.php';

