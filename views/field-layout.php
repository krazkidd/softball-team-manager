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

$title = 'Field Layout';

ob_start();

if ( !$isReqValid)
{
?>
    <p>Not a valid lineup request.</p>
<?php
}
else
{
?>
    <h3><?= date('l\, F j\, Y', $gameTime) ?> @ <?= date('g\:i a', $gameTime) ?></h3>

    <div id="softballField">
<?php
    for ($i = 1; $i <= 10; $i++)
    {
        $player = getPlayerAtFieldPos($lineup, $i);
?>
        <div id="field-pos-<?= $i ?>" class="playerPos gender-<?= getGender($player, true) ?>">
<!-- TODO have to get shirt number from Roster table -->
            <p><a href="<?= getPlayerURI($player) ?>">#TODO <?= getName($player) ?></a></p>
        </div>
<?php
    }
?>
    </div>
<?php
    if ($doExtraPlayersExist)
    {
?>
    <div id="extra-player-list">
        <p>Extra players:</p>
        <ul>
<?php
        for ($i = 1; $i <= 3; $i++)
        {
            $player = getExtraPlayer($lineup, $i);
            if ($player)
            {
?>
            <li><a href="<?= getPlayerURI($player) ?>">#TODO<!-- TODO shirt num --> <?= getName($player) ?></a></li>
<?php
            }
        }
?>
        </ul>
    </div>
<?php
    }
?>
    <p>View the <a href="<?= getLineupURI($lineup) ?>">Lineup</a>.</p>
<?php
}

$content = ob_get_clean();

require dirname(__FILE__) . '/../templates/layout.php';
