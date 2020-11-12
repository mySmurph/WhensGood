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
	EventCode VARCHAR(24) PRIMARY KEY,
	Durration DECIMAL(3,0),
	Deadline DATE,
	EventPassword VARCHAR(16)
);

CREATE TABLE User_Types(
	UserTypeID VARCHAR(11) PRIMARY KEY
);

CREATE TABLE Users(
	UserID VARCHAR(8) PRIMARY KEY,
	UserType VARCHAR(11) NOT NULL,
	UserName VARCHAR(55),
    RSVP boolean NOT NULL,
	Email VARCHAR(55),
	CalenderFile VARCHAR(96),
		CONSTRAINT fk_userType FOREIGN KEY (UserType) REFERENCES User_Types(UserTypeID)
);

CREATE TABLE Days(
	EventCode VARCHAR(24),
	UserID VARCHAR(8),
	TimeArray VARCHAR(96),
	EventDate DECIMAL(8,0),
		CONSTRAINT pk_Days PRIMARY KEY (EventCode, UserID, EventDate),
		CONSTRAINT fk_event_code FOREIGN KEY (EventCode) REFERENCES Events(EventCode),
		CONSTRAINT fk_userID FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

