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
	AND	RSVP = 'FALSE'
;

-- Display Event Days Information
SELECT
	EventDate Date, TimeArray Time
from
	Days d
Inner Join
	Users u using(UserID)
WHERE
	d.EventCode = '1kxeqfw3ce' AND u.UserType = 'E'
ORDER BY Date ASC;

-- get all calendars to an event
SELECT 
	EventDate Date, TimeArray Time
FROM Days
Where
		Days.EventCode = '1kxEqfw3ce'
    AND Days.TimeArray IS NOT NULL
;

-- Lookup Event (RSVP: No Password)
Select count(Distinct EventCode) as EventFound from Events Where EventCode = '1kxeqfw3ce';
-- Lookup Event (Schedule/Edit: Case Sensitive Password Required)
Select count(Distinct EventCode) as EventFound from Events Where EventCode = '1kxeqfw3ce' AND  EventPassword like Binary 'myFakePassword' ; -- returns 0, password is incorrect
Select count(Distinct EventCode) as EventFound from Events Where EventCode = '1kxEQfw3ce' AND  EventPassword like Binary 'MyFakePassword' ; -- returns 1
SELECT Duration FROM Events Where EventCode = '1kxeqfw3ce';
SELECT EventTitle FROM Events Where EventCode = '1kxeqfw3ce' LIMIT 0,1;
SELECT Email FROM Users u INNER JOIN Days d USING (UserID) WHERE d.EventCode = '1kxeqfw3ce' AND u.UserType = 'E' LIMIT 0,1;
Select count(UserID) as Admin from EventsUsers Where UserID = 'Admin_SM' AND  Password = MD5('Admin_SM') ; -- returns 1
