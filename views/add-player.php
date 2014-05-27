<!-- *************************************************************************

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
  
************************************************************************* -->

THIS IS NOT BEING USED.

<?php
	require_once("common-definitions.php");
?>

<?php
	$db_con = connectToDB();

	// get player names and numbers and show them in a table
//TODO user input needs to be sanitized
	$db_query_result = mysqli_query($db_con, "INSERT ");
	echo "<table><tr><th>Player Name</th><th>Number</th><th>Gender</th></tr>";
//DEBUG
if ($db_query_result == NULL)
{
  echo "<p class=\"db-error\">The result was NULL :(</p>";
}
//END DEBUG
	while ($row = mysqli_fetch_array($db_query_result))
	{
		$gender = $row['gender'];

                if ($gender == 'M')
			echo "<tr class=\"gender-male\">";
		else
			echo "<tr class=\"gender-female\">";
		echo "<td>" . $row['name'] . "</td><td>" . $row['number'] . "</td><td>" . $row['gender'] . "</td></tr>";
	}
	echo "</table>";

	closeDB($db_con);
?>
