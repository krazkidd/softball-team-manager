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

$title = 'Roster';

ob_start();

if ($action == 'show-roster') {
?><!--TODO show team info -->
		<table>
			<tr>
				<th>#</th>
				<th>Name</th>
			</tr>
			<?php foreach ($roster as $player) { ?>
				<tr>
					<td><?php echo $player['ShirtNum'] ?></td>
                    <td><a href="<?= getPlayerURI($player) ?>"><?= getPlayerFullName($player) ?></a></td>
				</tr>
			<?php } ?>
		</table>
	<?php } else if ($action == 'show-team-list') { ?>
<!--TODO if a name is shown but other parameters are missing, show a list of seasons/leagues -->
<!--TODO show a list of managed teams instead of error msg. -->
		<p class="error">No team selected.</p>
	<?php }

$content = ob_get_clean();

require dirname(__FILE__) . '/../templates/layout.php';
