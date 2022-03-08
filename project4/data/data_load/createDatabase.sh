
# for LOCAL LOADING from arbitrary folder inside local computer
password="YOUR PASSWORD"
mysql -h localhost -u root -pProfessorX1991. --local-infile=1 auction_db < prepare_mysql_config.sql

# create and load data
mysql -h localhost -u root -p${password} --local-infile=1 auction_db < create.sql
mysql -h localhost -u root -p${password} --local-infile=1 auction_db < create_v2.sql
mysql -h localhost -u root -p${password} --local-infile=1 auction_db < load.sql
mysql -h localhost -u root -p${password} --local-infile=1 auction_db < load_v2.sql

# add triggers
mysql -h localhost -u root -p${password} --local-infile=1 auction_db < constraints_verify.sql
mysql -h localhost -u root -p${password} --local-infile=1 auction_db < trigger1_add.sql
mysql -h localhost -u root -p${password} --local-infile=1 auction_db < trigger2_add.sql
mysql -h localhost -u root -p${password} --local-infile=1 auction_db < trigger3_add.sql

mysql -h localhost -u root -p${password} --local-infile=1 auction_db < trigger4_add.sql
mysql -h localhost -u root -p${password} --local-infile=1 auction_db < trigger5_add.sql
mysql -h localhost -u root -p${password} --local-infile=1 auction_db < trigger6_add.sql
mysql -h localhost -u root -p${password} --local-infile=1 auction_db < trigger7_add.sql
mysql -h localhost -u root -p${password} --local-infile=1 auction_db < trigger8_add.sql
mysql -h localhost -u root -p${password} --local-infile=1 auction_db < trigger9_add.sql
mysql -h localhost -u root -p${password} --local-infile=1 auction_db < trigger10_add.sql
