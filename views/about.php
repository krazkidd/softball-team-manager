<?php /*************************************************************************

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
  
  *************************************************************************/

$title = 'About';

ob_start();

?><p>As manager of an adult co-ed softball team, Mark Ross developed over the course of several seasons a spreadsheet
    to help him keep track of rosters and game lineups. Spreadsheets are boring, though, so he decided to recreate
    all the functions of a spreadsheet (and more) while learning some Web technologies. What you see is a
    result of that effort.</p>

    <hr />

    <p id="license">Copyright &copy; 2013 Mark Ross<br />
    <br />
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.<br />
    <br />
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.<br />
    <br />
    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.</p>

    <p>You can acquire the source for this website at its
    <a href="https://github.com/krazkidd/softball-team-manager/">Github repository</a>.</p>

<?php $content = ob_get_clean();

require 'templates/layout.php';
