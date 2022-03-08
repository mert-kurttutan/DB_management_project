DROP TABLE IF EXISTS Items, Categories, Bids, Users, CurrentTime, Status;

CREATE TABLE Items (
   ItemID INTEGER,
   Name TEXT,
   Currently REAL,
   First_Bid REAL,
   Buy_Price REAL,
   Number_of_Bids INTEGER,
   Started VARCHAR(60),
   `Ends` VARCHAR(60),
   Seller_UserID VARCHAR(60),
   Description TEXT,
   PRIMARY KEY(ItemID),
   CHECK (`Ends` > Started)
);

CREATE TABLE Categories (
   ItemID INTEGER,
   Category VARCHAR(60),
   PRIMARY KEY(ItemID, Category)
);

CREATE TABLE Bids (
   ItemID INTEGER,
   UserID VARCHAR(60),
   Amount REAL,
   Time_t VARCHAR(60),
   PRIMARY KEY(ItemID, UserID, Amount),
   UNIQUE(ItemID, Time_t)
);

CREATE TABLE Users (
   UserID VARCHAR(60),
   Rating INTEGER,
   Location TEXT,
   Country TEXT,
   PRIMARY KEY(UserID)
);

CREATE TABLE CurrentTime (
   Time_t VARCHAR(60)
);

SELECT Time_t FROM CurrentTime;

INSERT into CurrentTime values ("2001-12-20 00:00:01");

-- ADD Constraints

ALTER TABLE Items ADD CONSTRAINT FOREIGN KEY(Seller_UserID) REFERENCES Users(UserID);
ALTER TABLE Categories ADD CONSTRAINT FOREIGN KEY(ItemID) REFERENCES Items(ItemID);
ALTER TABLE Bids ADD CONSTRAINT FOREIGN KEY(ItemID) REFERENCES Items(ItemID);
ALTER TABLE Bids ADD CONSTRAINT FOREIGN KEY(UserID) REFERENCES Users(UserID);



-- Creates table for status of the auction



CREATE TABLE Status(
	ItemID INT PRIMARY KEY,
	cur_state VARCHAR(20),
	FOREIGN KEY (ItemID) REFERENCES Items(ItemID)
	);

-- Run after running create.sql
