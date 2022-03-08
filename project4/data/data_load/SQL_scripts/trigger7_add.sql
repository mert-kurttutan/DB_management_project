-- description: Constraint 9
DELIMITER @@
DROP TRIGGER IF EXISTS trigger7 @@

CREATE TRIGGER trigger7
	BEFORE INSERT ON Bids
    FOR EACH ROW 
    BEGIN
    	IF NEW.UserID = (SELECT i.Seller_UserID from Items i WHERE NEW.ItemID = i.ItemID) THEN
      		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Trigger 7 Failed";
        END IF;
    END @@
    
DELIMITER ;