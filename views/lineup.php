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

require_once dirname(__FILE__) . '/../models/lineup.php';

$title = 'Lineup';

ob_start();

?>
    <h3><?= date('l\, F j\, Y', $gameTime) ?> @ <?= date('g\:i a', $gameTime) ?></h3>

    <div id="lineup-whole-form">
        <div class="lineup-header">
            <p>Team</p>
            <p><?= $teamName ?></p>
        </div>
        <div class="lineup-header">
            <p>League</p>
            <!-- TODO when this is too long, it makes the table not take up the whole width; see css -->
            <p><?= $leagueDesc ?></p>
        </div>
        <div class="lineup-header">
            <p>Coach/Manager</p>
            <p><?= $mgrName ?></p>
        </div>

        <div id="batting-order">
            <table>
                <tr>
                    <th colspan="4">Starting Lineup</th>
                </tr>
                <tr>
                    <th>No.</th>
                    <th>First &amp; Last Name</th>
                    <th>Pos.</th>
                    <th>Sub. #</th>
                </tr>
<?php
foreach ($starters as $player)
{
    if ($player)
    {
?>
                <tr>
                    <td><?= getShirtNum($lineup, $player) ?></td>
                    <td><?= getFullName($player) ?></td>
                    <td><?= getShortPosName(getFieldPosForPlayer($lineup, $player)) ?></td>
                    <td>&nbsp;</td>
                </tr>
<?php
    }
    else
    {
?>
                <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<?php
    }
}
?>
                <tr>
                    <th colspan="4">Non-Starters</th>
                </tr>
                <tr>
                    <th>No.</th>
                    <th colspan="3">First &amp; Last Name</th>
                </tr>
<?php
foreach ($extraPlayers as $player)
{
    if ($player)
    {
?>
                <tr>
                    <td><?= getShirtNum($lineup, $player) ?></td>
                    <td colspan="3"><?= getFullName($player) ?></td>
                </tr>
<?php
    }
    else
    {
?>
                <tr><td>&nbsp;</td><td colspan="3">&nbsp;</td></tr>
<?php
    }
}
?>
            </table>
        </div>
    </div> <!-- lineup-whole-form -->

    <p>View the <a href="<?= getFieldLayoutURI($lineup) ?>">Field Layout</a>.</p>
<?php

$content = ob_get_clean();

require dirname(__FILE__) . '/../templates/layout.php';
