-- description: Constraint 11
DELIMITER @@
DROP TRIGGER IF EXISTS trigger5 @@

CREATE TRIGGER trigger5
	BEFORE INSERT ON Bids
    FOR EACH ROW 
    BEGIN
    	IF NEW.Time_t <= (SELECT i.Started from Items i WHERE NEW.ItemID = i.ItemID) THEN
      		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Trigger 5 Failed";
        END IF;
    END @@
    
DELIMITER ;