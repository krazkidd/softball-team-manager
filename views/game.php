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

    <div id="game-info">
        <p><?= date("l\, F j\, Y", $gameTime) ?></p>
        <p><?= date("g\:i a", $gameTime) ?></p>
    </div> <!-- game-info -->

    <div id="away-team">
        <h2>Away - <a href="/team/<?= $awayTeamInfo['ID'] ?>"><?= $awayTeamInfo['TeamName'] ?></a></h2>
        <img alt="<?= $awayTeamInfo['TeamName'] ?>" src="/img/team-no-image.png" />
    </div> <!-- away-team -->

    <div id="home-team">
        <h2>Home - <a href="/team/<?= $homeTeamInfo['ID'] ?>"><?= $homeTeamInfo['TeamName'] ?></a></h2>
        <img alt="<?= $homeTeamInfo['TeamName'] ?>" src="/img/team-no-image.png" />
        <p>Regular season record (whole season or only up to game date?) here. Any other info I can track and display here?</p>
    </div> <!-- home-team -->
<?php if ($showResults): ?>
    <div id="final-score">
        <p>Final Score</p>
        <p><?= $gameInfo['AwayTeamScore'] ?> - <?= $gameInfo['HomeTeamScore'] ?></p>
    </div> <!-- final-score -->
<?php endif; ?>
<?php

$content = ob_get_clean();

require dirname(__FILE__) . '/../views/begin-view.php';

require dirname(__FILE__) . '/../templates/layout.php';

