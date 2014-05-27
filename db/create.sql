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

/* season entity */
CREATE TABLE Season (
    Description       VARCHAR(32),
    StartDate         DATE,
    RosterFreezeDate  DATE,

    PRIMARY KEY (Description)
    )
    CHARACTER SET utf8 COLLATE utf8_general_ci;

/* player entity */
CREATE TABLE Player (
    ID          VARCHAR(16),
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
CREATE TABLE User (
    Login        VARCHAR(16),
    PasswordHash VARCHAR(255),

    PlayerID     VARCHAR(16) NULL,

    FOREIGN KEY (PlayerID) REFERENCES Player(ID),
    PRIMARY KEY (Login)
    );

/* a "dictionary" of field positions */
CREATE TABLE FieldPosition (
    PosNum       SMALLINT UNSIGNED,
    PosName      CHAR(16) UNIQUE NOT NULL,
    ShortPosName CHAR(2) UNIQUE NOT NULL,

    PRIMARY KEY (PosNum)
    );

/* league entity */
CREATE TABLE League (
    ParkName          VARCHAR(128),
    FieldNum          SMALLINT UNSIGNED,
    DayOfWeek         CHAR(1), /* M, T, W, R, F, S, U */
    Class             VARCHAR(32),

    SeasonDescription VARCHAR(32),

    FOREIGN KEY (SeasonDescription) REFERENCES Season(Description),
    PRIMARY KEY (ParkName, FieldNum, DayOfWeek, SeasonDescription)
    )
    CHARACTER SET utf8 COLLATE utf8_general_ci;

/* team entity */
CREATE TABLE Team (
    TeamName         VARCHAR(64),
    PriColor         CHAR(6), /* to hold 6 char html color hex string */
    SecColor         CHAR(6),
    Motto            VARCHAR(512),
    MissionStatement VARCHAR(1024),
    Notes            VARCHAR(4096),

    ManagerID        VARCHAR(16) NULL,

    FOREIGN KEY (ManagerID) REFERENCES Player(ID),
    PRIMARY KEY (TeamName)
    )
    CHARACTER SET utf8 COLLATE utf8_general_ci;

/* relationship type describing teams participating in leagues */
CREATE TABLE ParticipatesIn (
    TeamName          VARCHAR(64),

    ParkName          VARCHAR(128),
    FieldNum          SMALLINT UNSIGNED,
    DayOfWeek         CHAR(1), /* M, T, W, R, F, S, U */
    SeasonDescription VARCHAR(32),

    FOREIGN KEY (TeamName) REFERENCES Team(TeamName),
    FOREIGN KEY (ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES League(ParkName, FieldNum, DayOfWeek, SeasonDescription),
    PRIMARY KEY (TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription)
    )
    CHARACTER SET utf8 COLLATE utf8_general_ci;

/* roster relationship between players and teams */
CREATE TABLE Roster (
    ShirtNum          INT UNSIGNED,
    Notes             VARCHAR(4096),
    Disabled          BOOLEAN,

    PlayerID          VARCHAR(16),

    TeamName          VARCHAR(64),
    ParkName          VARCHAR(128),
    FieldNum          SMALLINT UNSIGNED,
    DayOfWeek         CHAR(1), /* M, T, W, R, F, S, U */
    SeasonDescription VARCHAR(32),

    FOREIGN KEY (PlayerID) REFERENCES Player(ID),
    FOREIGN KEY (TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES ParticipatesIn(TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    PRIMARY KEY (PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription)
   )
   CHARACTER SET utf8 COLLATE utf8_general_ci;

/* game entity */
CREATE TABLE Game (
    DateTime          DATETIME,
    Type              CHAR(16),
    HomeTeamScore     SMALLINT UNSIGNED,
    HomeTeamForfeit   BOOLEAN,
    AwayTeamScore     SMALLINT UNSIGNED,
    AwayTeamForfeit   BOOLEAN,

    HomeTeamName      VARCHAR(64),
    AwayTeamName      VARCHAR(64),
    ParkName          VARCHAR(128),
    FieldNum          SMALLINT UNSIGNED,
    DayOfWeek         CHAR(1), /* M, T, W, R, F, S, U */
    SeasonDescription VARCHAR(32),

    FOREIGN KEY (HomeTeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES ParticipatesIn(TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (AwayTeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES ParticipatesIn(TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    PRIMARY KEY (DateTime, ParkName, FieldNum, DayOfWeek, SeasonDescription)
    )
    CHARACTER SET utf8 COLLATE utf8_general_ci;

/* lineup entity */
CREATE TABLE Lineup (
    TeamName          VARCHAR(64),

    DateTime          DATETIME,
    ParkName          VARCHAR(128),
    FieldNum          SMALLINT UNSIGNED,
    DayOfWeek         CHAR(1),
    SeasonDescription VARCHAR(32),

    FieldPos1PID      VARCHAR(16) NULL,
    FieldPos2PID      VARCHAR(16) NULL,
    FieldPos3PID      VARCHAR(16) NULL,
    FieldPos4PID      VARCHAR(16) NULL,
    FieldPos5PID      VARCHAR(16) NULL,
    FieldPos6PID      VARCHAR(16) NULL,
    FieldPos7PID      VARCHAR(16) NULL,
    FieldPos8PID      VARCHAR(16) NULL,
    FieldPos9PID      VARCHAR(16) NULL,
    FieldPos10PID     VARCHAR(16) NULL,
    BatPos1PID        VARCHAR(16) NULL,
    BatPos2PID        VARCHAR(16) NULL,
    BatPos3PID        VARCHAR(16) NULL,
    BatPos4PID        VARCHAR(16) NULL,
    BatPos5PID        VARCHAR(16) NULL,
    BatPos6PID        VARCHAR(16) NULL,
    BatPos7PID        VARCHAR(16) NULL,
    BatPos8PID        VARCHAR(16) NULL,
    BatPos9PID        VARCHAR(16) NULL,
    BatPos10PID       VARCHAR(16) NULL,
    BatPos11PID       VARCHAR(16) NULL,
    BatPos12PID       VARCHAR(16) NULL,
    ExtraPlayer1PID   VARCHAR(16) NULL,
    ExtraPlayer2PID   VARCHAR(16) NULL,
    ExtraPlayer3PID   VARCHAR(16) NULL,

    FOREIGN KEY (TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES ParticipatesIn(TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (DateTime, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Game(DateTime, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (FieldPos1PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (FieldPos2PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (FieldPos3PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (FieldPos4PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (FieldPos5PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (FieldPos6PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (FieldPos7PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (FieldPos8PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (FieldPos9PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (FieldPos10PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (BatPos1PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (BatPos2PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (BatPos3PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (BatPos4PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (BatPos5PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (BatPos6PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (BatPos7PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (BatPos8PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (BatPos9PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (BatPos10PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (BatPos11PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (BatPos12PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (ExtraPlayer1PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (ExtraPlayer2PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    FOREIGN KEY (ExtraPlayer3PID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription) REFERENCES Roster(PlayerID, TeamName, ParkName, FieldNum, DayOfWeek, SeasonDescription),
    PRIMARY KEY (TeamName, DateTime, ParkName, FieldNum, DayOfWeek, SeasonDescription)
    )
    CHARACTER SET utf8 COLLATE utf8_general_ci;
