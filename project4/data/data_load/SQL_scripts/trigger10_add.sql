-- description: Additional Constraint 1.1 - update on status based on change in current price
DELIMITER @@
DROP TRIGGER IF EXISTS trigger10 @@

CREATE TRIGGER trigger10
	AFTER UPDATE ON Items
    FOR EACH ROW 
    BEGIN
        IF OLD.Currently != NEW.Currently THEN
        	UPDATE Status 
            SET cur_state = (CASE
                                WHEN Status.cur_state = "Not Started" THEN "Not Started"
                                WHEN NEW.Currently < NEW.Buy_Price OR NEW.Buy_Price IS NULL THEN "Open"
                                ELSE "Closed"
                            END)
            WHERE NEW.ItemID = Status.ItemID;
        END IF;
    END @@
DELIMITER ;