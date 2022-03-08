-- description: Constraint 15

DELIMITER @@

DROP TRIGGER IF EXISTS trigger2 @@

CREATE TRIGGER trigger2
	BEFORE INSERT ON Bids
    FOR EACH ROW 
    BEGIN 
    	IF NEW.Time_t <> (SELECT c.Time_t FROM CurrentTime c) THEN
        	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Trigger 2 Failed";
        END IF;
    END @@
    
DELIMITER ;