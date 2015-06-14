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

$title = 'Help';

ob_start();

?><p>The calendar function is broken.</p>

    <p>You can log in as 'jimbean' with password 'password'. This user is the manager of a team, so
    you can see what a manager sees.</p>

    <p>You can register as a new user but can't do much managing yet.</p><?php
$content = ob_get_clean();

require '../templates/layout.php';
