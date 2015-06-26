<?php

  /**************************************************************************

  This file is part of Team Manager.

  Copyright © 2015 Mark Ross <krazkidd@gmail.com>

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

require_once dirname(__FILE__) . '/../config/config.php';

abstract class BaseModel
{
    /*
     * How man objects of this type have been instantiated. The count
     * is incremented in self's constructor and decremented in self's
     * destructor. When falling to a value of 0, the DB connection
     * should be closed.
     */
    private static $mInstanceCount = 0;
    private static $mDBCon = null;

    protected $mID = 0;

    protected function __construct($id)
    {
        if (is_int($id + 0) && $id > 0) {
            $this->mID = $id;

            $this->loadFromDB();
        }

        self::$mInstanceCount++;
    }

    final public function __destruct()
    {
        self::$mInstanceCount--;

        if (0 == self::$mInstanceCount) {
            self::closeDB();
        }
    }

    //TODO what was i gonna put here?
    //final protected function

    final private static function openDB()
    {
        self::$mDBCon = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        self::$mDBCon->set_charset('utf8');
    }

    final private static function closeDB()
    {
        if (!self::$mDBCon)
            return false;

        self::$mDBCon->kill(self::$mDBCon->thread_id); // kill connection
        return self::$mDBCon->close();
    }

    abstract protected function loadFromDB();
    abstract public function saveToDB();

    final protected static function runQuery($queryStr)
    {
        //TODO this still works with Auth being abstract class; that is, the Auth class has no instances
        //     and so doesn't increase the instance count and so the destructor won't close the DB
        //     connection when we want/expect it to, but it still works because it forces open a connection.
        //     It shouldn't do that.
        if (!self::$mDBCon) {
            self::openDB();
        }

        if (self::$mDBCon) {
            //TODO can I/should I escape all query strings here and not worry about it elsewhere? (yes)
            return self::$mDBCon->query($queryStr);
        }

        return null;
    }

    /*
     * Gets the ID of the object.
     */
    final public function getID()
    {
        return $this->mID;
    }

    abstract public function getURI();
}

