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

class Lineup extends BaseModel
{
    private $mFieldArr = null;
    private $mBatArr = null;
    private $mEpArr = null;

    public function __construct($gameid = 0, $teamid = 0, $leagueid = 0)
    {
        parent::__construct(array('gameid' => $gameid, 'teamid' => $teamid, 'leagueid' => $leagueid));
    }

    protected function loadFromDB()
    {
        if (is_array($this->mID)) {
            $qResult = self::runQuery("SELECT * FROM Lineup AS L WHERE L.GameID = {$this->mID['gameid']} AND L.GameID = {$this->mID['teamid']} AND L.LeagueID = {$this->mID['leagueid']}");

            if ($qResult) {
                $result = $qResult->fetch_array(MYSQLI_ASSOC);

                $this->mFieldArr = array(1 => $result['FieldPos1PID'], $result['FieldPos2PID'],
                    $result['FieldPos3PID'], $result['FieldPos4PID'],
                    $result['FieldPos5PID'], $result['FieldPos6PID'],
                    $result['FieldPos7PID'], $result['FieldPos8PID'],
                    $result['FieldPos9PID'], $result['FieldPos10PID']);
                $this->mBatArr = array(1 => $result['BatPos1PID'], $result['BatPos2PID'],
                    $result['BatPos3PID'], $result['BatPos4PID'],
                    $result['BatPos5PID'], $result['BatPos6PID'],
                    $result['BatPos7PID'], $result['BatPos8PID'],
                    $result['BatPos9PID'], $result['BatPos10PID'],
                    $result['BatPos11PID'], $result['BatPos12PID']);
                $this->mEpArr = array(1 => $result['ExtraPlayer1PID'], $result['ExtraPlayer2PID'],
                    $result['ExtraPlayer3PID']);
            }
        }
    }

    public function saveToDB()
    {
        if (is_array($this->mID)) {
            self::runQuery("INSERT INTO Lineup VALUES ({$this->id['gameid']}, {$this->id['teamid']}, {$this->id['leagueid']}, "
                "{$self->mFieldArr[1]}, {$self->mFieldArr[2]}, "
                "{$self->mFieldArr[3]}, {$self->mFieldArr[4]}, "
                "{$self->mFieldArr[5]}, {$self->mFieldArr[6]}, "
                "{$self->mFieldArr[7]}, {$self->mFieldArr[8]}, "
                "{$self->mFieldArr[9]}, {$self->mFieldArr[10]}, "
                "{$self->mBatArr[1]}, {$self->mFieldArr[2]}, "
                "{$self->mBatArr[3]}, {$self->mFieldArr[4]}, "
                "{$self->mBatArr[5]}, {$self->mFieldArr[6]}, "
                "{$self->mBatArr[7]}, {$self->mFieldArr[8]}, "
                "{$self->mBatArr[9]}, {$self->mFieldArr[10]}, "
                "{$self->mBatArr[11]}, {$self->mFieldArr[12]}, "
                "$self->ExtraPlayer1PID, $self->ExtraPlayer2PID, "
                "$self->ExtraPlayer3PID)";
        } else {
            self::runQuery("UPDATE Lineup SET "
                "`FieldPos1PID` = {$self->mFieldArr[1]}, `FieldPos2PID` = {$self->mFieldArr[2]}, "
                "`FieldPos3PID` = {$self->mFieldArr[3]}, `FieldPos4PID` = {$self->mFieldArr[4]}, "
                "`FieldPos5PID` = {$self->mFieldArr[5]}, `FieldPos6PID` = {$self->mFieldArr[6]}, "
                "`FieldPos7PID` = {$self->mFieldArr[7]}, `FieldPos8PID` = {$self->mFieldArr[8]}, "
                "`FieldPos9PID` = {$self->mFieldArr[9]}, `FieldPos10PID` = {$self->mFieldArr[10]}, "
                "`BatPos1PID` = {$self->mBatArr[1]}, `BatPos2PID` = {$self->mBatArr[2]}, "
                "`BatPos3PID` = {$self->mBatArr[3]}, `BatPos4PID` = {$self->mBatArr[4]}, "
                "`BatPos5PID` = {$self->mBatArr[5]}, `BatPos6PID` = {$self->mBatArr[6]}, "
                "`BatPos7PID` = {$self->mBatArr[7]}, `BatPos8PID` = {$self->mBatArr[8]}, "
                "`BatPos9PID` = {$self->mBatArr[9]}, `BatPos10PID` = {$self->mBatArr[10]}, "
                "`BatPos11PID` = {$self->mBatArr[11]}, `BatPos12PID` = {$self->mBatArr[12]}, "
                "`ExtraPlayer1PID` = $self->ExtraPlayer1PID, `ExtraPlayer2PID` = $self->ExtraPlayer2PID, "
                "`ExtraPlayer3PID` = $self->ExtraPlayer3PID "
                "WHERE `GameID` = {$this->id['gameid']} AND `TeamID` = {$this->id['teamid']} AND `LeagueID` = {$this->id['leagueid']}";
        }
    }

    public function getURI()
    {
        if (is_array($this->mID)) {
            return "/lineup?gameid={$this->mID['gameid']}&teamid={$this->mID['teamid']}&leagueid={$this->mID['leagueid']}";
        }

        //TODO we need a better way to show this id doesn't exist (either send them to ID 0 or use jquery to show message...)
        return '#';
    }

    public function getJSON()
    {
        if (is_array($this->mID)) {
            $arr = array();
            $arr['positions'] = $this->mFieldArr;
            $arr['battingOrder'] = $this->mBatArr;
            $arr['extraPlayers'] = $this->mEpArr;

            //TODO can return just json_encode($this) if we change properties to public
            return json_encode($arr);
        }
    }
}

