-- description: Constraint 14
DELIMITER @@
DROP TRIGGER IF EXISTS trigger3 @@

CREATE TRIGGER trigger3
	BEFORE INSERT ON Bids
    FOR EACH ROW 
    BEGIN
    	IF NEW.Amount <= (SELECT i.Currently from Items i WHERE NEW.ItemID = i.ItemID) THEN
      		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Trigger 3 Failed";
        END IF;
    END @@
    
DELIMITER ;

