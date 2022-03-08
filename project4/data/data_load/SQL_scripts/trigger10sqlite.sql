-- description: Additional Constraint 1.1 - update on status based on change in current price

PRAGMA foreign_keys = ON;

DROP TRIGGER IF EXISTS trigger10;

CREATE TRIGGER trigger10
	AFTER UPDATE OF Currently ON Items
	FOR EACH ROW 
	WHEN (old.Currently <> new.Currently)     -- not really necessary, put it here to be sure
	BEGIN 
		UPDATE Status
		SET cur_state = (CASE
						WHEN Status.cur_state = "Not Started" THEN "Not Started"
						WHEN new.Currently < new.Buy_Price OR new.Buy_Price IS NULL THEN "Open"
						ELSE "Closed"
					END)
		WHERE new.ItemID = Status.ItemID;
	END;
	