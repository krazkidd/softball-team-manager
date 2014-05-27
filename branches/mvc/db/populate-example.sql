INSERT INTO Season VALUES
    ('Fall 2013', '2013-09-03', '2013-10-25')
/*  ('Spring 2013', '2013-??-??', '2013-??-??')*/
    ;


INSERT INTO Player VALUES
    ('1', 'Jim', 'Bean', NULL, 'jb@email', '5553434', 'M'),
    ('2', 'Marla', 'Pearl', NULL, 'mp@email', '5554534', 'F'),
    ('3', 'Janice', 'Trill', 'Jan', 'jt@email', '5554522', 'F'),
    ('4', 'Mike', 'Woo', NULL, NULL, '5556969', 'M'),
    ('5', 'Terry', 'Terrison', NULL, NULL, NULL, 'M'),
    ('6', 'Simón', 'Juarez', NULL, 'sj@email', '5559901', 'M'),
    ('7', 'Tera', 'O\'Dally', NULL, 'to@email', '5551212', 'F'),
    ('8', 'Parker', 'Pug', NULL, 'pp@email', '5555867', 'F'),
    ('9', 'Summer', 'Summerson', NULL, 'ss@email', '5559382', 'F'),
    ('10', 'Tyra', 'Blanks', NULL, 'tb@email', '5558888', 'M'),
    ('11', 'Scott', 'Diamante', NULL, 'sd@email', '5558483', 'M'),
    ('12', 'Chet', 'Debon', 'Cherry Chet', 'cd@email', '5558181', 'M'),
    ('13', 'Harry', 'Topper', 'Hip Harry', 'ht@email', '5553333', 'M'),
    ('14', 'Gretta', 'Niehls', NULL, 'gn@email', '5553933', 'F'),
    ('15', 'Maybe', 'Bluth', NULL, NULL, NULL, 'F')
    ;

INSERT INTO User VALUES
    /* the hashed pass is from get-pass-hash.php */
    ('jimbean', '$2y$10$fiUObUgbHUtwN7CCx3ri0emrCtAgmunBXu/68P7Z8kt3iv0eAh90a', 1)
    ;

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

INSERT INTO League VALUES
    ('Generic City Park', 2, 'M', 'Coed E', 'Fall 2013')
    ;

INSERT INTO Team VALUES
    ('The One Team', '990099', 'eeeeee', 'Motto here', 'Mission here', 'Cool peeps.', '1'),
    ('Conspirators', NULL, NULL, NULL, NULL, NULL, NULL),
    ('Dirty Players', NULL, NULL, NULL, NULL, NULL, NULL),
    ('Triple A\'s', NULL, NULL, NULL, NULL, NULL, NULL),
    ('Faaabulous', NULL, NULL, NULL, NULL, NULL, NULL),
    ('10 Splitters', NULL, NULL, NULL, NULL, NULL, NULL)
    ;

INSERT INTO ParticipatesIn VALUES
    ('The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    ('Conspirators', 'Generic City Park', 2, 'M', 'Fall 2013'),
    ('Dirty Players', 'Generic City Park', 2, 'M', 'Fall 2013'),
    ('Triple A\'s', 'Generic City Park', 2, 'M', 'Fall 2013'),
    ('Faaabulous', 'Generic City Park', 2, 'M', 'Fall 2013'),
    ('10 Splitters', 'Generic City Park', 2, 'M', 'Fall 2013')
    ; 

INSERT INTO Roster VALUES
    (23, NULL, 0, '1', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    (34, NULL, 0, '10', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    (13, NULL, 0, '11', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    (43, NULL, 0, '12', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    (42, NULL, 0, '13', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    (NULL, 'Injured', 0, '6', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    (16, 'Someone\'s friend', 0, '5', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    (NULL, NULL, 0, '4', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    (66, NULL, 0, '2', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    (5, NULL, 0, '3', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    (27, NULL, 0, '7', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    (33, NULL, 0, '8', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    (1, NULL, 0, '9', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    (74, NULL, 0, '14', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    (NULL, NULL, 0, '15', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013')
    ;

INSERT INTO Game VALUES
    ('2013-09-09 18:30:00', 'Regular', 11, 0, 10, 0, 'The One Team', '10 Splitters', 'Generic City Park', 2, 'M', 'Fall 2013'),
    ('2013-09-16 20:40:00', 'Regular', 6, 0, 16, 0, 'Dirty Players', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    ('2013-09-23 18:30:00', 'Regular', 12, 0, 15, 0, 'Triple A\'s', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    ('2013-09-30 18:30:00', 'Regular', 3, 0, 16, 0, 'The One Team', 'Faaabulous', 'Generic City Park', 2, 'M', 'Fall 2013'),
    ('2013-10-07 20:40:00', 'Regular', 2, 0, 24, 0, 'The One Team', 'Conspirators', 'Generic City Park', 2, 'M', 'Fall 2013'),
    ('2013-10-14 20:40:00', 'Regular', 4, 0, 18, 0, '10 Splitters', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    ('2013-10-21 18:30:00', 'Regular', 7, 0, 23, 0, 'The One Team', 'Triple A\'s', 'Generic City Park', 2, 'M', 'Fall 2013'),
    ('2013-10-28 19:35:00', 'Regular', 17, 0, 14, 0, 'The One Team', 'Dirty Players', 'Generic City Park', 2, 'M', 'Fall 2013'),
    ('2013-11-04 19:35:00', 'Regular', 17, 0, 19, 0, 'Conspirators', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    ('2013-11-18 20:40:00', 'Regular', 12, 0, 15, 0, 'Faaabulous', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013'),
    ('2013-12-02 18:30:00', 'Tourney', 12, 0, 5, 0, 'Faaabulous', 'The One Team', 'Generic City Park', 2, 'M', 'Fall 2013')
    ;

