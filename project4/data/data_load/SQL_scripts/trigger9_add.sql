-- description: Additional Constraint 1.0 - update on status based on change in current time
DELIMITER @@
DROP TRIGGER IF EXISTS trigger9 @@

CREATE TRIGGER trigger9
	AFTER UPDATE ON CurrentTime
    FOR EACH ROW 
    BEGIN
		UPDATE Status SET cur_state = 
        	(CASE
            	WHEN new.Time_t < (SELECT Started FROM Items WHERE Items.ItemId = Status.ItemID)  THEN "Not Started"
                WHEN  new.Time_t < (SELECT Ends FROM Items WHERE Items.ItemId = Status.ItemID)
                AND EXISTS (SELECT Items.ItemId FROM Items WHERE Items.ItemID = Status.ItemID AND Items.Currently < Items.Buy_Price OR Items.Buy_Price IS NULL) THEN "Open"
                ELSE "Closed"
             END);
    END @@
DELIMITER ;