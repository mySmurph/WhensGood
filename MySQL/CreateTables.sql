-- CREATE SCHEMA `WhensGood_db` ;
use WhensGood_db;
alter table Days DROP FOREIGN KEY  fk_event_code;
alter table Days DROP FOREIGN KEY  fk_userID;
alter table Users DROP FOREIGN KEY  fk_userType;
DROP TABLE IF EXISTS Events;
DROP TABLE IF EXISTS User_Types;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Days;

CREATE TABLE Events(
	EventCode VARCHAR(16) PRIMARY KEY,
    EventTitle VARCHAR(55),
	Durration DECIMAL(3,0),
	Deadline DATE,
	EventPassword VARCHAR(16)
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
		CONSTRAINT fk_userType FOREIGN KEY (UserType) REFERENCES User_Types(UserTypeID)
);

CREATE TABLE Days(
	EventCode VARCHAR(16),
	UserID VARCHAR(16),
	EventDate DECIMAL(8,0),
	TimeArray VARCHAR(96),
		CONSTRAINT pk_Days PRIMARY KEY (EventCode, UserID, EventDate),
		CONSTRAINT fk_event_code FOREIGN KEY (EventCode) REFERENCES Events(EventCode),
		CONSTRAINT fk_userID FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

use WhensGood_db;
insert into User_Types(UserTypeID, UserType)
values
	('O', 'Organizer'),
	('E', 'Event'),
	('P','Participant');