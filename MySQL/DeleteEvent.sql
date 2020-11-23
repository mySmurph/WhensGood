-- Delete Event and all corrosponding users

Delete from Users 
Where 
	UserID IN (
				Select distinct UserID 
                from Days
                Where
					EventCode = '1kxeqfw3ce'
                )
;
Delete from Events 
Where
	EventCode = '1kxeqfw3ce';