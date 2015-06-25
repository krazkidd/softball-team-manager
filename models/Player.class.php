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

class Player extends BaseModel
{
    private $mDisplayID = null;
    private $mFirstName = null;
    private $mLastName = null;
    private $mNickName = null;
    private $mEmail = null;
    private $mPhoneNumber = null;
    private $mGender = null;

    public function __construct($id = 0)
    {
        parent::__construct($id);
    }

    protected function loadFromDB()
    {
        if ($this->mID > 0) {
            $qResult = self::runQuery("SELECT * FROM Player WHERE Player.ID = $this->mID");

            $result = $qResult->fetch_array(MYSQLI_ASSOC);

            if ($qResult) {
                $this->mDisplayID = $result['DisplayID'];
                $this->mFirstName = $result['FirstName'];
                $this->mLastName = $result['LastName'];
                $this->mNickName = $result['NickName'];
                $this->mEmail = $result['Email'];
                $this->mPhoneNumber = $result['PhoneNumber'];
                $this->mGender = $result['Gender'];
            }
        }
    }

    public function saveToDB()
    {
        if (0 == $this->mID) {
            self::runQuery("INSERT INTO Player VALUES (NULL, '$self->mDisplayID', '$self->mFirstName', '$self->mLastName', '$self->mNickName', '$self->mEmail', '$self->mPhoneNumber', '$self->mGender')");

            // save the ID that was created by MySQL
            $this->mID = self::$mDBCon->insert_id;
        } else {
            self::runQuery("UPDATE Player SET `DisplayID` = '$self->mDisplayID', `FirstName` = '$self->mFirstName', `LastName` = '$self->mLastName', `NickName` = '$nickName', `Email` = '$self->mEmail', `PhoneNumber` = '$self->mPhoneNumber', `Gender` = '$self->mGender' WHERE ID = $this->mID");
        }
    }

    public function getFormattedPhoneNumber()
    {
        //TODO review formatting code below
        return $this->mPhoneNumber;

        //$phoneStr = $player['PhoneNumber'];

        //if (!empty($phoneStr)) {
        //    if (strlen($phoneStr) == 10)
        //        return '(' . substr($phoneStr, 0, 3) . ') ' . substr($phoneStr, 3, 3) . '-' . substr($phoneStr, 6, 4);
        //    else if (strlen($phoneStr) == 7)
        //        return substr($phoneStr, 0, 3) . '-' . substr($phoneStr, 3, 4);
        //}

        //return '';
    }

    public function getEmail()
    {
        return $this->mEmail;
    }

    public function getFirstName()
    {
        return $this->mFirstName;
    }

    public function getLastName()
    {
        return $this->mLastName;
    }

    public function getFullName()
    {
        return "$this->mFirstName $this->mLastName";
    }

    public function getShortName()
    {
        if (count($this->mLastName) > 0) {
            $lastInitial = $this->mLastName[0];
        }

        if (isset($lastInitial)) {
            return "$this->mFirstName $lastInitial.";
        }

        return "$this->mFirstName";
    }

    public function getNickName()
    {
        return $this->mNickName;
    }

    public function getGender()
    {
        return $this->mGender;
    }

    public function getRosteredTeamsForPlayer()
    {
        $qResult = self::runQuery("SELECT DISTINCT T.ID, T.TeamName FROM Team AS T JOIN Roster AS R ON T.ID = R.TeamID JOIN ParticipatesIn AS P ON P.TeamID = T.ID JOIN League AS L ON P.LeagueID = L.ID JOIN Class AS C ON L.ClassID = C.ID WHERE R.PlayerID = $this->mID ORDER BY L.StartDate DESC");

        if ($qResult) {
            $result = array();
            while($row = $qResult->fetch_array(MYSQLI_ASSOC)) {
                $result[] = $row;
            }

            return $result;
        }

        return null;
    }

    public function getURI()
    {
        if ($this->mID > 0) {
            return "/player/$this->mID";
        }

        //TODO we need a better way to show this player doesn't exist (either send them to ID 0 or use jquery to show message...)
        return '#';
    }

    public function getManagedTeams()
    {
        //TODO return Team objects (just pull ID's and give to Team constructor)
        //$qResult = self::runQuery("SELECT T.ID, T.TeamName FROM Team AS T WHERE T.ManagerID = $this->mID");
        self::runQuery("SELECT T.ID, T.TeamName FROM Team AS T WHERE T.ManagerID = $this->mID");

        //if ($qResult) {
        $result = array();
        while($row = $qResult->fetch_array(MYSQLI_ASSOC)) {
            $result[] = $row;
        }

        return $result;
        //}

        //return null;
    }
}

