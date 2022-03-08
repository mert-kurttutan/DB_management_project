LOAD DATA LOCAL INFILE "../../dat_files/usersUnique.dat" INTO TABLE Users FIELDS  TERMINATED BY '|'  OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE "../../dat_files/itemsUnique.dat" INTO TABLE Items FIELDS TERMINATED BY '|' OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE "../../dat_files/categoriesUnique.dat" INTO TABLE Categories FIELDS TERMINATED BY '|' OPTIONALLY ENCLOSED BY '"';

LOAD DATA LOCAL INFILE "../../dat_files/bidsUnique.dat" INTO TABLE Bids FIELDS TERMINATED BY '|' OPTIONALLY ENCLOSED BY '"';



UPDATE Items SET Buy_Price = NULL WHERE Buy_Price = -999;
update Items set Description=NULL where Description="empty";
UPDATE Users SET Location = NULL WHERE Location = "empty";
update Users set Country=NULL where Country="empty";