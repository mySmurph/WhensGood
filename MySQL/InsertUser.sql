-- Create Participant User (Accept)

SET @EventCode = '1kxeqfw3ce';
SET @UserID = 'e8l7whwrtb';
SET @InsertedDays = NULL;
insert into Users(
	UserID,				-- $userID = base_convert((strval(intval(time())-159999999) . sprintf('%03d',rand (0, 999)) . sprintf('%03d',rand (0, 999))) , 10, 36);
	UserType,			-- 'E' = Event
    UserName,
    RSVP,				-- True
	Email, 				-- Organizer's email
	CalenderFile
)
Values(
	@UserID,
    'P', 
    'Bender Rodriguez',
    True, 
    'BenderRodriguez@PlanetExpress.nny', 
    'bendersCalendar.ical'
);

insert into  Days(
	EventCode,
	UserID,
	EventDate,
	TimeArray
)
Values(
	@EventCode,
	@UserID,
    '20201126',
    '111111111111111111111111111111111111111111111111111111000000000000000000000000000011111111111111'
),
(
	@EventCode,
	@UserID,
    '20201127',
    '111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111'
),
(
	@EventCode,
	@UserID,
    '20201128',
    '111111111111111111111111111111111111111111111111000000000000000011111111111111111111111111111111'
)
;



Select Group_CONCAT(CONCAT(EventDate,': ',  IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n')
into @InsertedDays
From Days
Where 
		EventCode = @EventCode
    AND	UserID = @UserID
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
    CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays)
);
SET @EventCode = NULL;
SET @UserID = NULL;
SET @InsertedDays = NULL;


-- Create Participant User (Decline)
SET @EventCode = '1kxeqfw3ce';
SET @UserID = 'e8l8gk1cms';
SET @InsertedDays = NULL;
insert into Users(
	UserID,				-- $userID = base_convert((strval(intval(time())-159999999) . sprintf('%03d',rand (0, 999)) . sprintf('%03d',rand (0, 999))) , 10, 36);
	UserType,			-- 'P' = Participant
    UserName,
    RSVP,				-- False
	Email,
	CalenderFile
)
Values(
	@UserID,
    'P', 
    'Kif Kroker',
    False, 
    'KKroker@DOOP.Gov', 
    NULL
)
;


insert into  Days(
	EventCode,
	UserID,
	EventDate,
	TimeArray
)
Values(
	@EventCode,
	@UserID,
    '00000000',
    NULL
)
;
Select Group_CONCAT(CONCAT(EventDate,': ', IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n')
into @InsertedDays
From Days
Where 
		EventCode = @EventCode
    AND	UserID = @UserID
;
select @InsertedDays;

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
    CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays)
);

SET @EventCode = NULL;
SET @UserID = NULL;
SET @InsertedDays = NULL;