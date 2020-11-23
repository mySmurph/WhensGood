-- Create Participant User (Accept)
insert into Users(
	UserID,				-- $userID = base_convert((strval(intval(time())-159999999) . sprintf('%03d',rand (0, 999)) . sprintf('%03d',rand (0, 999))) , 10, 36);
	UserType,			-- 'E' = Event
    UserName,
    RSVP,				-- True
	Email, 				-- Organizer's email
	CalenderFile
)
Values(
	'e8l7whwrtb',
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
	'1kxeqfw3ce',
    'e8l7whwrtb', 
    '20201126',
    '111111111111111111111111111111111111111111111111111111000000000000000000000000000011111111111111'
),
(
	'1kxeqfw3ce',
    'e8l7whwrtb', 
    '20201127',
    '111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111'
),
(
	'1kxeqfw3ce',
    'e8l7whwrtb', 
    '20201128',
    '111111111111111111111111111111111111111111111111000000000000000011111111111111111111111111111111'
)
;

-- Create Participant User (Decline)
insert into Users(
	UserID,				-- $userID = base_convert((strval(intval(time())-159999999) . sprintf('%03d',rand (0, 999)) . sprintf('%03d',rand (0, 999))) , 10, 36);
	UserType,			-- 'P' = Participant
    UserName,
    RSVP,				-- False
	Email,
	CalenderFile
)
Values(
	'e8l8gk1cms',
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
	'1kxeqfw3ce',
    'e8l8gk1cms', 
    0,
    NULL
)
;