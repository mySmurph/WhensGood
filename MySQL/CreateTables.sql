-- CREATE SCHEMA `group4` ;
use group4;
-- -- Drop All Tables
-- alter table Days DROP FOREIGN KEY  fk_event_code;
-- alter table Days DROP FOREIGN KEY  fk_userID;
-- alter table Users DROP FOREIGN KEY  fk_userType;
-- DROP TABLE IF EXISTS Events;
-- DROP TABLE IF EXISTS User_Types;
-- DROP TABLE IF EXISTS Users;
-- DROP TABLE IF EXISTS Days;
-- DROP TABLE IF EXISTS LOGS;

-- -- Create all Tables
CREATE TABLE Events(
	EventCode VARCHAR(16) PRIMARY KEY,
    EventTitle VARCHAR(55),
	Duration DECIMAL(3,0),
	Deadline DATE,
	EventPassword VARCHAR (16)
);

CREATE TABLE User_Types(
	UserTypeID VARCHAR(1) PRIMARY KEY, 
    UserType VARCHAR(11)
);

CREATE TABLE Users(
	UserID VARCHAR(16) PRIMARY KEY,
	UserType VARCHAR(11) NOT NULL,
	UserName VARCHAR(55),
    RSVP boolean NOT NULL,
	Email VARCHAR(55),
	CalenderFile VARCHAR(96),
    Password VARCHAR(40),
		CONSTRAINT fk_userType FOREIGN KEY (UserType) REFERENCES User_Types(UserTypeID)
);

CREATE TABLE Days(
	EventCode VARCHAR(16),
	UserID VARCHAR(16),
	EventDate DECIMAL(8,0),
	TimeArray VARCHAR(96),
		CONSTRAINT pk_Days PRIMARY KEY (EventCode, UserID, EventDate),
		CONSTRAINT fk_event_code FOREIGN KEY (EventCode) REFERENCES Events(EventCode)  ON DELETE CASCADE,
		CONSTRAINT fk_userID FOREIGN KEY (UserID) REFERENCES Users(UserID)  ON DELETE CASCADE
);
CREATE TABLE LOGS(
	LogEntry INT NOT NULL AUTO_INCREMENT,
    AssociatedUserID VARCHAR(16),	-- not a forign key! this is related to Users.UserID but in the event that a user is deleted we need to keep this data.
    DateTime datetime NOT NULL,
    Description TEXT,
    primary key(LogEntry)
);

-- insert Constants into UserTypes Table
insert into User_Types(UserTypeID, UserType)
values
	('O', 'Organizer'),
	('E', 'Event'),
	('P', 'Participant'),
    ('A', 'SysAdmin');
    

-- insert Admin User
insert into Users(
	UserID,				-- $userID = base_convert((strval(intval(time())-159999999) . sprintf('%03d',rand (0, 999)) . sprintf('%03d',rand (0, 999))) , 10, 36);
	UserType,			-- 'A' = System Administrator
    UserName,
    RSVP,				-- False
	Email,
	Password
)
Values(
	'Admin_SM',
    'A', 
    'Sirena Murphree',
    False, 
    'murph135@cougars.csusm.edu', 
    MD5('Admin_SM')
)
;
SELECT * FROM User_Types;
