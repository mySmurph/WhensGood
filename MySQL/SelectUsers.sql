-- find all RSVP responcses of participants to event
SELECT 
	  UserName
    , RSVP 
FROM Users
Where 
	UserID IN (
		select distinct UserID 
        From Days 
        where Days.EventCode = '1kxeqfw3ce'
        )
AND
	UserType = 'p'
;

-- find participants to that accept invitation to event
SELECT 
	  UserName
FROM Users
Where 
		UserID IN (
			select distinct UserID 
			From Days 
			where Days.EventCode = '1kxeqfw3ce'
			)
	AND	UserType = 'p'
	AND	RSVP = TRUE
;

-- find participants to that Declined invitation to event
SELECT 
	  UserName
FROM Users
Where 
		UserID IN (
			select distinct UserID 
			From Days 
			where Days.EventCode = '1kxeqfw3ce'
			)
	AND	UserType = 'p'
	AND	RSVP = False
;

-- get all calendars to an event
SELECT TimeArray
FROM Days
Where
		Days.EventCode = '1kxEqfw3ce'
    AND Days.TimeArray IS NOT NULL
;