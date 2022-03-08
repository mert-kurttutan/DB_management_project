<?php
/**/
$pdo_mysql = new PDO('mysql:host=${HOST};port=${PORT};dbname=${DATABASE NAME}', 
   'root', '${PASSWORD}');

//$pdo_lite = new PDO('sqlite:/home/mertkurttutan/Desktop/Academia/ML_DS_Statistics/Invidual_Courses/Database_Management_Systems/project4_old/auctionbase/create_auctionbase/AuctionBase.db');

// See the "errors" folder for details...
$pdo_mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



?>


