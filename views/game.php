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

?><p><a href="/field-layout">View Field Layout &gt; &gt;</a></p> -->
<?php
//TODO check GET or POST for a game ID. if nothing, redirect to calendar? or just show a table? or pick next game?


	// check if a whole night is requested or just a single game
//TODO to be more robust, i should prioritize gameid over date, i.e. ignore date if gameid is present
	if (isset($_GET['gameid']))
	{
		$db_game_info_query_result = mysqli_query($db_con, "SELECT * FROM games JOIN leagues ON leagues.leagueID = games.associatedLeague JOIN seasons ON seasons.seasonID = leagues.associatedSeason JOIN teams AS t1 ON games.homeTeam = t1.teamID JOIN teams as t2 ON games.visitingTeam = t2.teamID WHERE gameID = {$_GET['gameid']}");
		$db_team_info_query_result = mysqli_query($db_con, "SELECT * FROM teams JOIN games ON games.homeTeam = teams.teamID OR games.visitingTeam = teams.teamID WHERE gameID = {$_GET['gameid']}");
//DEBUG
// show an error if either of the queries failed
if ($db_game_info_query_result == NULL)
{
  echo "<p class=\"db-error\">The game info result was NULL :(</p>";
}
if ($db_team_info_query_result == NULL)
{
  echo "<p class=\"db-error\">The team info result was NULL :(</p>";
}
//END DEBUG
		$gameInfo = mysqli_fetch_array($db_game_info_query_result);
		$homeTeamInfo = mysqli_fetch_array($db_team_info_query_result);
		// make sure I really got the home team
		if ($homeTeamInfo['teamID'] != $gameInfo['homeTeam'])
		{
			$awayTeamInfo = $homeTeamInfo;
			$homeTeamInfo = mysqli_fetch_array($db_team_info_query_result);
		}
		else
			$awayTeamInfo = mysqli_fetch_array($db_team_info_query_result);

		$showResults = false;
		if (time() > mktime(getHourFromMySQLTime($gameInfo['time']) + 1, getMinuteFromMySQLTime($gameInfo['time']), 0, getMonthFromMySQLDate($gameInfo['date']), getDayFromMySQLDate($gameInfo['date']), getYearFromMySQLDate($gameInfo['date'])))
			$showResults = true;
?>
		<div id="game-info">
			<p><?= $gameInfo['description'] ?></p>
			<?php $gameTime = mktime(getHourFromMySQLTime($gameInfo['time']), getMinuteFromMySQLTime($gameInfo['time']), 0, getMonthFromMySQLDate($gameInfo['date']), getDayFromMySQLDate($gameInfo['date']), getYearFromMySQLDate($gameInfo['date'])); ?>
			<p><?= date("l\, F j\, Y", $gameTime) ?></p>
			<p><?= date("g\:i a", $gameTime) ?></p>
			<p><?php echo $gameInfo['park'] . ", Field #" . $gameInfo['field']; ?></p>
					
		</div> <!-- game-info -->

		<div id="home-team">
			<h2>Home - <a href="team/<?= $homeTeamInfo['teamID'] ?>"><?= $homeTeamInfo['name'] ?></a></h2>
			<img alt="<?= $homeTeamInfo['name'] ?>" src="/img/team-no-image.png" />
			<p>Regular season record (whole season or only up to game date?) here. Any other info I can track and display here?</p>
		</div> <!-- home-team -->
		
		<div id="away-team">
			<h2>Away - <a href="team/<?= $awayTeamInfo['teamID'] ?>"><?= $awayTeamInfo['name'] ?></a></h2>
			<img alt="<?= $awayTeamInfo['name'] ?>" src="/img/team-no-image.png" />
		</div> <!-- away-team -->
		<?php
			if ($showResults)
			{
		?>
		<div id="final-score">
			<p>Final Score</p>
			<p><?= $gameInfo['finalHomeScore'] ?> - <?= $gameInfo['finalVisitingScore'] ?></p>
		</div> <!-- final-score -->
		<?php
			}
		?>
<?php
	}
	else
//TODO don't use die(), and close the db if needed
		die("I need a gameid.");

$content = ob_get_clean();

require '../templates/layout.php';
