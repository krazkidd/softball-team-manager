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

<?php $title = 'About' ?>

<?php ob_start() ?>

    <p>Management of my co-ed softball team was thrust upon me one day. To fulfill the team's purpose
    of making sure everyone got a fair amount of play time and access to preferred field positions,
    I had to develop a marginally sophisticated spreadsheet. One weekend, I even got bored and started
    writing a script to parse my lineup/schedule sheet and put it in graphical form: An image of a
    softball field with player names at all the positions. I thought I'd like to share that work or
    at the very least to make it more robust. Thus what you have before you.</p>

    <p>The app is still under heavy development and most of the features are currently broken. I could
    put up an old, seemingly-more-complete revision but since I had a couple bugs due to PHP delopment/production version mismatches,
    I'd rather just leave up what I have. And because the project is a little ambitious, I'm actually going
    to scale back the features targeted for whatever hypothetical future release might happen, starting with
    just a simple lineup editor.</p>

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

    <p>You can acquire the source for this website at its Subversion 
    <a href="https://code.google.com/p/softball-team-manager/">repository</a>.</p>

<?php $content = ob_get_clean() ?>

<?php require 'templates/layout.php' ?>
