<?php

  /**************************************************************************

  This file is part of Team Manager.

  Copyright © 2013-2015 Mark Ross <krazkidd@gmail.com>

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

session_start();

require_once dirname(__FILE__) . '/../config/config.php';

function my_autoloader($class) {
        include dirname(__FILE__) . '/../models/' . $class . '.class.php';
}

function isID($id)
{
    return is_numeric($id) && is_int($id + 0) && $id > 0;
}


spl_autoload_register('my_autoloader');

foreach ($_GET as $key => $val) {
    switch (strtolower($key)) {
        case 'id':
            if (isID($val)) {
                $id  = $val;
            }
            break;
        case 'teamid':
            if (isID($val)) {
                $teamid  = $val;
            }
            break;
        case 'leagueid':
            if (isID($val)) {
                $leagueid  = $val;
            }
            break;
        case 'gameid':
            if (isID($val)) {
                $gameid  = $val;
            }
            break;
    }
}

