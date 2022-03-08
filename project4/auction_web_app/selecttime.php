<?php
require_once "helpers/pdo.php";
require_once "helpers/get_functions.php";
session_start();

if ( isset($_POST['MM']) && isset($_POST['dd']) && isset($_POST['yyyy']) 
    && isset($_POST['HH']) && isset($_POST['mm']) && isset($_POST['ss']) ) {
      echo "here";
      // store the time before update
      $time_before = get_cur_time($pdo_mysql);

      $selected_time = to_date($_POST['MM'], $_POST['dd'], $_POST['yyyy'], 
                      $_POST['HH'], $_POST['mm'], $_POST['ss']);
      

      $sql = "UPDATE CurrentTime SET Time_t = :time_t";


      // check if the current time is updated

      try{

        $stmt = $pdo_mysql->prepare($sql);
        echo $sql, $selected_time;
        $stmt->execute(array(
          ':time_t' => $selected_time));
        echo $selected_time;
  
        $_SESSION['success'] = "Current time is successfully updated!";
      }
      catch(Exception $e){
        $_SESSION['error'] = "Current time is not updated!";
        $_SESSION['error_content'] = 'Caught exception: '.$e->getMessage()."\n";
      }

      header("Location: selecttime.php" );
      return;

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
  <h3> Select a Time </h3> 
    <form method="POST" action="selecttime.php" class="form-inline">
    <?php if ( isset($_SESSION['success']) ): ?>
      <div class="alert alert-warning"> <?= $_SESSION['success'] ?>  </div>
    <?php endif; unset($_SESSION['success']); ?>
    <?php if ( isset($_SESSION['error']) ): ?>
      <div class="alert alert-warning"> <?= $_SESSION['error'] ?>  </div>
    <?php endif; unset($_SESSION['error']); unset($_SESSION['error_content']); ?>
    <div class="alert alert-info">Please select a new time</div>
    

    <div class="form-group">
    <label for="month">Month</label>
    <select size="1" name="MM" id="month" class="form-control">
        <option selected value="01">Jan</option>
        <option value="02">Feb</option>
        <option value="03">Mar</option>
        <option value="04">Apr</option>
        <option value="05">May</option>
        <option value="06">Jun</option>
        <option value="07">Jul</option>
        <option value="08">Aug</option>
        <option value="09">Sep</option>
        <option value="10">Oct</option>
        <option value="11">Nov</option>
        <option value="12">Dec</option>
    </select>
    <label for="day">Day</label>
    <select size="1" name="dd" id="day" class="form-control">
        <option selected>01</option>
        <option>02</option>
        <option>03</option>
        <option>04</option>
        <option>05</option>
        <option>06</option>
        <option>07</option>
        <option>08</option>
        <option>09</option>
        <option>10</option>
        <option>11</option>
        <option>12</option>
        <option>13</option>
        <option>14</option>
        <option>15</option>
        <option>16</option>
        <option>17</option>
        <option>18</option>
        <option>19</option>
        <option>20</option>
        <option>21</option>
        <option>22</option>
        <option>23</option>
        <option>24</option>
        <option>25</option>
        <option>26</option>
        <option>27</option>
        <option>28</option>
        <option>29</option>
        <option>30</option>
        <option>31</option>
    </select>
    <label for="year">Year</label> <input type="text" name="yyyy" value="2013" id="year" class="form-control">
    </div>
    <br><br>
    <div class="form-group">
    <label for="hour">Hour</label>
    <select size="1" name="HH" id="hour" class="form-control">
        <option>00</option>
        <option>01</option>
        <option>02</option>
        <option>03</option>
        <option>04</option>
        <option>05</option>
        <option>06</option>
        <option>07</option>
        <option>08</option>
        <option>09</option>
        <option>10</option>
        <option>11</option>
        <option selected>12</option>
        <option>13</option>
        <option>14</option>
        <option>15</option>
        <option>16</option>
        <option>17</option>
        <option>18</option>
        <option>19</option>
        <option>20</option>
        <option>21</option>
        <option>22</option>
        <option>23</option>
    </select>
    <label for="minute">Minute</label>
    <select size="1" name="mm" id="minute" class="form-control">
        <option selected>00</option>
        <option>01</option>
        <option>02</option>
        <option>03</option>
        <option>04</option>
        <option>05</option>
        <option>06</option>
        <option>07</option>
        <option>08</option>
        <option>09</option>
        <option>10</option>
        <option>11</option>
        <option>12</option>
        <option>13</option>
        <option>14</option>
        <option>15</option>
        <option>16</option>
        <option>17</option>
        <option>18</option>
        <option>19</option>
        <option>20</option>
        <option>21</option>
        <option>22</option>
        <option>23</option>
        <option>24</option>
        <option>25</option>
        <option>26</option>
        <option>27</option>
        <option>28</option>
        <option>29</option>
        <option>30</option>
        <option>31</option>
        <option>32</option>
        <option>33</option>
        <option>34</option>
        <option>35</option>
        <option>36</option>
        <option>37</option>
        <option>38</option>
        <option>39</option>
        <option>40</option>
        <option>41</option>
        <option>42</option>
        <option>43</option>
        <option>44</option>
        <option>45</option>
        <option>46</option>
        <option>47</option>
        <option>48</option>
        <option>49</option>
        <option>50</option>
        <option>51</option>
        <option>52</option>
        <option>53</option>
        <option>54</option>
        <option>55</option>
        <option>56</option>
        <option>57</option>
        <option>58</option>
        <option>59</option>
    </select>
    <label for="second">Second </label>
    <select size="1" name="ss" id="second" class="form-control">
        <option selected>00</option>
        <option>01</option>
        <option>02</option>
        <option>03</option>
        <option>04</option>
        <option>05</option>
        <option>06</option>
        <option>07</option>
        <option>08</option>
        <option>09</option>
        <option>10</option>
        <option>11</option>
        <option>12</option>
        <option>13</option>
        <option>14</option>
        <option>15</option>
        <option>16</option>
        <option>17</option>
        <option>18</option>
        <option>19</option>
        <option>20</option>
        <option>21</option>
        <option>22</option>
        <option>23</option>
        <option>24</option>
        <option>25</option>
        <option>26</option>
        <option>27</option>
        <option>28</option>
        <option>29</option>
        <option>30</option>
        <option>31</option>
        <option>32</option>
        <option>33</option>
        <option>34</option>
        <option>35</option>
        <option>36</option>
        <option>37</option>
        <option>38</option>
        <option>39</option>
        <option>40</option>
        <option>41</option>
        <option>42</option>
        <option>43</option>
        <option>44</option>
        <option>45</option>
        <option>46</option>
        <option>47</option>
        <option>48</option>
        <option>49</option>
        <option>50</option>
        <option>51</option>
        <option>52</option>
        <option>53</option>
        <option>54</option>
        <option>55</option>
        <option>56</option>
        <option>57</option>
        <option>58</option>
        <option>59</option>
    </select>
    </div>
    <br><br>
    <div class="form-group">
    <label for="name">Please enter your name</label> <input type="text" name="entername" value="Dr. Clock" id="name" class="form-control">
    </div>
    <br><br>
    <div class="form-group">
    <input type="submit" value="Select Time" class="btn btn-primary">
    </div>
            
    </form>
  </div>
  </div></div>
</body>
</html>





