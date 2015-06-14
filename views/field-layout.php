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

//TODO all this controller logic needs to go in controllers file

$title = 'Field Layout';

ob_start();

?><?php
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
    while ($row = mysqli_fetch_array($db_next_games_query_result))
    {
        $gameTime = mktime(getHourFromMySQLTime($row['time']), getMinuteFromMySQLTime($row['time']), 0, getMonthFromMySQLDate($row['date']), getDayFromMySQLDate($row['date']), getYearFromMySQLDate($row['date']));
?>
        <li><a href="/field-layout/"<?= $row["gameID"] ?>"><?= date("l\, F j\, Y", $gameTime) ?> @ <?= date("g\:i a", $gameTime) ?></a></li>
<?php
    }
}
?>
    </ul>
<?php

//DEBUG
// show an error if the query failed
if ($lineupPlayerIDs == NULL)
  echo "<p class=\"db-error\">The lineup result was NULL :(</p>";
//END DEBUG

//TODO need to check that a player's batting order number isn't NULL if they have a position, as well as several other things i have written on paper
?>
    <h3><?= date("l\, F j\, Y", $gameTime) ?> @ <?= date("g\:i a", $gameTime) ?></h3>

    <div id="softballField">
<?php
for ($i = 1; $i <= count($starters); $i++)
{
//TODO write a function to return gender CSS class! because there is -male, -female, and -missing and i don't want to use nested ?: things
?>
        <div id="field-pos-<?= $i ?>" class="playerPos gender-<?= $starters[$i]["gender"][0] == "M" ? "male" : "female" ?>">
            <p>#<?= $starters[$i]["shirtNumber"] ?> <?= $starters[$i]["firstName"] ?> <?= $starters[$i]["lastName"][0] ?>.</p>
        </div>
<?php
}
?>
    </div>

<?php
if (count($nonstarters) > 0)
{
?>
    <div id="extra-player-list">
        <p>Extra players:</p>
        <ul>
<?php
    if ($lineupBatPos["batPosEP1"] && $lineupBatPos["batPosEP2"])
    {
?>
            <li class="ep-is-starter">#<?= $starters["EP1"]["shirtNumber"] ?> <?= $starters["EP1"]["firstName"] . " " . $starters["EP1"]["lastName"] ?> is in the batting order!</li>
            <li class="ep-is-starter">#<?= $starters["EP2"]["shirtNumber"] ?> <?= $starters["EP2"]["firstName"] . " " . $starters["EP1"]["lastName"] ?> is in the batting order!</li>
<?php
    }
    else
    {
        if ($nonstarters["EP1"])
        {
?>
            <li>#<?= $nonstarters["EP1"]["shirtNumber"] ?> <?= $nonstarters["EP1"]["firstName"] . " " . $nonstarters["EP1"]["lastName"] ?></li>
<?php
        }
        if ($nonstarters["EP2"])
        {
?>
            <li>#<?= $nonstarters["EP2"]["shirtNumber"] ?> <?= $nonstarters["EP2"]["firstName"] . " " . $nonstarters["EP2"]["lastName"] ?></li>
<?php
        }
    }

//TODO add EP6
    for ($i = 3; $i <= 5; $i++)
    {
        if ($nonstarters["EP$i"])
        {
?>
            <li>#<?= $starters["EP$i"]["shirtNumber"] ?> <?= $nonstarters["EP$i"]["firstName"] . " " . $nonstarters["EP1"]["lastName"] ?></li>
<?php
        }
?>
        </ul>
<?php
    }
?>
    </div>
<?php
	}

$content = ob_get_clean();

require '../templates/layout.php';
