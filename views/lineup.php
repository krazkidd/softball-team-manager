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

$title = 'Calendar';

ob_start();

if ( !isset($_GET["id"]))
{
//TODO have getNextGames return a regular array instead of a mysql result
    $db_next_games_query_result = getNextGames(6, date("Y-m-d"));

    if ($db_next_games_query_result == NULL)
    {
?>
    <p>I need a game ID. Try using the <a href="calendar.php">Calendar</a>.</p>
<?php
    }
    else
    {
?>
    <p>I need a game ID. Try using the <a href="calendar.php">Calendar</a> or one of the following games in your default season:</p>
    <ul>
<?php
        $thisFile = $_SERVER["PHP_SELF"];
        $parts = Explode('/', $thisFile);
        $thisFile = $parts[count($parts) - 1];

        while ($row = mysqli_fetch_array($db_next_games_query_result))
        {
            $gameTime = mktime(getHourFromMySQLTime($row['time']), getMinuteFromMySQLTime($row['time']), 0, getMonthFromMySQLDate($row['date']), getDayFromMySQLDate($row['date']), getYearFromMySQLDate($row['date']));
?>
        <li><a href="<?= $thisFile ?>?gameid=<?= $row["gameID"] ?>"><?= date("l\, F j\, Y", $gameTime) ?> @ <?= date("g\:i a", $gameTime) ?></a></li>
<?php
        }
    }
?>
    </ul>

</body>
</html>
<?php
    exit();
}

$gameInfo = getGameInfo($_GET["gameid"]);
//TODO change this from NULL
$lineup = getLineup($_GET["gameid"], NULL);
//DEBUG
if ($lineup == NULL)
{
?>
    <p>Bit of a problem. getLineup() returned NULL.</p>
<?php
}
//END DEBUG



//ERROR need to pull starters/non-starters from lineup?
$starters = $lineup;

//TODO need to check that a player's batting order number isn't NULL if they have a position, as well as several other things i have written on paper
//TODO check if there aren't enough players and show warning

// check the extra players. if there is an extra male and female, they belong in the starting lineup
//TODO do some more checking, like for gender. set a note to check that extra players are put into the database correctly

$gameTime = mktime(getHourFromMySQLTime($gameInfo['time']), getMinuteFromMySQLTime($gameInfo['time']), 0, getMonthFromMySQLDate($gameInfo['date']), getDayFromMySQLDate($gameInfo['date']), getYearFromMySQLDate($gameInfo['date']));
?>

    <h3><?= date("l\, F j\, Y", $gameTime) ?> @ <?= date("g\:i a", $gameTime) ?></h3>

    <div id="lineup-whole-form">
        <p>Team TODO</p>
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
//TODO check for alternating gender
for ($i = 1; $i <= count($starters); $i++)
{
//TODO is there anything wrong with being a little wanton with NULL?
//TODO I probably want to show gender as well, so I'm really going to need a way to loop either through the IDs or the positions and record everything in a big array
//TODO the style I have now should be the print style. i should make the default style easier to interact with, like when I add Javascript later
?>
                <tr>
                    <td><?= $starters[$i]["shirtNumber"] ?></td>
                    <td><?= $starters[$i]["firstName"] . " " . $starters[$i]["lastName"] ?></td>
                    <td><?= $starters[$i]["position"] ?></td>
                    <td>&nbsp;</td>
                </tr>
<?php
}

for ($i = count($starters) + 1; $i <= 12; $i++)
{
?>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
<?php
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
for ($i = 1; $i <= count($nonstarters); $i++)
{
?>
                <tr>
                    <td><?= $nonstarters["EP$i"]["shirtNumber"] ?></td>
                    <td colspan="3"><?= $nonstarters["EP$i"]["firstName"] . " " . $nonstarters["EP$i"]["lastName"] ?></td>
                </tr>
<?php
}

//TODO add EP6 to DB and to query above (and to same places in field-layout.php)
for ($i = count($nonstarters) + 1; $i <= 6; $i++)
{
?>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3">&nbsp;</td>
                </tr>
<?php
}
?>
            </table>
        </div> <!-- lineup-whole-form -->

    </div>

    <p>View the graphical Field Layout page <a href="/field-layout/<?= $_GET["id"] /*TODO the id is the lineup id, so this is wrong*/ ?>">here</a>.</p>

<?php

$content = ob_get_clean();

require '../templates/layout.php';
