<?php
require_once "helpers/pdo.php";
require_once "helpers/get_functions.php";
session_start();

$current_time = get_cur_time($pdo_mysql);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>AuctionBase</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
</head>
<body>
  <nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
  <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">AuctionBase</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      <li><a href="currtime.php">Current Time</a></li>
      <li><a href="selecttime.php">Select a Time</a></li>
      <li><a href="search.php">Search</a></li>
      <li><a href="addbid.php">Add bid</a></li>
      </ul>
      </div>
  
  </div>
  </nav>
  
  <div class="panel panel-default">
    <div class="panel-body" style="padding:0 10% 20px 10%">
      <div id="content">
        <h3>Current Time</h3> 
        <div class="alert alert-info">
          Current time is: <?= htmlentities($current_time) ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
