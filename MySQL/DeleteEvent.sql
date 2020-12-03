-- Delete Event and all corrosponding users
SELECT 
	Group_CONCAT(distinct CONCAT('\'',UserID, '\'' ))

INTO
    @DeletedUserID
FROM Days
WHERE
	EventCode = '1kxeqfw3ce';
select @DeletedUserID;

Delete from Users 
Where 
	UserID IN ( @DeletedUserID )
;
Delete from Events 
Where
	EventCode = '1kxeqfw3ce';
SELECT * from Days;
insert into LOGS(
	AssociatedUserID, 
    DateTime,
    Description
)
VALUES
(
	'e8l6kj91ek', 
    NOW(),
    'EVENT DELETED: 1kxeqfw3ce'
),
(
	'e8l6kj91ek', 
    NOW(),
    concat('USER DELETED: ',  @DeletedUserID)
)
;
Set @DeletedUserID = NULL;