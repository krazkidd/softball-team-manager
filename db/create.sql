/* *************************************************************************

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
  
************************************************************************* */

/*TODO create/destroy the whole database using config settings (write a bash script to handle all that */

/* season entity */
CREATE TABLE Season (
    ID                INTEGER NOT NULL AUTO_INCREMENT,
    Description       VARCHAR(32),
    StartDate         DATE,
    RosterFreezeDate  DATE,

    PRIMARY KEY (ID)
    )
    CHARACTER SET utf8 COLLATE utf8_general_ci;

/* player entity */
CREATE TABLE Player (
    ID          INTEGER NOT NULL AUTO_INCREMENT,
    DisplayID     VARCHAR(16),
    FirstName   VARCHAR(64),
    LastName    VARCHAR(128),
    NickName    VARCHAR(64),
    Email       VARCHAR(128) UNIQUE, /* UNIQUE constraint does not apply to NULL values */
    PhoneNumber CHAR(10),
    Gender      CHAR(1),

    PRIMARY KEY (ID)
    )
    CHARACTER SET utf8 COLLATE utf8_general_ci;

/* website user logins/passwords and links to player IDs */
CREATE TABLE `User` (
    ID           INTEGER NOT NULL AUTO_INCREMENT,
    Login        VARCHAR(32),
    PasswordHash VARCHAR(255),

    PlayerID     INTEGER,

    FOREIGN KEY (PlayerID) REFERENCES Player(ID),
    PRIMARY KEY (ID)
    );

/* a "dictionary" of field positions */
CREATE TABLE FieldPosition (
    PosNum       SMALLINT UNSIGNED NOT NULL,
    PosName      CHAR(16) UNIQUE NOT NULL,
    ShortPosName CHAR(2) UNIQUE NOT NULL,

    PRIMARY KEY (PosNum)
    );

INSERT INTO FieldPosition VALUES
    (1, 'Pitcher', 'P'),
    (2, 'Catcher', 'C'),
    (3, 'First Base', '1B'),
    (4, 'Second Base', '2B'),
    (5, 'Third Base', '3B'),
    (6, 'Short Stop', 'SS'),
    (7, 'Left Field', 'LF'),
    (8, 'Center Field', 'CF'),
    (9, 'Right Field', 'RF'),
    (10, 'Rover', 'RO')
    ;

/* league entity */
CREATE TABLE League (
    ID                INTEGER NOT NULL AUTO_INCREMENT,
    ParkName          VARCHAR(128),
    FieldNum          SMALLINT UNSIGNED,
    Class             VARCHAR(32),

    SeasonID          INTEGER,

    FOREIGN KEY (SeasonID) REFERENCES Season(ID),
    /*PRIMARY KEY (ParkName, FieldNum, DayOfWeek, SeasonDescription)*/
    PRIMARY KEY (ID)
    )
    CHARACTER SET utf8 COLLATE utf8_general_ci;

/* team entity */
CREATE TABLE Team (
    ID               INTEGER NOT NULL AUTO_INCREMENT,  
    TeamName         VARCHAR(64),
    PriColor         CHAR(6), /* to hold 6 char html color hex string */
    SecColor         CHAR(6),
    Motto            VARCHAR(512),
    MissionStatement VARCHAR(1024),
    Notes            VARCHAR(4096),

    ManagerID        INTEGER NULL,

    FOREIGN KEY (ManagerID) REFERENCES Player(ID),
    PRIMARY KEY (ID)
    )
    CHARACTER SET utf8 COLLATE utf8_general_ci;

/* relationship type describing teams participating in leagues */
CREATE TABLE ParticipatesIn (
    TeamID   INTEGER,
    LeagueID INTEGER,

    FOREIGN KEY (TeamID) REFERENCES Team(ID),
    FOREIGN KEY (LeagueID) REFERENCES League(ID),
    PRIMARY KEY (TeamID, LeagueID)
    );

/* roster relationship between players and teams */
CREATE TABLE Roster (
    ShirtNum VARCHAR(6),
    Notes    VARCHAR(4096),
    Disabled BOOLEAN,

    PlayerID INTEGER,

    TeamID   INTEGER,
    LeagueID INTEGER,

    FOREIGN KEY (PlayerID) REFERENCES Player(ID),
    FOREIGN KEY (TeamID, LeagueID) REFERENCES ParticipatesIn(TeamID, LeagueID),
    PRIMARY KEY (PlayerID, TeamID, LeagueID)
   )
   CHARACTER SET utf8 COLLATE utf8_general_ci;

/* game entity */
CREATE TABLE Game (
    ID            INTEGER NOT NULL AUTO_INCREMENT,
    DateTime      DATETIME,
    Type          CHAR(16),
    HomeTeamScore SMALLINT UNSIGNED,
    AwayTeamScore SMALLINT UNSIGNED,
    ForfeitID     INTEGER NULL,

    HomeID        INTEGER NULL,
    AwayID        INTEGER NULL,
    LeagueID      INTEGER,

    FOREIGN KEY (ForfeitID) REFERENCES Team(ID),
    FOREIGN KEY (HomeID) REFERENCES Team(ID),
    FOREIGN KEY (AwayID) REFERENCES Team(ID),
    FOREIGN KEY (HomeID, LeagueID) REFERENCES ParticipatesIn(TeamID, LeagueID),
    FOREIGN KEY (AwayID, LeagueID) REFERENCES ParticipatesIn(TeamID, LeagueID),
    PRIMARY KEY (ID)
    )
    CHARACTER SET utf8 COLLATE utf8_general_ci;

/* lineup entity */
CREATE TABLE Lineup (
    GameID            INTEGER,
    TeamID            INTEGER,
    LeagueID          INTEGER, /*TODO allow null for non-league games? (or make a "Non-League", i.e. LeagueID = 0) */

    FieldPos1PID      INTEGER NULL,
    FieldPos2PID      INTEGER NULL,
    FieldPos3PID      INTEGER NULL,
    FieldPos4PID      INTEGER NULL,
    FieldPos5PID      INTEGER NULL,
    FieldPos6PID      INTEGER NULL,
    FieldPos7PID      INTEGER NULL,
    FieldPos8PID      INTEGER NULL,
    FieldPos9PID      INTEGER NULL,
    FieldPos10PID     INTEGER NULL,
    BatPos1PID        INTEGER NULL,
    BatPos2PID        INTEGER NULL,
    BatPos3PID        INTEGER NULL,
    BatPos4PID        INTEGER NULL,
    BatPos5PID        INTEGER NULL,
    BatPos6PID        INTEGER NULL,
    BatPos7PID        INTEGER NULL,
    BatPos8PID        INTEGER NULL,
    BatPos9PID        INTEGER NULL,
    BatPos10PID       INTEGER NULL,
    BatPos11PID       INTEGER NULL,
    BatPos12PID       INTEGER NULL,
    ExtraPlayer1PID   INTEGER NULL,
    ExtraPlayer2PID   INTEGER NULL,
    ExtraPlayer3PID   INTEGER NULL,

    FOREIGN KEY (GameID) REFERENCES Game(ID),
    FOREIGN KEY (TeamID) REFERENCES Team(ID),
    FOREIGN KEY (LeagueID) REFERENCES League(ID),
    FOREIGN KEY (TeamID, LeagueID) REFERENCES ParticipatesIn(TeamID, LeagueID), /*TODO is this necessary? the Roster references might do the same */
    FOREIGN KEY (FieldPos1PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (FieldPos2PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (FieldPos3PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (FieldPos4PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (FieldPos5PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (FieldPos6PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (FieldPos7PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (FieldPos8PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (FieldPos9PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (FieldPos10PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (BatPos1PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (BatPos2PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (BatPos3PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (BatPos4PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (BatPos5PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (BatPos6PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (BatPos7PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (BatPos8PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (BatPos9PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (BatPos10PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (BatPos11PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (BatPos12PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (ExtraPlayer1PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (ExtraPlayer2PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    FOREIGN KEY (ExtraPlayer3PID, TeamID, LeagueID) REFERENCES Roster(PlayerID, TeamID, LeagueID),
    PRIMARY KEY (GameID, TeamID, LeagueID)
    );
