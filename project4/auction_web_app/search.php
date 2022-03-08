<?php
require_once "helpers/pdo.php";
require_once "helpers/get_functions.php";
session_start();

// if they are not set, assign null values
$item_id = isset($_SESSION['item_id']) ? $_SESSION['item_id'] : '';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$min_price = isset($_SESSION['min_price'])  ? $_SESSION['min_price'] : '';
$max_price = isset($_SESSION['max_price'])  ? $_SESSION['max_price'] : '';
$category = isset($_SESSION['category'])  ? $_SESSION['category'] : '';
$status =  isset($_SESSION['status']) ? $_SESSION['status'] : '';
$description = isset($_SESSION['description'])  ? $_SESSION['description'] : '';


if ( isset($_POST['searched']) ) {
    /*
    // Data validation
    // require make is not empty
    if ( (strlen($_POST["make"]) < 1) || (strlen($_POST["year"]) < 1) || 
            (strlen($_POST["mileage"]) < 1) || (strlen($_POST["model"]) < 1) ){
        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
        return;
    }
    // require mileage and year are numeric
    if (!is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) ){
        $_SESSION['error'] = "Mileage and year must be numeric";
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
        return;
    }*/


    $_SESSION['item_id'] = isset($_POST['item_id']) ? $_POST['item_id'] : '';
    $_SESSION['user_id'] = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $_SESSION['min_price'] = isset($_POST['min_price'])  ? $_POST['min_price'] : '';
    $_SESSION['max_price'] = isset($_POST['max_price'])  ? $_POST['max_price'] : '';
    $_SESSION['category'] = isset($_POST['category'])  ? $_POST['category'] : '';
    $_SESSION['status'] =  (isset($_POST['status']) && $_POST['status'] != "all") ? $_POST['status'] : '';
    $_SESSION['description'] = isset($_POST['description']) ? '%'.$_POST['description'].'%' : '';

    // form the query string based on several desired features
    $query_main = " SELECT Items.ItemID, Items.Name, Items.Currently, Items.Started, Items.Ends".
                    " FROM Items JOIN Categories JOIN Status ".
                    " ON Items.ItemID = Categories.ItemID ". 
                    " AND Categories.ItemID = Status.ItemID ";


    // WHERE Clause
    $query_where = " WHERE ";

    // form this dict to be used in the following
    $where_dict = array($_SESSION['item_id'] => " Items.ItemID =:item_id ",
                        $_SESSION['category'] => " Categories.Category= :category ",
                        $_SESSION['min_price'] => " :min_price < Items.Currently ",
                        $_SESSION['max_price'] => " :max_price > Items.Currently ",
                        $_SESSION['status'] => " Status.cur_state = :status  ",
                        $_SESSION['description'] => " Items.Description LIKE :description ");



    $where_clause = seach_where_clause($where_dict);
    
    $param_dict = array(':item_id' => $_SESSION['item_id'],
                        ':category' => $_SESSION['category'],
                        ':min_price' => $_SESSION['min_price'],
                        ':max_price' => $_SESSION['max_price'],
                        ':status' => $_SESSION['status'],
                        ':description' => $_SESSION['description']);
    
    filter_dict($param_dict);

    // define the final string for query
    if (count($param_dict) == 0){
        $query_final = $query_main;
    }
    else{
        $query_final = $query_main. $query_where. $where_clause;
    }
    $_SESSION['query_final'] = $query_final;
    $_SESSION['param_dict'] = $param_dict;
    header( "Location: search.php");
    return;

}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>AuctionBase</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/main.css">
    <script type="text/javascript">
    $(window).scroll(function ()
    {
	  if($(document).height() <= $(window).scrollTop() + $(window).height())
	  {
		loadmore();
	  }
    });

    function loadmore()
    {
      var val = document.getElementById("row_no").value;
      $.ajax({
      type: 'post',
      url: 'get_results.php',
      data: {
       getresult:val
      },
      success: function (response) {
	  var content = document.getElementById("all_rows");
      content.innerHTML = content.innerHTML+response;

      // We increase the value by 10 because we limit the results by 10
      document.getElementById("row_no").value = Number(val)+10;
      }
      });
    }
</script>
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
        <a class="navbar-brand" href="auctionDB.php">AuctionBase</a>
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
        <h3> Search </h3> 
        
        <form method="POST" action="search.php" role="form" style="max-width:400px; width:100%">
          <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-warning" role="alert"><?= $_SESSION['error'] ?></div>
          <?php endif; ?>
          <div class="alert alert-info">Anything not input will not be taken into account</div>
          <div class="form-group">
            <label for="user_id">User ID</label>
            <input type="text" name="user_id" class="form-control" id="user_id" />
          </div>
          <div class="form-group">
            <label for="item_id">Item ID</label>
            <input type="text" class="form-control" id="item_id" name="item_id" />
          </div>
          <div class="form-group">
            <label for="category">Category</label>
            <input type="text" name="category" class="form-control" id="category" />
          </div>
          <div class="form-group">
            <label for="min_price">Min Price</label>
            <input type="text" name="min_price" class="form-control" id="min_price" />
          </div>
          <div class="form-group">
            <label for="max_price">Max Price</label>
            <input type="text" name="max_price" class="form-control" id="max_price" />
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" class="form-control" id="description" />
          </div>
          <div class="form-group">
            <label for="status">Status &nbsp;&nbsp;</label>
            <div class="radio-inline"><label><input type="radio" name="status" value="open">Open</label></div>
            <div class="radio-inline"><label><input type="radio" name="status" value="close">Close</label></div>
            <div class="radio-inline"><label><input type="radio" name="status" value="notStarted">Not Started</label></div>
            <div class="radio-inline"><label><input type="radio" name="status" value="all" checked>All</label></div>
          </div>
          <div><input type="submit" name="searched" value="Start Searching!" class="btn btn-primary" /></div>
        </form>
        <h3>Result</h3>

        <?php if (isset($_SESSION['query_final'])): ?>

        <h1>Automobiles</h1>
        <table class="styled-table">
          <thead>
            <tr>
              <th> Item ID </th><th> Name </th> <th>Started</th> <th> Ends </th> <th> Currently </th> <th>Link</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $stmt = $pdo_mysql->prepare($_SESSION['query_final']);
            $stmt->execute($_SESSION['param_dict']);
            while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                echo "<tr><td>";
                echo(htmlentities($row['ItemID']));
                echo("</td><td>");
                echo(htmlentities($row['Name']));
                echo("</td><td>");
                echo(htmlentities($row['Started']));
                echo("</td><td>");
                echo(htmlentities($row['Ends']));
                echo("</td><td>");
                echo(htmlentities($row['Currently']));
                echo("</td><td>");
                echo('<a href="inspect_item.php?item_id='.$row['ItemID'].'">See</a>');
                echo("</td></tr>\n");
            }
            unset($_SESSION['query_final']); 
            ?>
          </tbody>
        </table>
        <?php endif;?>
      </div>
    </div>
  </div>
</body>
</html>
