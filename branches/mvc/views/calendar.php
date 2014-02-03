<?php $title = 'Calendar' ?>

<?php ob_start() ?>

	<?php if ($action == 'list-leagues-day-of-week') { ?>
		<h2><?= $day ?> Leagues</h2>

		<table>
			<tr>
				<th>Division</th>
				<th>Class</th>
				<th>Description</th>
			</tr>
			<?php foreach ($leaguesList as $league) { ?>
				<tr>
<!--TODO fix associated array keys -->
<!--TODO add a link to league info (i don't have a league info page yet) -->
<!--TODO add the other columns retrieved in query above. -->
					<td><?= $league['division'] ?></td>
					<td><?= $league['class'] ?></td>
					<td><?= $league['description'] ?></td>
				</tr>
			<?php } ?>
		</table>
<!--TODO fix. if  -->
	<?php }	else if ($action = 'list-games-on-date') { ?>
			<h3><?= $date ?></h3> 

			<div id="game-list">
				<table>
					<tr>
						<th>Time</th>
						<th>Home Team</th>
						<th>Visiting Team</th>
						<?php if ($showResults) { ?>
							<th>Final Home Score</th>
							<th>Final Visiting Score</th>
						<?php } ?>
					</tr>
					<?php foreach ($gamesList as $game) { ?>
						<tr>
							<td><a href="game-info.php?gameid=<?= $row['gameID'] ?>"><?= date("g\:i a", mktimeFromMySQLTime($row['time'])) ?></a></td>
							<td><?= $homeTeamRow["name"] ?></td>
							<td><?= $awayTeamRow["name"] ?></td>
							<?php if ($showResults) { ?>
								<td><?= $finalHome ?> <?= $finalHome > $finalAway ? "<img alt=\"Winner\" src=\"icons/1373708645_trophy.png\" />" : "" ?></td>
								<td><?= $finalAway ?> <?= $finalAway > $finalHome ? "<img alt=\"Winner\" src=\"icons/1373708645_trophy.png\" />" : "" ?></td>
						</tr>
					<?php } ?>
				</table>
			</div> <!-- game-list -->
	<?php }	else { ?>
		<table id="calendar-table">
			<tr>
				<th colspan="7"><?= $monthName ?> <?= $year ?></th>
			</tr>
			<tr>
				<td><a href="calendar.php?view=daily&amp;day=sun">Sun</a></td>
				<td><a href="calendar.php?view=daily&amp;day=mon">Mon</a></td>
				<td><a href="calendar.php?view=daily&amp;day=tue">Tue</a></td>
				<td><a href="calendar.php?view=daily&amp;day=wed">Wed</a></td>
				<td><a href="calendar.php?view=daily&amp;day=thu">Thu</a></td>
				<td><a href="calendar.php?view=daily&amp;day=fri">Fri</a></td>
				<td><a href="calendar.php?view=daily&amp;day=sat">Sat</a></td>
			</tr>
WHILE LOOP HERE
			<tr>
ERROR print calendar from array
					<td>$calendarArray[FIX][FIX]</td>
//TODO how do I want the date to show in the URL (i.e. with or without dashes?), and do dashes need to be escaped?
					<td<?= $elementClass != NULL ? " class=\"$elementClass\"" : "" ?>><?= $gameDate != NULL ? "<a href=\"calendar.php?date={$gameDate}\">$monthlyDayCount</a>" : $monthlyDayCount ?></td>
			</tr>
		</table>
	<?php } ?>

<?php $content = ob_get_clean() ?>

<?php require 'templates/layout.php' ?>
