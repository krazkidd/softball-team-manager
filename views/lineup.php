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

$title = 'Lineup';

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

    <div id="lineup-whole-form">
        <!-- TODO put underlines and embolden the headers -->
        <div class="lineup-header-div">
            <p class="lineup-header-left">Team</p>
            <p class="lineup-header-right"><?= $teamInfo['TeamName'] ?></p>
        </div>
        <div class="lineup-header-div">
            <p class="lineup-header-left">League</p>
            <p class="lineup-header-right">TODO</p>
        </div>
        <div class="lineup-header-div">
            <p class="lineup-header-left">Coach/Manager</p>
            <p class="lineup-header-right">TODO</p>
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
    for ($i = 1; $i <= 12; $i++)
    {
        $player = getPlayerAtBatPos($lineup, $i);

        if ($player)
        {
?>
                <tr>
                    <!-- TODO don't embolden the player data -->
                    <td><!-- TODO shirt num --></td>
                    <td><?= getFullName($player) ?></td>
                    <td><!-- TODO position --></td>
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
    for ($i = 1; $i <= 3; $i++)
    {
        $player = getExtraPlayer($lineup, $i);

        if ($player)
        {
?>
                <tr>
                    <td><!-- TODO shirt num --></td>
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
}

$content = ob_get_clean();

require dirname(__FILE__) . '/../templates/layout.php';
