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
        <p>Team <?= $teamInfo['TeamName'] ?></p>
        <p>League TODO</p>
        <p>Coach/Manager TODO</p>

        <div id="batting-order">
            <table>
                <tr>
                    <th colspan="4">Starting Lineup</th>
                </tr>
                <tr>
                    <td>No.</td>
                    <td>First &amp; Last Name</td>
                    <td>Pos.</td>
                    <td>Sub. #</td>
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
                    <td><?= $player['FirstName'] . ' ' . $player['LastName'] ?></td>
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
                    <td>No.</td>
                    <td colspan="3">First &amp; Last Name</td>
                </tr>
<?php
    $subs = getSubs($lineup);
    for ($i = 0; $i <= 2; $i++)
    {
        //$player = $subs[$i]; //FIXME we want to always show three EP rows
        $player = NULL;        //      but we don't necessarily have three EPs 

        if ($player)
        {
?>
                <tr>
                    <td><!-- TODO shirt num --></td>
                    <td colspan="3"><?= $player['FirstName'] . ' ' . $player['LastName'] ?></td>
                </tr>
<?php
        }
        else
        {
?>
                <tr><td>&nbsp;</td><td colspan="3">TODO&nbsp;</td></tr>
<?php
        }
    }
?>
            </table>
        </div>
    </div> <!-- lineup-whole-form -->

    <p>View the <a href="/field-layout?<?= "gameid={$gameID}&teamid={$teamID}&leagueid={$leagueID}" ?>">Field Layout</a>.</p>
<?php
}

$content = ob_get_clean();

require '../templates/layout.php';
