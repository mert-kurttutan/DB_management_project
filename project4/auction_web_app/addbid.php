<?php
require_once "helpers/pdo.php";
require_once "helpers/get_functions.php";
session_start();

// if they are not set, assign null values
$item_id = isset($_SESSION['item_id']) ? $_SESSION['item_id'] : '';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$price = isset($_SESSION['price'])  ? $_SESSION['price'] : 0;



if ( isset($_POST['item_id']) && isset($_POST['user_id'])
     && isset($_POST['price'])) {

    // store these in the session so they reappear after submitting
    $_SESSION['item_id'] = $_POST['item_id'];
    $_SESSION['user_id'] = $_POST['user_id'];
    $_SESSION['price'] = $_POST['price'];

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

    $current_time = get_cur_time($pdo_mysql);

    $sql = "INSERT INTO Bids
              VALUES (:item_id, :user_id, :price, :time)";

    $stmt = $pdo_mysql->prepare($sql);

    echo "here";
    // Catch the error since this might also be due to triggering
    try {
        $stmt->execute(array(
            ':item_id' => $_SESSION['item_id'],
            ':user_id' => $_SESSION['user_id'],
            ':price' => $_SESSION['price'],
            ':time' => $current_time));
        $_SESSION['success'] = 'Record Added';
        header( 'Location: addbid.php' ) ;
        return;
    } catch (Exception $e) {
        $error_str =  'Caught exception: '.$e->getMessage()."\n";
        $_SESSION['error'] = $error_str;
        header( 'Location: addbid.php' ) ;
        return;
    }
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row === false && false ) {
      $_SESSION['error'] = 'An incorrect type of bid'. $stmt->num_rows;
      header( 'Location: index.php' ) ;
      return;
    }
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <link rel="stylesheet" href="CSS/main.css">
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
                <style>div {text-align: center;}</style>
                <h3> Add bid </h3>
                <div>
                    <form method="POST" class="addbid_form">
                        <?php if($message) : ?>
                        <div class="alert alert-warning"><?php echo($message);?></div>
                        <?php endif;?>
                        <div class="alert alert-info">All fields must be input</div>
                        <div class="form-group">
                            <label for="item_id">Item ID</label>
                            <input type="text" class="form-control" id="item_id" name="item_id" 
                            <?php echo 'value="' . htmlentities($item_id) . '"';?>/>
                        </div>
                        <div class="form-group">
                            <label for="user_id">User ID</label>
                            <input type="text" name="user_id" class="form-control" id="user_id" 
                            <?php echo 'value="' . htmlentities($user_id) . '"';?>/>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" class="form-control" id="price" min="0" step="0.01" 
                            <?php echo 'value="' . htmlentities($price) . '"';?>/>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Add bid" class="btn btn-primary"/>
                        </div>
                    </form>
                </div>
                <h3>Result</h3>
                <?php

                if ( isset($_SESSION['error']) ) {
                    echo '<div class="error_frame"> <p>'.
                            $_SESSION['error']."</p></div>\n";
                    unset($_SESSION['error']);
                }
                if ( isset($_SESSION['success']) ) {
                    echo '<div class="success_frame"> <p>'.
                            $_SESSION['success']."</p></div>\n";
                    unset($_SESSION['success']);
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
