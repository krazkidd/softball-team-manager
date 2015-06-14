INSERT INTO Season VALUES
    (NULL, 'Fall 2013', '2013-09-03', '2013-10-25')
/*  ('Spring 2013', '2013-??-??', '2013-??-??')*/
    ;


INSERT INTO Player VALUES
    (NULL, NULL, 'Mark', 'Ross', NULL, 'mr@email', '5553434', 'M'),
    (NULL, NULL, 'Marla', 'Pearl', NULL, 'mp@email', '5554534', 'F'),
    (NULL, NULL, 'Janice', 'Trill', 'Jan', 'jt@email', '5554522', 'F'),
    (NULL, NULL, 'Mike', 'Woo', NULL, NULL, '5556969', 'M'),
    (NULL, NULL, 'Terry', 'Terrison', NULL, NULL, NULL, 'M'),
    (NULL, NULL, 'Simón', 'Juarez', NULL, 'sj@email', '5559901', 'M'),
    (NULL, NULL, 'Tera', 'O\'Dally', NULL, 'to@email', '5551212', 'F'),
    (NULL, NULL, 'Parker', 'Pug', NULL, 'pp@email', '5555867', 'F'),
    (NULL, NULL, 'Summer', 'Summerson', NULL, 'ss@email', '5559382', 'F'),
    (NULL, NULL, 'Tyra', 'Blanks', NULL, 'tb@email', '5558888', 'M'),
    (NULL, NULL, 'Scott', 'Diamante', NULL, 'sd@email', '5558483', 'M'),
    (NULL, NULL, 'Chet', 'Debon', 'Cherry Chet', 'cd@email', '5558181', 'M'),
    (NULL, NULL, 'Harry', 'Topper', 'Hip Harry', 'ht@email', '5553333', 'M'),
    (NULL, NULL, 'Gretta', 'Niehls', NULL, 'gn@email', '5553933', 'F'),
    (NULL, NULL, 'Maybe', 'Bluth', NULL, NULL, NULL, 'F')
    ;

INSERT INTO `User` VALUES
    /* hashed passwords are from get-pass-hash.php */
    (NULL, 'jimbean', '$2y$10$fiUObUgbHUtwN7CCx3ri0emrCtAgmunBXu/68P7Z8kt3iv0eAh90a', 1) /* pass: password */
    ;

INSERT INTO League VALUES
    (NULL, 'Generic City Park', 2, 'Coed E', 1)
    ;

INSERT INTO Team VALUES
    (NULL, 'The One Team', '990099', 'eeeeee', 'Motto here', 'Mission here', 'Cool peeps.', 1),
    (NULL, 'Conspirators', NULL, NULL, NULL, NULL, NULL, NULL),
    (NULL, 'Dirty Players', NULL, NULL, NULL, NULL, NULL, NULL),
    (NULL, 'Triple A\'s', NULL, NULL, NULL, NULL, NULL, NULL),
    (NULL, 'Faaabulous', NULL, NULL, NULL, NULL, NULL, NULL),
    (NULL, '10 Splitters', NULL, NULL, NULL, NULL, NULL, NULL)
    ;

INSERT INTO ParticipatesIn VALUES
    (1, 1),
    (2, 1),
    (3, 1),
    (4, 1),
    (5, 1),
    (6, 1)
    ; 

INSERT INTO Roster VALUES
    (23, NULL, FALSE, 1, 1, 1),
    (34, NULL, FALSE, 2, 1, 1),
    (13, NULL, FALSE, 3, 1, 1),
    (43, NULL, FALSE, 4, 1, 1),
    (42, NULL, FALSE, 5, 1, 1),
    (NULL, 'Injured', TRUE, 6, 1, 1),
    (16, 'Someone\'s friend', TRUE, 7, 1, 1),
    (NULL, NULL, FALSE, 8, 1, 1),
    (66, NULL, FALSE, 9, 1, 1),
    (5, NULL, FALSE, 10, 1, 1),
    (27, NULL, FALSE, 11, 1, 1),
    (33, NULL, FALSE, 12, 1, 1),
    (1, NULL, FALSE, 13, 1, 1),
    (74, NULL, FALSE, 14, 1, 1),
    (NULL, NULL, FALSE, 15, 1, 1)
    ;

INSERT INTO Game VALUES
    (NULL, '2013-09-09 18:30:00', 'Regular', 11, 0, NULL, 1, 6, 1),
    (NULL, '2013-09-16 20:40:00', 'Regular', 6, 0, NULL, 6, 1, 1),
    (NULL, '2013-09-23 18:30:00', 'Regular', 12, 0, NULL, 5, 1, 1),
    (NULL, '2013-09-30 18:30:00', 'Regular', 3, 0, NULL, 4, 1, 1),
    (NULL, '2013-10-07 20:40:00', 'Regular', 2, 0, NULL, 3, 1, 1),
    (NULL, '2013-10-14 20:40:00', 'Regular', 4, 0, NULL, 1, 2, 1),
    (NULL, '2013-10-21 18:30:00', 'Regular', 7, 0, 2, 2, 1, 1),
    (NULL, '2013-10-28 19:35:00', 'Regular', 17, 0, NULL, 1, 4, 1),
    (NULL, '2013-11-04 19:35:00', 'Regular', 17, 0, NULL, 3, 1, 1),
    (NULL, '2013-11-18 20:40:00', 'Regular', 12, 0, NULL, 4, 1, 1),
    (NULL, '2013-12-02 18:30:00', 'Tourney', 12, 0, NULL, 5, 1, 1)
    ;
