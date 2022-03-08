<?php
require_once "helpers/pdo.php";
require_once "helpers/get_functions.php";
session_start();


if ( isset($_POST['itemID']) && isset($_POST['userID'])
     && isset($_POST['price'])) {

    // Data validation
    /*
    if ( strlen($_POST['name']) < 1 || strlen($_POST['password']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: index.php");
        return;
    }

    if ( strpos($_POST['email'],'@') === false ) {
        $_SESSION['error'] = 'Bad data';
        header("Location: add.php");
        return;
    }*/

    $current_time = get_cur_time($pdo_lite);

    $sql = "INSERT INTO Bids
              VALUES (:item_id, :user_id, :price, :time)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':item_id' => $_POST['item_id'],
        ':user_id' => $_POST['user_id'],
        ':price' => $_POST['price'],
        ':time' => $current_time));
    $_SESSION['success'] = 'Record Added';
    header( 'Location: index.php' ) ;
    return;

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row === false ) {
      $_SESSION['error'] = 'Bad value for user_id';
      header( 'Location: index.php' ) ;
      return;
}
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
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
      <li><a href="currtime">Current Time</a></li>
      <li><a href="selecttime">Select a Time</a></li>
      <li><a href="search">Search</a></li>
      <li><a href="addbid">Add bid</a></li>
      </ul>
      </div>
  
  </div>
  </nav>
  {# specify content block so that other templates can use this template as a base #}
  <div class="panel panel-default">
  <div class="panel-body" style="padding:0 10% 20px 10%">
  <div id="content">
  <style>div {text-align: center;}</style>
<h3> Add bid </h3>
<div>
	<form method="POST" action="addbid" style="max-width:400px; width:100%">
		{% if message is defined %}
		<div class="alert alert-warning">{{ message }}</div>
		{% endif %}
		<div class="alert alert-info">All fields must be input</div>
		<div class="form-group">
		<label for="itemID">Item ID</label>
		<input type="text" class="form-control" id="itemID" name="itemID" />
		</div>
		<div class="form-group">
		<label for="userID">User ID</label>
		<input type="text" name="userID" class="form-control" id="userID" />
		</div>
		<div class="form-group">
		<label for="price">Price</label>
		<input type="number" name="price" class="form-control" id="price" min="0" step="0.01" />
		</div>
		<div class="form-group"><input type="submit" value="Add bid" class="btn btn-primary"/></div>
	</form>
</div>
<h3>Result</h3>


<?php if($add_result) : ?>
	<div class="alert alert-success">Successful</div>
<?php else: ?>
    <div class="alert alert-danger">Not successful</div>
<?php endif; ?>
  </div>
  </div>
</div>
</body>
</html>
