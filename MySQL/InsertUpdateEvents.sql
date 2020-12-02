-- Create New Event
insert into Events(
	EventCode,
    EventTitle,
	Durration,
	Deadline,
	EventPassword
)
Values
(
						-- $eventCode = base_convert((strval(time()) . sprintf('%05d',rand (0, 99999))), 10, 36);
	'1kxeqfw3ce',		-- event code generated by: systemtime appended by 5 digit random number, then converted into base 36
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
	'e8l6kj91ek',
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
	'1kxeqfw3ce',
    'e8l6kj91ek', 
    '20201126',
    '000000000000000000000000000000000000000000000000111111111111111111111111111100000000000000000000'
),
(
	'1kxeqfw3ce',
    'e8l6kj91ek', 
    '20201127',
    '000000000000000000000000000000001111111111111111111111111111111111111111111111111111000000000000'
),
(
	'1kxeqfw3ce',
    'e8l6kj91ek', 
    '20201128',
    '000000000000000000000000000000000000111111111111111111111111111111110000000000000000000000000000'
)
;



-- update Event: Change Existing day
update Days
Cross Join
	Users using(UserID)
SET
	TimeArray = '000000000000000000000000000000000000000000000111111111111111111111111111111110000000000000000000'

WHERE
		EventCode = '1kxeqfw3ce'
    AND	EventDate = '20201128'
    AND	UserType = 'E'
;

SELECT * FROM Days;
