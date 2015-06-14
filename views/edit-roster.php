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

require_once "../models/common-definitions.php";
require_once "../models/roster.php";

if (!empty($_POST['edit']))
{
    // I don't need to do anything here, really
}
// the user has put a name into the field and pressed the 'Add' button. Try adding to the db
else if (!empty($_POST['addplayer']))
{
//TODO sanitize user input!!!
    $db_con = connectToDB();

    // add the new player
    $db_query_result = mysqli_query($db_con, "INSERT INTO team (name, number, gender) VALUES (\"" . $_POST['playerName'] . "\", NULL, NULL)");
//DEBUG
/*if ($db_query_result == NULL)
{
echo "<p class=\"db-error\">The result was NULL :(</p>";
}
else
{
echo "<p>Add player success?<br>\$db_query_result = " . $db_query_result . "</p>";
}*/
//END DEBUG

    closeDB($db_con);
}
else if (!empty($_POST['removeplayer']))
{
    // show form to remove player
//TODO Do I want radio buttons next to names above? If so, can I put those buttons in a separate <form> block? Otherwise, show drop-down box.
    echo "<p>Remove player not implemented yet.</p>";
}
else
{
    // there was an error processing the request. Return to previous page.
//TODO
    echo "<p class=\"error\">There was an error. I don't know what action I'm supposed to do!";
}

?>

    <div id="roster">
<?php

displayRosterTable();

?>
    </div> <!-- roster -->

    <div id="form-add-player">
<!-- //TODO labels for input fields! -->
        <form action="/edit-roster" method="post">
            <input type="input" name="playerName" />
<!-- //TODO use btnName or nameBtn for form elements (in given case, a button) -->
            <input type="submit" name="addplayer" value="Add this player to my roster" />
        </form>
    </div> <!-- form-addplayer -->
