-- Create New Event
    SET @EventCode = '1kxeqfw3ce';
    SET @UserID = 'e8l6kj91ek';
    SET @InsertedDays = NULL;
    insert into Events(
        EventCode,
        EventTitle,
        Duration,
        Deadline,
        EventPassword
    )
    Values
    (
                            -- $eventCode = base_convert((strval(time()) . sprintf('%05d',rand (0, 99999))), 10, 36);
        @EventCode,		-- event code generated by: systemtime appended by 5 digit random number, then converted into base 36
        'Friends Giving',	-- 55 char character limit
        11, 					-- this event takes 7 segments of time, (11*15)/60 = 2 hr 45 min
        '2020-11-23',		-- YYY-MM-DD
        'MyFakePassword'	-- 16 char character limit
    )
    ;



    insert into Users(
        UserID,				-- $userID = base_convert((strval(intval(time())-159999999) . sprintf('%03d',rand (0, 999)) . sprintf('%03d',rand (0, 999))) , 10, 36);
        UserType,			-- 'E' = Event
        RSVP,				-- True
        Email				-- Organizer's email
    )
    Values
    (
        @UserID,
        'E', 
        True, 
        'organizer@email.me'
    )
    ;

    insert into  Days(
        EventCode,
        UserID,
        EventDate,
        TimeArray
    )
    Values
    (
        @EventCode,
        @UserID, 
        '20201126',
        '000000000000000000000000000000000000000000000000111111111111111111111111111100000000000000000000'
    ),
    (
        @EventCode,
        @UserID, 
        '20201127',
        '000000000000000000000000000000001111111111111111111111111111111111111111111111111111000000000000'
    ),
    (
        @EventCode,
        @UserID, 
        '20201128',
        '000000000000000000000000000000000000111111111111111111111111111111110000000000000000000000000000'
    )
    ;
    Select Group_CONCAT(CONCAT(EventDate,': ',  IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n')
    into @InsertedDays
    From Days
    Cross Join
        Users using(UserID)
    Where 
            EventCode = @EventCode
        AND	UserType = 'E'
    ;

    insert into LOGS(
        AssociatedUserID, 
        DateTime,
        Description
    )
    VALUES
    (
        @UserID, 
        NOW(),
        'USER CREATED'
    ),
    (
        @UserID, 
        NOW(),
        CONCAT('EVENT CREATED: ', @EventCode)
    ),
    (
        @UserID, 
        NOW(),
        CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays)
    );
    SET @EventCode = NULL;
    SET @UserID = NULL;
    SET @InsertedDays = NULL;

    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);


    SET @EventCode = '1kxeqfw3ce';
    SET @UserID = 'e8l6kj91ek';
    Set @UpdatedDay = '20201128';
    Set @UpdatedTimeArray = '000000000011111111000000000000000000000000000111111111111111111111111111111110000000000000000000';
    -- update Event: Change Existing day
    update Days
    Cross Join
        Users using(UserID)
    SET
        TimeArray = @UpdatedTimeArray

    WHERE
            EventCode = @EventCode
        AND	EventDate = @UpdatedDay
        AND	UserType = 'E'
    ;

    insert into LOGS(
        AssociatedUserID, 
        DateTime,
        Description
    )
    VALUES
    (
        @UserID , 
        NOW(),
        CONCAT_WS('\r\n','DAYS UPDATED for EVENT: ',@EventCode, CONCAT(@UpdatedDay,': ', @UpdatedTimeArray))
    );
    SET @EventCode = NULL;
    SET @UserID = NULL;
    Set @UpdatedDay = NULL;
    Set @UpdatedTimeArray = NULL;



    -- Create New Event
    SET @EventCode = '1kz8k3bfa6';
    SET @UserID = 'e92mukjb56';
    SET @InsertedDays = NULL;
    insert into Events(
        EventCode,
        EventTitle,
        Duration,
        Deadline,
        EventPassword
    )
    Values
    (
                            -- $eventCode = base_convert((strval(time()) . sprintf('%05d',rand (0, 99999))), 10, 36);
        @EventCode,		-- event code generated by: systemtime appended by 5 digit random number, then converted into base 36
        'Semester Planning Meeting',	-- 55 char character limit
        3, 					-- this event takes 7 segments of time, (11*15)/60 = 2 hr 45 min
        '2021-01-08',		-- YYY-MM-DD
        '1234'	-- 16 char character limit
    )
    ;



    insert into Users(
        UserID,				-- $userID = base_convert((strval(intval(time())-159999999) . sprintf('%03d',rand (0, 999)) . sprintf('%03d',rand (0, 999))) , 10, 36);
        UserType,			-- 'E' = Event
        RSVP,				-- True
        Email				-- Organizer's email
    )
    Values
    (
        @UserID,
        'E', 
        True, 
        'sirenaamaranth@gmil.com'
    )
    ;

    insert into  Days(
        EventCode,UserID,EventDate,TimeArray)
    Values
    (	@EventCode,@UserID, '20200112','000000000000000000000000000000000000000000000000111111111111111111111100000000000000000000000000'),
    (	@EventCode,@UserID, '20200113','000000000000000000000000000000000000000000000000000000001111111111111110000000000000000000000000'),
    (	@EventCode,@UserID, '20200114','000000000000000000000000000000000000000000000000000000001111111111111110000000000000000000000000'),
    (	@EventCode,@UserID, '20200115','000000000000000000000000000000000000000000000000000000001111111111111110000000000000000000000000'),
    (	@EventCode,@UserID, '20200116','000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20200117','000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20200118','000000000000000000000000000000000000000000000000000000001111111111111110000000000000000000000000'),
    (	@EventCode,@UserID, '20200119','000000000000000000000000000000000000000000000000111111111111111111111100000000000000000000000000'),
    (	@EventCode,@UserID, '20200120','000000000000000000000000000000000000000000000000000000001111111111111110000000000000000000000000'),
    (	@EventCode,@UserID, '20200121','000000000000000000000000000000000000000000000000000000001111111111111110000000000000000000000000'),
    (	@EventCode,@UserID, '20200122','000000000000000000000000000000000000000000000000000000001111111111111110000000000000000000000000'),
    (	@EventCode,@UserID, '20200123','000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20200124','000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20200125','000000000000000000000000000000000000000000000000000000001111111111111110000000000000000000000000'),
    (	@EventCode,@UserID, '20200126','000000000000000000000000000000000000000000000000111111111111111111111100000000000000000000000000'),
    (	@EventCode,@UserID, '20200127','000000000000000000000000000000000000000000000000000000001111111111111110000000000000000000000000')
    ;
    Select Group_CONCAT(CONCAT(EventDate,': ',  IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n')
    into @InsertedDays
    From Days
    Cross Join
        Users using(UserID)
    Where 
            EventCode = @EventCode
        AND	UserType = 'E'
    ;

    insert into LOGS(
        AssociatedUserID, 
        DateTime,
        Description
    )
    VALUES
    (
        @UserID, 
        NOW(),
        'USER CREATED'
    ),
    (
        @UserID, 
        NOW(),
        CONCAT('EVENT CREATED: ', @EventCode)
    ),
    (
        @UserID, 
        NOW(),
        CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays)
    );
    SET @EventCode = NULL;
    SET @UserID = NULL;
    SET @InsertedDays = NULL;

    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);



    -- Create New Event
    SET @EventCode = '1kz8nrm9ik';
    SET @UserID = 'e92nmghpjb';
    SET @InsertedDays = NULL;
    insert into Events(
        EventCode,
        EventTitle,
        Duration,
        Deadline,
        EventPassword
    )
    Values
    (
                            -- $eventCode = base_convert((strval(time()) . sprintf('%05d',rand (0, 99999))), 10, 36);
        @EventCode,		-- event code generated by: systemtime appended by 5 digit random number, then converted into base 36
        'New Years Brunch',	-- 55 char character limit
        8, 					-- this event takes 7 segments of time, (11*15)/60 = 2 hr 45 min
        '2020-12-30',		-- YYY-MM-DD
        'nyb'	-- 16 char character limit
    )
    ;



    insert into Users(
        UserID,				-- $userID = base_convert((strval(intval(time())-159999999) . sprintf('%03d',rand (0, 999)) . sprintf('%03d',rand (0, 999))) , 10, 36);
        UserType,			-- 'E' = Event
        RSVP,				-- True
        Email				-- Organizer's email
    )
    Values
    (
        @UserID,
        'E', 
        True, 
        'sirenaamaranth@gmil.com'
    )
    ;

    insert into  Days(
        EventCode,UserID,EventDate,TimeArray)
    Values
    (	@EventCode,@UserID, '20210101','000000000000000000000000001111111111110000000000000000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20210102','000000000000000000000000000000001111111111111111110000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20210103','000000000000000000000000000000001111111111111111110000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20210104','000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20210105','000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20210106','000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20210107','000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20210108','000000000000000000000000001111111111110000000000000000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20210109','000000000000000000000000000000001111111111111111110000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20210110','000000000000000000000000000000001111111111111111110000000000000000000000000000000000000000000000')
    ;
    Select Group_CONCAT(CONCAT(EventDate,': ',  IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n')
    into @InsertedDays
    From Days
    Cross Join
        Users using(UserID)
    Where 
            EventCode = @EventCode
        AND	UserType = 'E'
    ;

    insert into LOGS(
        AssociatedUserID, 
        DateTime,
        Description
    )
    VALUES
    (
        @UserID, 
        NOW(),
        'USER CREATED'
    ),
    (
        @UserID, 
        NOW(),
        CONCAT('EVENT CREATED: ', @EventCode)
    ),
    (
        @UserID, 
        NOW(),
        CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays)
    );
    SET @EventCode = NULL;
    SET @UserID = NULL;
    SET @InsertedDays = NULL;

    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);

    -- Create New Event
    SET @EventCode = '1kz8ogtg8v';
    SET @UserID = 'e92nt135p5';
    SET @InsertedDays = NULL;
    insert into Events(
        EventCode,
        EventTitle,
        Duration,
        Deadline,
        EventPassword
    )
    Values
    (
                            -- $eventCode = base_convert((strval(time()) . sprintf('%05d',rand (0, 99999))), 10, 36);
        @EventCode,		-- event code generated by: systemtime appended by 5 digit random number, then converted into base 36
        'Scrum #1',	-- 55 char character limit
        3, 					-- this event takes 7 segments of time, (11*15)/60 = 2 hr 45 min
        '2021-01-08',		-- YYY-MM-DD
        'scrum'	-- 16 char character limit
    )
    ;



    insert into Users(
        UserID,				-- $userID = base_convert((strval(intval(time())-159999999) . sprintf('%03d',rand (0, 999)) . sprintf('%03d',rand (0, 999))) , 10, 36);
        UserType,			-- 'E' = Event
        RSVP,				-- True
        Email				-- Organizer's email
    )
    Values
    (
        @UserID,
        'E', 
        True, 
        'sirenaamaranth@gmil.com'
    )
    ;

    insert into  Days(
        EventCode,UserID,EventDate,TimeArray)
    Values
    (	@EventCode,@UserID, '20210110','000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20210111','000000000000000000000000000000000000111110000000000000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20210112','000000000000000000000000000000000000111110000000000000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20210113','000000000000000000000000000000000000111110000000000000000000000000000000000000000000000000000000'),
    (	@EventCode,@UserID, '20210114','000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000')
    ;
    Select Group_CONCAT(CONCAT(EventDate,': ',  IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n')
    into @InsertedDays
    From Days
    Cross Join
        Users using(UserID)
    Where 
            EventCode = @EventCode
        AND	UserType = 'E'
    ;

    insert into LOGS(
        AssociatedUserID, 
        DateTime,
        Description
    )
    VALUES
    (
        @UserID, 
        NOW(),
        'USER CREATED'
    ),
    (
        @UserID, 
        NOW(),
        CONCAT('EVENT CREATED: ', @EventCode)
    ),
    (
        @UserID, 
        NOW(),
        CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays)
    );
    SET @EventCode = NULL;
    SET @UserID = NULL;
    SET @InsertedDays = NULL;
    -- ______________________________________________________________________________________________________________________________
    -- ______________________________________________________________________________________________________________________________
    -- ______________________________________________________________________________________________________________________________
    -- ______________________________________________________________________________________________________________________________

    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);

    -- Create Participant User (Accept)

    SET @EventCode = '1kxeqfw3ce';
    SET @UserID = 'e8l7whwrtb';
    SET @InsertedDays = NULL;
    insert into Users(
        UserID,	 UserType, UserName, RSVP,	 Email, CalenderFile
    )
    Values(
        @UserID,
        'P', 
        'Bender Rodriguez',
        True, 
        'BenderRodriguez@PlanetExpress.nny', 
        'bendersCalendar.ics'
    );

    insert into  Days( EventCode, UserID, EventDate, TimeArray )
    Values
    (	@EventCode, @UserID, '20201126', '111111111111111111111111111111111111111111111111111111000000000000000000000000000011111111111111'),
    (	@EventCode, @UserID, '20201127', '111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111'),
    (	@EventCode,	@UserID, '20201128', '111111111111111111111111111111111111111111111111000000000000000011111111111111111111111111111111')
    ;
    -- log
        Select Group_CONCAT(CONCAT(EventDate,': ', IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n')
        into @InsertedDays
        From Days
        Where  EventCode = @EventCode  AND	UserID = @UserID;

        insert into LOGS(	AssociatedUserID, DateTime, Description)
        VALUES
        ( @UserID,   NOW(),  'USER CREATED'),
        ( @UserID,   NOW(),  CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays));

        SET @EventCode = NULL;
        SET @UserID = NULL;
        SET @InsertedDays = NULL;
    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);
    -- ______________________________________________________________________________________________________________________________

    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);

    -- Create Participant User (Accept)

    SET @EventCode = '1kxeqfw3ce';
    SET @UserID = 'e92odsf8b5';
    SET @InsertedDays = NULL;
    insert into Users(
        UserID,	 UserType, UserName, RSVP,	 Email, CalenderFile
    )
    Values(
        @UserID,
        'P', 
        'Turanga Leela',
        True, 
        'TLeela@PlanetExpress.nny', 
        'leela.ics'
    );

    insert into  Days( EventCode, UserID, EventDate, TimeArray )
    Values
    (	@EventCode, @UserID, '20201127', '111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111'),
    (	@EventCode,	@UserID, '20201128', '111111111111111111100000001111111111111111111111111111111111111111111111111111111111111111111111')
    ;
    -- log
        Select Group_CONCAT(CONCAT(EventDate,': ', IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n')
        into @InsertedDays
        From Days
        Where  EventCode = @EventCode  AND	UserID = @UserID;

        insert into LOGS(	AssociatedUserID, DateTime, Description)
        VALUES
        ( @UserID,   NOW(),  'USER CREATED'),
        ( @UserID,   NOW(),  CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays));

        SET @EventCode = NULL;
        SET @UserID = NULL;
        SET @InsertedDays = NULL;
    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);
    -- ______________________________________________________________________________________________________________________________
    -- Create Participant User (Accept)

    SET @EventCode = '1kxeqfw3ce';
    SET @UserID = 'e92ohijvqo';
    SET @InsertedDays = NULL;
    insert into Users(
        UserID,	 UserType, UserName, RSVP,	 Email, CalenderFile
    )
    Values(
        @UserID,
        'P', 
        'Nibbler',
        True, 
        'Nibbler@Mil.gov', 
        'l98jsodklfhg89xdbhder24s.ics'
    );

    insert into  Days( EventCode, UserID, EventDate, TimeArray )
    Values
    (	@EventCode, @UserID, '20201127', '111111111111100000000000000000000000111111111111111111111111111111111111111111111111111111111111'),
    (	@EventCode,	@UserID, '20201128', '111111111111111111100000001111111111111111111111111111111111111111111111111111111111111111111111')
    ;
    -- log
        Select Group_CONCAT(CONCAT(EventDate,': ', IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n')
        into @InsertedDays
        From Days
        Where  EventCode = @EventCode  AND	UserID = @UserID;

        insert into LOGS(	AssociatedUserID, DateTime, Description)
        VALUES
        ( @UserID,   NOW(),  'USER CREATED'),
        ( @UserID,   NOW(),  CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays));

        SET @EventCode = NULL;
        SET @UserID = NULL;
        SET @InsertedDays = NULL;
    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);
    -- ______________________________________________________________________________________________________________________________

    -- Create Participant User (Decline)
    SET @EventCode = '1kz8nrm9ik';
    SET @UserID = 'e90gyvxky8';
    SET @InsertedDays = NULL;
    insert into Users(
        UserID,	 UserType, UserName, RSVP,	 Email, CalenderFile )
    Values(
        @UserID,
        'P', 
        'Amy Wong',
        False, 
        'drWong@planetExpress.com', 
        NULL
    );
    insert into  Days( 	EventCode,UserID, EventDate, TimeArray )
    Values( @EventCode, @UserID, '00000000',  NULL );
    -- log
        Select Group_CONCAT(CONCAT(EventDate,': ', IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n')
        into @InsertedDays
        From Days
        Where  EventCode = @EventCode  AND	UserID = @UserID;

        insert into LOGS(	AssociatedUserID, DateTime, Description)
        VALUES
        ( @UserID,   NOW(),  'USER CREATED'),
        ( @UserID,   NOW(),  CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays));

        SET @EventCode = NULL;
        SET @UserID = NULL;
        SET @InsertedDays = NULL;

-- ______________________________________________________________________________________________________________________________
-- ______________________________________________________________________________________________________________________________
-- ______________________________________________________________________________________________________________________________

    -- Create Participant User (Accept)

    SET @EventCode = '1kz8nrm9ik';
    SET @UserID = 'e92p74aj72';
    SET @NAME = 'Gretchen Lynton';
    SET @EMAIL = '';
    SET @CAL = '';
    SET @InsertedDays = NULL;

    insert into Users( UserID,	 UserType, UserName, RSVP,	 Email, CalenderFile )
    Values( @UserID,  'P', @NAME, True, @EMAIL,  @CAL );

    insert into  Days( EventCode, UserID, EventDate, TimeArray )
    Values
    (	@EventCode, @UserID,'','')
    ;
    -- log
        Select Group_CONCAT(CONCAT(EventDate,': ', IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n') into @InsertedDays From Days Where  EventCode = @EventCode  AND	UserID = @UserID;

        insert into LOGS(	AssociatedUserID, DateTime, Description)
        VALUES
        ( @UserID,   NOW(),  'USER CREATED'),
        ( @UserID,   NOW(),  CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays));

        SET @EventCode = NULL;
        SET @UserID = NULL;
        SET @InsertedDays = NULL;
    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);
-- ______________________________________________________________________________________________________________________________

-- ______________________________________________________________________________________________________________________________

    -- Create Participant User (Accept)

    SET @EventCode = '1kz8nrm9ik';
    SET @UserID = 'e92p78douk';
    SET @NAME = 'Trix Ruskin';
    SET @EMAIL = '';
    SET @CAL = '';
    SET @InsertedDays = NULL;

    insert into Users( UserID,	 UserType, UserName, RSVP,	 Email, CalenderFile )
    Values( @UserID,  'P', @NAME, True, @EMAIL,  @CAL );

    insert into  Days( EventCode, UserID, EventDate, TimeArray )
    Values
    (	@EventCode, @UserID,'','')
    ;
    -- log
        Select Group_CONCAT(CONCAT(EventDate,': ', IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n') into @InsertedDays From Days Where  EventCode = @EventCode  AND	UserID = @UserID;

        insert into LOGS(	AssociatedUserID, DateTime, Description)
        VALUES
        ( @UserID,   NOW(),  'USER CREATED'),
        ( @UserID,   NOW(),  CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays));

        SET @EventCode = NULL;
        SET @UserID = NULL;
        SET @InsertedDays = NULL;
    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);
-- ______________________________________________________________________________________________________________________________

-- ______________________________________________________________________________________________________________________________

    -- Create Participant User (Accept)

    SET @EventCode = '1kz8nrm9ik';
    SET @UserID = 'e92p7bux83';
    SET @NAME = 'Faith Lewin';
    SET @EMAIL = '';
    SET @CAL = '';
    SET @InsertedDays = NULL;

    insert into Users( UserID,	 UserType, UserName, RSVP,	 Email, CalenderFile )
    Values( @UserID,  'P', @NAME, True, @EMAIL,  @CAL );

    insert into  Days( EventCode, UserID, EventDate, TimeArray )
    Values
    (	@EventCode, @UserID,'','')
    ;
    -- log
        Select Group_CONCAT(CONCAT(EventDate,': ', IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n') into @InsertedDays From Days Where  EventCode = @EventCode  AND	UserID = @UserID;

        insert into LOGS(	AssociatedUserID, DateTime, Description)
        VALUES
        ( @UserID,   NOW(),  'USER CREATED'),
        ( @UserID,   NOW(),  CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays));

        SET @EventCode = NULL;
        SET @UserID = NULL;
        SET @InsertedDays = NULL;
    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);
-- ______________________________________________________________________________________________________________________________

-- ______________________________________________________________________________________________________________________________

    -- Create Participant User (Accept)

    SET @EventCode = '1kz8nrm9ik';
    SET @UserID = 'e92p7hmspe';
    SET @NAME = 'Vicki Platt';
    SET @EMAIL = '';
    SET @CAL = '';
    SET @InsertedDays = NULL;

    insert into Users( UserID,	 UserType, UserName, RSVP,	 Email, CalenderFile )
    Values( @UserID,  'P', @NAME, True, @EMAIL,  @CAL );

    insert into  Days( EventCode, UserID, EventDate, TimeArray )
    Values
    (	@EventCode, @UserID,'','')
    ;
    -- log
        Select Group_CONCAT(CONCAT(EventDate,': ', IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n') into @InsertedDays From Days Where  EventCode = @EventCode  AND	UserID = @UserID;

        insert into LOGS(	AssociatedUserID, DateTime, Description)
        VALUES
        ( @UserID,   NOW(),  'USER CREATED'),
        ( @UserID,   NOW(),  CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays));

        SET @EventCode = NULL;
        SET @UserID = NULL;
        SET @InsertedDays = NULL;
    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);
-- ______________________________________________________________________________________________________________________________

-- ______________________________________________________________________________________________________________________________

    -- Create Participant User (Accept)

    SET @EventCode = '1kz8nrm9ik';
    SET @UserID = 'e92p7tqom2';
    SET @NAME = 'Elsie Barnes';
    SET @EMAIL = '';
    SET @CAL = '';
    SET @InsertedDays = NULL;

    insert into Users( UserID,	 UserType, UserName, RSVP,	 Email, CalenderFile )
    Values( @UserID,  'P', @NAME, True, @EMAIL,  @CAL );

    insert into  Days( EventCode, UserID, EventDate, TimeArray )
    Values
    (	@EventCode, @UserID,'','')
    ;
    -- log
        Select Group_CONCAT(CONCAT(EventDate,': ', IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n') into @InsertedDays From Days Where  EventCode = @EventCode  AND	UserID = @UserID;

        insert into LOGS(	AssociatedUserID, DateTime, Description)
        VALUES
        ( @UserID,   NOW(),  'USER CREATED'),
        ( @UserID,   NOW(),  CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays));

        SET @EventCode = NULL;
        SET @UserID = NULL;
        SET @InsertedDays = NULL;
    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);
-- ______________________________________________________________________________________________________________________________

-- ______________________________________________________________________________________________________________________________

    -- Create Participant User (Accept)

    SET @EventCode = '1kz8nrm9ik';
    SET @UserID = 'e92p7y5d0b';
    SET @NAME = 'Jan Hooper';
    SET @EMAIL = '';
    SET @CAL = '';
    SET @InsertedDays = NULL;

    insert into Users( UserID,	 UserType, UserName, RSVP,	 Email, CalenderFile )
    Values( @UserID,  'P', @NAME, True, @EMAIL,  @CAL );

    insert into  Days( EventCode, UserID, EventDate, TimeArray )
    Values
    (	@EventCode, @UserID,'','')
    ;
    -- log
        Select Group_CONCAT(CONCAT(EventDate,': ', IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n') into @InsertedDays From Days Where  EventCode = @EventCode  AND	UserID = @UserID;

        insert into LOGS(	AssociatedUserID, DateTime, Description)
        VALUES
        ( @UserID,   NOW(),  'USER CREATED'),
        ( @UserID,   NOW(),  CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays));

        SET @EventCode = NULL;
        SET @UserID = NULL;
        SET @InsertedDays = NULL;
    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);
-- ______________________________________________________________________________________________________________________________

-- ______________________________________________________________________________________________________________________________

    -- Create Participant User (Accept)

    SET @EventCode = '1kz8nrm9ik';
    SET @UserID = 'e92p85evie';
    SET @NAME = 'Jeanie Beverly';
    SET @EMAIL = '';
    SET @CAL = '';
    SET @InsertedDays = NULL;

    insert into Users( UserID,	 UserType, UserName, RSVP,	 Email, CalenderFile )
    Values( @UserID,  'P', @NAME, True, @EMAIL,  @CAL );

    insert into  Days( EventCode, UserID, EventDate, TimeArray )
    Values
    (	@EventCode, @UserID,'','')
    ;
    -- log
        Select Group_CONCAT(CONCAT(EventDate,': ', IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n') into @InsertedDays From Days Where  EventCode = @EventCode  AND	UserID = @UserID;

        insert into LOGS(	AssociatedUserID, DateTime, Description)
        VALUES
        ( @UserID,   NOW(),  'USER CREATED'),
        ( @UserID,   NOW(),  CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays));

        SET @EventCode = NULL;
        SET @UserID = NULL;
        SET @InsertedDays = NULL;
    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);
-- ______________________________________________________________________________________________________________________________

-- ______________________________________________________________________________________________________________________________

    -- Create Participant User (Accept)

    SET @EventCode = '';
    SET @UserID = '';
    SET @NAME = '';
    SET @EMAIL = '';
    SET @CAL = '';
    SET @InsertedDays = NULL;

    insert into Users( UserID,	 UserType, UserName, RSVP,	 Email, CalenderFile )
    Values( @UserID,  'P', @NAME, True, @EMAIL,  @CAL );

    insert into  Days( EventCode, UserID, EventDate, TimeArray )
    Values
    (	@EventCode, @UserID,'','')
    ;
    -- log
        Select Group_CONCAT(CONCAT(EventDate,': ', IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n') into @InsertedDays From Days Where  EventCode = @EventCode  AND	UserID = @UserID;

        insert into LOGS(	AssociatedUserID, DateTime, Description)
        VALUES
        ( @UserID,   NOW(),  'USER CREATED'),
        ( @UserID,   NOW(),  CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays));

        SET @EventCode = NULL;
        SET @UserID = NULL;
        SET @InsertedDays = NULL;
    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);
-- ______________________________________________________________________________________________________________________________

-- ______________________________________________________________________________________________________________________________

    -- Create Participant User (Accept)

    SET @EventCode = '';
    SET @UserID = '';
    SET @NAME = '';
    SET @EMAIL = '';
    SET @CAL = '';
    SET @InsertedDays = NULL;

    insert into Users( UserID,	 UserType, UserName, RSVP,	 Email, CalenderFile )
    Values( @UserID,  'P', @NAME, True, @EMAIL,  @CAL );

    insert into  Days( EventCode, UserID, EventDate, TimeArray )
    Values
    (	@EventCode, @UserID,'','')
    ;
    -- log
        Select Group_CONCAT(CONCAT(EventDate,': ', IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n') into @InsertedDays From Days Where  EventCode = @EventCode  AND	UserID = @UserID;

        insert into LOGS(	AssociatedUserID, DateTime, Description)
        VALUES
        ( @UserID,   NOW(),  'USER CREATED'),
        ( @UserID,   NOW(),  CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays));

        SET @EventCode = NULL;
        SET @UserID = NULL;
        SET @InsertedDays = NULL;
    SELECT  RAND()*(16-5)+5 into @wait; 
    SELECT SLEEP(@wait);
-- ______________________________________________________________________________________________________________________________
