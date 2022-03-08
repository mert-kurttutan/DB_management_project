DROP TABLE IF EXISTS Status;

-- Creates table for status of the auction

CREATE TABLE Status(
	ItemID INT PRIMARY KEY,
	cur_state VARCHAR(20),
	FOREIGN KEY (ItemID) REFERENCES Items(ItemID)
	);

-- Run after running create.sql
