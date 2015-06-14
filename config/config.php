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

//NOTE: PHP_VERSION_ID and the *_VERSION constants were introduced in 5.2.7
if ( !defined('PHP_VERSION_ID') || (PHP_MAJOR_VERSION == 5 && PHP_MINOR_VERSION < 3))
{
    exit("PHP version 5.3.7 or greater is required for this site to run.");
}
else if (PHP_MAJOR_VERSION == 5 && PHP_MINOR_VERSION < 5)
{
    //TODO this block needs to be tested
    if ( !file_exists('../lib/password.php'))
        exit("The password_compat library is required for this version of PHP but it cannot be found in the models/ directory.");

    require_once '../lib/password.php';
}

require_once '../config/local-config.php';

define('DB_NAME', (empty(DB_PREFIX) ? '' : DB_PREFIX . '_') . DB_SHORTNAME); 
