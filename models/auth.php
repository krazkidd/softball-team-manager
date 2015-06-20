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

//TODO does this file not need a session_start() to use $_SESSION['loginname']?
//     begin-controller.php now makes that function call.

require_once dirname(__FILE__) . '/model.php';

function doRequireLogin()
{
    if ( !isLoggedIn()) {
        //TODO add data so after login, user is redirected to requested dest.
        header('Location: /login');
        exit(0);
    }
}

function doRequireNoLogin()
{
    if (isLoggedIn()) {
        header('Location: /');
        exit(0);
    }
}

function isLoggedIn()
{
    return isset($_SESSION['loginname']);
}

function getLoginName()
{
    if (isLoggedIn())
        return $_SESSION['loginname'];
    else
        return '';
}

function getUserName()
{
    return getLoginName();
}

function attemptLogin($username, $password)
{
    //TODO clear previous session here or somewhere?

//TODO sanitize input
    if ($username && !empty($username) && $password && !empty($password))
        $qResult = runQuery('SELECT PasswordHash FROM `User` WHERE Login = \'' . $username . '\'');

    if ($qResult) {
        $result = mysqli_fetch_array($qResult)['PasswordHash'];

        if (password_verify($password, $result)) {
            // save login name to session
            $_SESSION['loginname'] = $username;

            return True;
        }
    }

    return False;
}

function attemptRegistration($loginName, $password)
{
//TODO don't allow blank password. do some basic password enforcement
//TODO sanitize input. also don't allow only differences in case or spacing for login names
    if ($loginName && strlen($loginName) >= 3 && $password && strlen($password) >= 6) {
        $qResult = runQuery('INSERT INTO `User` VALUES (null, \'' . $loginName . '\', \'' . password_hash($password, PASSWORD_DEFAULT) . '\', null)');

        if ($qResult) {
            // save login name to session
            $_SESSION['loginname'] = $loginName;

            return TRUE;
        } else {
            error_log('Could not register user \'' . $loginName . '\'. (Could not INSERT into User table.)');
        }
    }

    return FALSE;
}

