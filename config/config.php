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

require_once dirname(__FILE__) . '/local-config.php';

define('DB_NAME', (empty(DB_PREFIX) ? '' : DB_PREFIX . '_') . DB_SHORTNAME);

//NOTE: PHP_VERSION_ID and the *_VERSION constants were introduced in 5.2.7
if ( !defined('PHP_VERSION_ID') || (PHP_MAJOR_VERSION == 5 && PHP_MINOR_VERSION < 3)) {
    exit("PHP version 5.3.7 or greater is required for this site to run.");
} else if (PHP_MAJOR_VERSION == 5 && PHP_MINOR_VERSION < 5) {
    //TODO this block needs to be tested
    if ( !file_exists(dirname(__FILE__) . '/../lib/password.php'))
        exit("The password_compat library is required for this version of PHP but it cannot be found in the lib/ directory.");

    require_once '../lib/password.php';
}

function autoloadClass($class) {
    include dirname(__FILE__) . '/../models/' . $class . '.class.php';
}

function isID($id)
{
    return is_numeric($id) && is_int($id + 0) && $id > 0;
}

function parseModelArgs()
{
    // NOTE: This adds things to the $GLOBALS array, which is bad because that means
    //       my namespace is leaking.

    foreach ($_GET as $key => $val) {
        switch (strtolower($key)) {
            case 'id':
                if (isID($val)) {
                    $GLOBALS['id'] = $val;
                }
                break;
            case 'teamid':
                if (isID($val)) {
                    $GLOBALS['teamID'] = $val;
                }
                break;
            case 'leagueid':
                if (isID($val)) {
                    $GLOBALS['leagueID'] = $val;
                }
                break;
            case 'gameid':
                if (isID($val)) {
                    $GLOBALS['gameID'] = $val;
                }
                break;
        }
    }
}

spl_autoload_register('autoloadClass');

