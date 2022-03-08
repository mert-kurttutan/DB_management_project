-- description: Additional Constraint 1.0 - update on status based on change in current time

PRAGMA foreign_keys = ON;

DROP TRIGGER IF EXISTS trigger9;

CREATE TRIGGER trigger9
	AFTER UPDATE on CurrentTime
	FOR EACH ROW
	begin
		UPDATE Status SET cur_state = 
                (CASE
                    WHEN new.Time_t < (SELECT Started FROM Items WHERE Items.ItemId = Status.ItemID)  THEN "Not Started"
                    WHEN  new.Time_t < (SELECT Ends FROM Items WHERE Items.ItemId = Status.ItemID)
                        AND EXISTS (SELECT Items.ItemId FROM Items WHERE Items.ItemID = Status.ItemID AND Items.Currently < Items.Buy_Price OR Items.Buy_Price IS NULL) THEN "Open"
                    ELSE "Closed"
                END);
	end;