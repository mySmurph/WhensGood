SET @username = '$username';<br>
SET @Display_Name = '$Display_Name';<br>
SET @email = '$email';<br>
SET @password = '$password';<br>

INSERT INTO Users(
 username, Display_Name, email, Password
)
VALUES
(
 @username, @Display_Name, @email, MD5(@password) 
);<br>

INSERT INTO LOGS(
 AssociatedUserID, 
 DateTime,
 Description
)
VALUES
(
 @username, 
 NOW(),
 'NEW USER CREATED'
);<br>

SET @username = NULL;<br>
SET @Display_Name = NULL;<br>
SET @email = NULL;<br>
SET @password = NULL;