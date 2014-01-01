/* season entity */
CREATE TABLE Season (
    ParentAssociation VARCHAR(128),
    Year              DATE,
    Description       VARCHAR(32),
    City              VARCHAR(64),
    State             VARCHAR(64),
    StartDate         DATE,
    EndDate           DATE,
    RosterFreezeDate  DATE,
    PRIMARY KEY (ParentAssociation, Year, Description, City, State)
    )
    CHARACTER SET utf8 COLLATE utf8_general_ci;

/* player entity */
CREATE TABLE Player (
    ID          VARCHAR(16) PRIMARY KEY,
    FirstName   VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci,
    LastName    VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci,
    NickName    VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Email       VARCHAR(128) UNIQUE, /* UNIQUE constraint does not apply to NULL values */
    PhoneNumber CHAR(10),
    Gender      CHAR(1),
    Disabled    BOOLEAN
    /* ProfileHash CHAR(64???) */
    );

/* website user logins/passwords and links to player IDs */
CREATE TABLE User (
    Login       VARCHAR(16) PRIMARY KEY,
    FirstName   VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci,
    LastName    VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci,
    NickName    VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Email       VARCHAR(128) UNIQUE, /* UNIQUE constraint does not apply to NULL values */
    PhoneNumber CHAR(10),
    Gender      CHAR(1),
    Disabled    BOOLEAN,
    ProfileHash BINARY(16) /* 32 char hex string that can hold md5 hash */
    );

/* a "dictionary" of field positions */
CREATE TABLE FieldPosition (
    PosNum       SMALLINT UNSIGNED PRIMARY KEY,
    PosName      CHAR(16) UNIQUE NOT NULL,
    ShortPosName CHAR(2) UNIQUE NOT NULL
    );

/* league entity */
CREATE TABLE League (
    ParkName          VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci,
    FieldNum          SMALLINT UNSIGNED,
    DayOfWeek         CHAR(1), /* M, T, W, R, F, S, U */
    Class             VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Gender            CHAR(1),
    ParentAssociation VARCHAR(128),
    Year              DATE,
    Description       VARCHAR(32),
    City              VARCHAR(64),
    State             VARCHAR(64),
    FOREIGN KEY (ParentAssociation, Year, Description, City, State) REFERENCES Season(ParentAssociation, Year, Description, City, State),
    PRIMARY KEY (ParkName, FieldNum, DayOfWeek, ParentAssociation, Year, Description, City, State)
    );

/* team entity */
CREATE TABLE Team (
    TeamName         VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci,
    PriColor         BINARY(3), /* 6 char hex string to hold 6 char html color hex string */
    SecColor         BINARY(3),
    Motto            VARCHAR(512) CHARACTER SET utf8 COLLATE utf8_general_ci,
    MissionStatement VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_general_ci,
    Notes            VARCHAR(4096) CHARACTER SET utf8 COLLATE utf8_general_ci,
    ProfileHash      BINARY(16), /* 32 char hex string that can hold md5 hash */
    ManagerID        VARCHAR(16) NULL,
    FOREIGN KEY (ManagerID) REFERENCES Player(ID),
    PRIMARY KEY (TeamName)
    );

/* game entity */
CREATE TABLE Game (
    DateTime          DATETIME,
    Type              CHAR(16),
    ParkName          VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci,
    FieldNum          SMALLINT UNSIGNED,
    DayOfWeek         CHAR(1), /* M, T, W, R, F, S, U */
    ParentAssociation VARCHAR(128),
    Year              DATE,
    Description       VARCHAR(32),
    City              VARCHAR(64),
    State             VARCHAR(64),
    HomeTeamName      VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci,
    HomeTeamScore     SMALLINT UNSIGNED,
    HomeTeamForfeit   BOOLEAN,
    AwayTeamName      VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci,
    AwayTeamScore     SMALLINT UNSIGNED,
    AwayTeamForfeit   BOOLEAN,
    FOREIGN KEY (ParkName, FieldNum, DayOfWeek, ParentAssociation, Year, Description, City, State) REFERENCES League(ParkName, FieldNum, DayOfWeek, ParentAssociation, Year, Description, City, State),
    FOREIGN KEY (HomeTeamName) REFERENCES Team(TeamName),
    FOREIGN KEY (AwayTeamName) REFERENCES Team(TeamName),
    PRIMARY KEY (DateTime, ParkName, FieldNum, DayOfWeek, ParentAssociation, Year, Description, City, State)
    );

/* lineup entity */
CREATE TABLE Lineup (
    TeamName          VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_general_ci,
    DateTime          DATETIME,
    ParkName          VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci,
    FieldNum          SMALLINT UNSIGNED,
    DayOfWeek         CHAR(1),
    ParentAssociation VARCHAR(128),
    Year              DATE,
    Description       VARCHAR(32),
    City              VARCHAR(64),
    State             VARCHAR(64),
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
    FOREIGN KEY (TeamName) REFERENCES Team(TeamName),
    FOREIGN KEY (DateTime, ParkName, FieldNum, DayOfWeek, ParentAssociation, Year, Description, City, State) REFERENCES Game(DateTime, ParkName, FieldNum, DayOfWeek, ParentAssociation, Year, Description, City, State),
    FOREIGN KEY (FieldPos1PID) REFERENCES Player(ID),
    FOREIGN KEY (FieldPos2PID) REFERENCES Player(ID),
    FOREIGN KEY (FieldPos3PID) REFERENCES Player(ID),
    FOREIGN KEY (FieldPos4PID) REFERENCES Player(ID),
    FOREIGN KEY (FieldPos5PID) REFERENCES Player(ID),
    FOREIGN KEY (FieldPos6PID) REFERENCES Player(ID),
    FOREIGN KEY (FieldPos7PID) REFERENCES Player(ID),
    FOREIGN KEY (FieldPos8PID) REFERENCES Player(ID),
    FOREIGN KEY (FieldPos9PID) REFERENCES Player(ID),
    FOREIGN KEY (FieldPos10PID) REFERENCES Player(ID),
    FOREIGN KEY (BatPos1PID) REFERENCES Player(ID),
    FOREIGN KEY (BatPos2PID) REFERENCES Player(ID),
    FOREIGN KEY (BatPos3PID) REFERENCES Player(ID),
    FOREIGN KEY (BatPos4PID) REFERENCES Player(ID),
    FOREIGN KEY (BatPos5PID) REFERENCES Player(ID),
    FOREIGN KEY (BatPos6PID) REFERENCES Player(ID),
    FOREIGN KEY (BatPos7PID) REFERENCES Player(ID),
    FOREIGN KEY (BatPos8PID) REFERENCES Player(ID),
    FOREIGN KEY (BatPos9PID) REFERENCES Player(ID),
    FOREIGN KEY (BatPos10PID) REFERENCES Player(ID),
    FOREIGN KEY (BatPos11PID) REFERENCES Player(ID),
    FOREIGN KEY (BatPos12PID) REFERENCES Player(ID),
    FOREIGN KEY (ExtraPlayer1PID) REFERENCES Player(ID),
    FOREIGN KEY (ExtraPlayer2PID) REFERENCES Player(ID),
    FOREIGN KEY (ExtraPlayer3PID) REFERENCES Player(ID),
    PRIMARY KEY (TeamName, DateTime, ParkName, FieldNum, DayOfWeek, ParentAssociation, Year, Description, City, State)
    );

/* a player gets one field appearance per position per game */
CREATE TABLE FieldAppearance (
    PosNum        SMALLINT UNSIGNED FOREIGN KEY REFERENCES FieldPosition.PosNum,
    InningsPlayed SMALLINT UNSIGNED,
    PlayerID      VARCHAR(16) FOREIGN KEY REFERENCES Player.ID,
    DateTime      DATETIME,
    ParkName      VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci,
    FieldNum      SMALLINT UNSIGNED,
    DayOfWeek     CHAR(1),
    FOREIGN KEY (DateTime, ParkName, FieldNum, DayOfWeek) REFERENCES Game,
    PRIMARY KEY (PosNum, PlayerID, DateTime, ParkName, FieldNum, DayOfWeek)
    );

/* a "dictionary" of possible statistics */
CREATE TABLE Stats (
    Abbr CHAR(8) PRIMARY KEY,
    Name VARCHAR(64) NOT NULL
    );    

/* a player gets a plate appearance when they strike out or become a runner
   (that is, they must have a "complete" appearance--a third out could be made
   while at the plate, resulting in a non-appearance). An "at bat" is a different
   statistic. */
CREATE TABLE PlateAppearance (
    Result    CHAR(8) FOREIGN KEY REFERENCES Stats,
    Num       SMALLINT UNSIGNED, /* appearance number */
    PID       VARCHAR(16) FOREIGN KEY REFERENCES Player.ID,
    DateTime  DATETIME,
    ParkName  VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci,
    FieldNum  SMALLINT UNSIGNED,
    DayOfWeek CHAR(1),
    FOREIGN KEY (DateTime, ParkName, FieldNum, DayOfWeek) REFERENCES Game,
    PRIMARY KEY (Num, PID, DateTime, ParkName, FieldNum, DayOfWeek)
    );

/* each player has a rating for their preference/ability at a position */
CREATE TABLE PlayerPositionRating (
    Rating SMALLINT UNSIGNED,
    PosNum SMALLINT UNSIGNED FOREIGN KEY REFERENCES FieldPosition.PosNum,
    PID VARCHAR(16) FOREIGN KEY REFERENCES Player.ID,
    PRIMARY KEY (PosNum, PID)
    );
