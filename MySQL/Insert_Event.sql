SET @username = '$username';<br>
SET @EventCode = '$EventCode';<br>
SET @EventTitle = '$EventTitle';<br>
SET @duration = $duration;<br>
SET @deadline = '$deadline';<br>

SET @InsertedDays = NULL;<br>


insert into Events(
 EventCode,
 EventOrganizer, 
 EventTitle,
 Duration,
 Deadline
)
Values
(
 @EventCode,
 @username,
 @EventTitle,
 @duration,
 @deadline
);<br>

insert into Days(
 EventCode,
 EventDate,
 TimeArray
)
Values
$Days
;<br>
Select Group_CONCAT(CONCAT(EventDate,': ', IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n')
into @InsertedDays
From Days
Where 
 EventCode = @EventCode
;<br>

insert into LOGS(
 AssociatedUserID, 
 DateTime,
 Description
)
VALUES

(
 @username, 
 NOW(),
 CONCAT('EVENT CREATED: ', @EventCode)
),
(
 @username, 
 NOW(),
 CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',@EventCode, @InsertedDays)
);<br>
SET @username = NULL;<br>
SET @EventCode = NULL;<br>
SET @EventTitle = NULL;<br>
SET @duration = NULL;<br>
SET @deadline = NULL;<br>
SET @InsertedDays = NULL;<br>