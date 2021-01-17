-- CREATE SCHEMA `group4` ;
use WhensDay;
-- -- Drop All Tables
alter table Days DROP FOREIGN KEY  fk_event_code;
alter table Users DROP FOREIGN KEY  fk_userType;
alter table Events DROP FOREIGN KEY  fk_EventOrganizer;
alter table EventParticipant DROP FOREIGN KEY  fk_EventCode;
alter table EventParticipant DROP FOREIGN KEY  fk_EventParticipant ;

DROP TABLE IF EXISTS Events;
DROP TABLE IF EXISTS User_Types;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Days;
DROP TABLE IF EXISTS LOGS;
DROP TABLE IF EXISTS EventParticipant;

-- -- Create all Tables

CREATE TABLE User_Types(
	UserTypeID CHAR(1) PRIMARY KEY, 
    UserType VARCHAR(20)
);
-- insert Constants into UserTypes Table
insert into User_Types(UserTypeID, UserType)
values
	('U', 'User'),
    ('A', 'System Administrator');
    
CREATE TABLE Users(
	username VARCHAR(30) NOT NULL,
	user_type CHAR(1) NOT NULL DEFAULT 'U',
	Display_Name VARCHAR(55),
	email VARCHAR(80) NOT NULL,
    Password VARCHAR(40),
		CONSTRAINT pk_UserID PRIMARY KEY (username),
		CONSTRAINT fk_userType FOREIGN KEY (user_type) REFERENCES User_Types(UserTypeID)
);

CREATE TABLE Events(
	EventCode VARCHAR(16) PRIMARY KEY,
    EventOrganizer VARCHAR(30),
    EventTitle VARCHAR(55),
	Duration DECIMAL(3,0),
	Deadline DATE,
		CONSTRAINT fk_EventOrganizer FOREIGN KEY (EventOrganizer) REFERENCES Users(username)
);

CREATE TABLE Days(
	EventCode VARCHAR(16),
	EventDate DATE,
	TimeArray VARCHAR(96),
		CONSTRAINT pk_Days PRIMARY KEY (EventCode, EventDate),
		CONSTRAINT fk_event_code FOREIGN KEY (EventCode) REFERENCES Events(EventCode)  ON DELETE CASCADE
);
CREATE TABLE EventParticipant(
	EventCode VARCHAR(16),
	EventParticipant VARCHAR(30),
    Responce boolean NOT NULL DEFAULT FALSE,
	CalenderFile VARCHAR(96),
		CONSTRAINT pk_RSVPs PRIMARY KEY (EventCode, EventParticipant),
        CONSTRAINT fk_EventCode FOREIGN KEY (EventCode) REFERENCES Events(EventCode) ON DELETE CASCADE, 
        CONSTRAINT fk_EventParticipant FOREIGN KEY (EventParticipant) REFERENCES Users(username) ON DELETE CASCADE
);

CREATE TABLE LOGS(
	LogEntry INT NOT NULL AUTO_INCREMENT,
    AssociatedUserID VARCHAR(30),	-- not a forign key! this is related to Users.UserID but in the event that a user is deleted we need to keep this data.
    DateTime datetime NOT NULL,
    Description TEXT,
    primary key(LogEntry)
);



-- insert Admin User
insert into Users(
	username,		-- $userID = base_convert((strval(intval(time())-159999999) . sprintf('%03d',rand (0, 999)) . sprintf('%03d',rand (0, 999))) , 10, 36);
	user_type, 			-- 'A' = System Administrator
    Display_Name,
	email,
	Password
)
Values(
	'WhensDay_Admin',
    'A', 
    'Sirena Murphree',
    'admin@whensday.page', 
    MD5('1234')
)
;
SELECT * FROM User_Types;
