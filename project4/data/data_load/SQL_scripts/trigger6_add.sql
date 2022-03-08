-- description: Constraint 11
DELIMITER @@
DROP TRIGGER IF EXISTS trigger6 @@

CREATE TRIGGER trigger6
	BEFORE INSERT ON Bids
    FOR EACH ROW 
    BEGIN
    	IF NEW.Time_t > (SELECT i.Ends from Items i WHERE NEW.ItemID = i.ItemID) THEN
      		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Trigger 6 Failed";
        END IF;
    END @@
    
DELIMITER ;