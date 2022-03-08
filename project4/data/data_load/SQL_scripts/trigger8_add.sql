-- description: Constraint 8
DELIMITER @@
DROP TRIGGER IF EXISTS trigger8 @@

CREATE TRIGGER trigger8
	BEFORE INSERT ON Bids
    FOR EACH ROW 
    BEGIN
		UPDATE Items i SET i.Currently = NEW.Amount WHERE i.ItemID = NEW.ItemID;
    END @@
    
DELIMITER ;