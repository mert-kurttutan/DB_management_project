-- Loads the data into the table
INSERT INTO Status
SELECT i.ItemID,
CASE
    WHEN cTime.Time_t < i.Started  THEN "notstarted"
    -- Buy_Price could also be a null value
    WHEN  cTime.Time_t < i.Ends AND (i.Currently < i.Buy_Price or i.Buy_Price is NULL)  THEN "open"           
    ELSE "closed"
END AS State
FROM Items i, CurrentTime cTime