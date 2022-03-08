<?php

require_once "helpers/pdo.php";
require_once "helpers/get_functions.php";
session_start();

// form the query string based on several desired features
$query_main_item = " SELECT * FROM Items ";


// WHERE Clause
$query_where = " WHERE ";


// ITEM TABLE
// form this dict to be used in the following
$where_dict_item = array($_GET['item_id'] => " Items.ItemID = :item_id ");

$where_clause_item = seach_where_clause($where_dict_item);

$param_dict_item = array(':item_id' => $_GET['item_id']);

filter_dict($param_dict_item);

// define the final string for query
if (count($param_dict_item) == 0){
  $query_final_item = $query_main_item;
}
else{
  $query_final_item = $query_main_item. $query_where. $where_clause_item;
}

$_SESSION['query_final_item'] = $query_final_item;
$_SESSION['param_dict_item'] = $param_dict_item;
$_SESSION['field_names_item'] = get_column_names($pdo_mysql, 'Items');


// BIDS TABLE
// form this dict to be used in the following

$query_main_bid = " SELECT * FROM Bids ";
$where_dict_bid = array($_GET['item_id'] => " Bids.ItemID = :item_id ");

$where_clause_bid = seach_where_clause($where_dict_bid);

$param_dict_bid = array(':item_id' => $_GET['item_id']);

filter_dict($param_dict_bid);

// define the final string for query
if (count($param_dict_bid) == 0){
  $query_final_bid = $query_main_bid;
}
else{
  $query_final_bid = $query_main_bid. $query_where. $where_clause_bid;
}

$_SESSION['query_final_bid'] = $query_final_bid;
$_SESSION['param_dict_bid'] = $param_dict_bid;
$_SESSION['field_names_bid'] = get_column_names($pdo_mysql, 'Bids');



// Categories TABLE
// form this dict to be used in the following

$query_main_category = " SELECT * FROM Categories ";
$where_dict_category = array($_GET['item_id'] => " Categories.ItemID = :item_id ");

$where_clause_category = seach_where_clause($where_dict_category);

$param_dict_category = array(':item_id' => $_GET['item_id']);

filter_dict($param_dict_category);

// define the final string for query
if (count($param_dict_category) == 0){
  $query_final_category = $query_main_category;
}
else{
  $query_final_category = $query_main_category. $query_where. $where_clause_category;
}

$_SESSION['query_final_category'] = $query_final_category;
$_SESSION['param_dict_category'] = $param_dict_category;
$_SESSION['field_names_category'] = get_column_names($pdo_mysql, 'Categories');

// Status TABLE
// form this dict to be used in the following

$query_main_status = " SELECT * FROM Status ";
$where_dict_status = array($_GET['item_id'] => " Status.ItemID = :item_id ");

$where_clause_status = seach_where_clause($where_dict_status);

$param_dict_status = array(':item_id' => $_GET['item_id']);

filter_dict($param_dict_status);

// define the final string for query
if (count($param_dict_status) == 0){
  $query_final_bid = $query_main_bid;
}
else{
  $query_final_status = $query_main_status. $query_where. $where_clause_status;
}

$_SESSION['query_final_status'] = $query_final_status;
$_SESSION['param_dict_status'] = $param_dict_bid;
$_SESSION['field_names_status'] = get_column_names($pdo_mysql, 'Status');


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>AuctionBase</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/main.css">
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

  <?php if (!isset($_GET['item_id'])): ?>
  <div class="redirect_frame">
    Please provide an auction item to inspect, <a href="search.php"> here </a>
  </div>

  <?php else: ?>
  <div class="panel panel-default">
  <div class="panel-body" style="padding:0 10% 20px 10%">
  <div id="content">
    <div class="items_table">
        <h2>Item Table</h2>
        <table class="styled-table">
          <thead>
            <tr>
              <?php
              foreach ($_SESSION['field_names_item'] as $value){
                echo '<th>', $value, '</th>';
              }
              ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $stmt = $pdo_mysql->prepare($_SESSION['query_final_item']);
            $stmt->execute($_SESSION['param_dict_item']);

            while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
              echo "<tr>";
              foreach($row as $value){
                echo "<td>", htmlentities($value), "</td>";
              }
            }
              echo "</tr>\n";
            unset($_SESSION['query_final_item']); 
            ?>
          </tbody>
        </table>
    </div>

    <div class="bids_table">
        <h2>Bids Table</h2>
        <table class="styled-table">
          <thead>
            <tr>
              <?php
              foreach ($_SESSION['field_names_bid'] as $value){
                echo '<th>', $value, '</th>';
              }
              ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $stmt = $pdo_mysql->prepare($_SESSION['query_final_bid']);
            $stmt->execute($_SESSION['param_dict_bid']);

            while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
              echo "<tr>";
              foreach($row as $value){
                echo "<td>", htmlentities($value), "</td>";
              }
            }
              echo "</tr>\n";
            unset($_SESSION['query_final_bid']); 
            ?>
          </tbody>
        </table>
    </div>

    <div class="categories_table">
        <h2>Categories Table</h2>
        <table class="styled-table">
          <thead>
            <tr>
              <?php
              foreach ($_SESSION['field_names_category'] as $value){
                echo '<th>', $value, '</th>';
              }
              ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $stmt = $pdo_mysql->prepare($_SESSION['query_final_category']);
            $stmt->execute($_SESSION['param_dict_category']);

            while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
              echo "<tr>";
              foreach($row as $value){
                echo "<td>", htmlentities($value), "</td>";
              }
            }
              echo "</tr>\n";
            unset($_SESSION['query_final_category']); 
            ?>
          </tbody>
        </table>
    </div>

    <div class="status_table">
        <h2>Bids Table</h2>
        <table class="styled-table">
          <thead>
            <tr>
              <?php
              foreach ($_SESSION['field_names_status'] as $value){
                echo '<th>', $value, '</th>';
              }
              ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $stmt = $pdo_mysql->prepare($_SESSION['query_final_status']);
            $stmt->execute($_SESSION['param_dict_status']);

            while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
              echo "<tr>";
              foreach($row as $value){
                echo "<td>", htmlentities($value), "</td>";
              }
            }
              echo "</tr>\n";
            unset($_SESSION['query_final_status']); 
            ?>
          </tbody>
        </table>
    </div>

  <?php endif; ?>
</div>
  </div></div>
</body>
</html>
