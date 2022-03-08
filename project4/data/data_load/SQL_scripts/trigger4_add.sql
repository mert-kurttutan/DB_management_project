-- description: Constraint 13

DELIMITER @@
DROP TRIGGER IF EXISTS trigger4 @@

CREATE TRIGGER trigger4
	AFTER INSERT ON Bids
    FOR EACH ROW 
    BEGIN
		UPDATE Items SET Number_of_Bids = Number_of_Bids + 1
        WHERE NEW.ItemID = Items.ItemID;
    END @@
    
DELIMITER ;