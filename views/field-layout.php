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

?>
    <h3><?= $gameDateTimeHeader ?></h3>

    <div id="extra-player-table">
        <table>
            <tr>
                <th colspan="2">Extra Players</th>
            </tr>
<?php
if ($extraPlayers)
{
?>
<?php
    foreach ($extraPlayers as $player)
    {
        $shirtNum = getShirtNum($lineup, $player);
?>
            <tr>
                <td><?= $shirtNum ? '#' . $shirtNum . ' ' : '' ?></td>
                <td><a href="<?= getPlayerURI($player) ?>"><?= getShortName($player) ?></a></td>
            </tr>
<?php
    }
?>
        </table>
<?php
}
else
{
?>
    <!-- TODO fix this with CSS before you put it back in: <p>None</p> -->
<?php
}
?>
    </div>

    <div id="softballField">
<?php
for ($i = 1; $i <= 10; $i++)
{
    $player = getPlayerAtFieldPos($lineup, $i);
    $shirtNum = getShirtNum($lineup, $player);
?>
        <div id="field-pos-<?= $i ?>" class="playerPos gender-<?= getGender($player, true) ?>">
            <p><?= $shirtNum ? '#' . $shirtNum . ' ' : '' ?><a href="<?= getPlayerURI($player) ?>"><?= getShortName($player) ?></a></p>
        </div>
<?php
}
?>
    </div>

    <p>View the <a href="<?= getLineupURI($lineup) ?>">Lineup</a>.</p>
<?php

$content = ob_get_clean();

require dirname(__FILE__) . '/../templates/layout.php';
