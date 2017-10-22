<?php
session_start();

if ( ! isset( $_SESSION['username'] ) || ! isset( $_SESSION['account_id'] ) || ! isset( $_SESSION['IBAN'] ) || ! isset( $_SESSION['user_id'] ) )
{
    header("Location: index.php");
}

// If it's ok
else
{
    $delete_flag = 0;

    // Create a database connection
    $conn = new mysqli('localhost',
        'root',
        '123456789',
        'energy_wallet');

    if ($conn->connect_error)
    {
        die("<b>Connection failed</b>: " . $conn->connect_error);
    }

    if ( isset( $_POST['add_submit'] ) )
    {
        $query = "";

        if ( isset( $_POST['buyer_radio'] ) && isset( $_POST['price'] ) && isset( $_POST['volume'] ) )
        {
            $query .= "SELECT ORDERS.id as order_id ";
            $query .= "FROM USERS, ORDERS WHERE USERS.id = ORDERS.user_id and side='S' and ORDERS.volume =";
            $query .= $_POST['volume'] . " and ORDERS.price = " . $_POST['price'];

            $found = mysqli_query($conn, $query);

            if ( $found )
            {
                $row = mysqli_fetch_array($found);
                $del_q = "DELETE FROM energy_wallet.ORDERS WHERE id = " . $row["order_id"] ;

                $result = mysqli_query($conn, $del_q);
                $delete_flag = 1;
            }

            else
            {
                $query .= "INSERT INTO energy_wallet.ORDERS (user_id, price, volume, side) VALUES (";
                $query .= $_SESSION['user_id'] . "," . $_POST['price'] . "," . $_POST['volume'] . "," . "'B' ) ;";

                mysqli_query($conn, $query);
            }


        }

        if ( isset( $_POST['seller_radio'] ) && isset( $_POST['price'] ) && isset( $_POST['volume'] ) )
        {
//            $query .= "SELECT ORDERS.id as order_id, ORDERS.user_id, ORDERS.price, ORDERS.volume, ORDERS.side ";
//            $query .= "FROM USERS, ORDERS WHERE USERS.id = ORDERS.user_id and side='B' and ORDERS.volume =";
//            $query .= $_POST['volume'] . " and ORDERS.price = " . $_POST['price'];
//
//            $found = mysqli_query($conn, $query);
//
//            if ( ! $found )
//            {
                $query .= "INSERT INTO energy_wallet.ORDERS (user_id, price, volume, side) VALUES (";
                $query .= $_SESSION['user_id'] . "," . $_POST['price'] . "," . $_POST['volume'] . "," . "'S' ) ;";

                mysqli_query($conn, $query);
//            }

        }


    }

}


if ( isset($_GET['logout']) )
{
    if ( $_GET['logout'] == 'yes' )
    {
        unset($_SESSION['username']);
        unset($_SESSION['account_id']);
        unset($_SESSION['IBAN']);
        unset($_SESSION['user_id']);
        header("Location: index.php");
    }
}

?>


<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Trading - Common River</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/myStyle.css" />
    <link rel="icon" type="image/png" href="ico.png">


    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">

  </head>

  <body>


    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Common River Platform</a>
        <?php
        if ( isset( $_SESSION['username'] ) )
            echo "<p class=username> Hello " . $_SESSION['username'] . " (<a href=\"/trading.php?logout=yes\" title=\"Logout\">logout</a>)</p>" ;
        ?>
    </nav>

    <br><br>

<!--    <div class="alert alert-success" role="alert"> Συγχαρητήρια η συναλλαγή σας ολοκληρώθηκε! </div>-->
<!--    <h3 class="text-success fa-align-center">Συγχαρητήρια η συναλλαγή σας ολοκληρώθηκε!</h3>-->

    <div class="container">
        <div class="text-center text-success">
            <?php
            if ( $delete_flag == 1 )
            {
                echo "<h3>Συγχαρητήρια η συναλλαγή σας ολοκληρώθηκε!</h3>";
                echo "<h4>Έγινε η πληρωμή μέσω τραπέζης και ενημερώθηκε ο διαχειριστής δικτύου.</h4>";
            }
            ?>

        </div>
      <div class="row">
        <div class="col">

          <table class="table table-sm table-dark">
              <thead>
              <tr>
                  <th>
                      Producers
                  </th>
              </tr>
              </thead>
            <thead>
              <tr>
                <th scope="col">Seller</th>
                <th scope="col">Want</th>
                <th scope="col">Price per KWH</th>
              </tr>
            </thead>
            <tbody>

            <tbody>
              <?php
                    $sql = "SELECT USERS.username, ORDERS.price, ORDERS.volume, ORDERS.side FROM USERS, ORDERS WHERE ";
                    $sql .= "USERS.id = ORDERS.user_id and side='S' order by price DESC";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0)
                    {
                        while ($row = $result->fetch_assoc())
                        {
                            echo '<tr class="bg-success">';
                                echo '<td>' . $row["username"] . '</td>';
                                echo '<td>' . $row["volume"] . ' kwh</td>';
                                echo '<td>' . $row["price"] . ' € /kwh</td>';
                            echo '</tr>';
                        }

                    }
              ?>
<!--              Sample data-->
<!--              <tr class="bg-success">-->
<!--                <td>Maya Andreou</td>-->
<!--                <td>0 kwh</td>-->
<!--                <td>0,005€/kwh</td>-->
<!--              </tr>-->
<!--              <tr class="bg-success">-->
<!--                <td>Tasos Lisgaras</td>-->
<!--                <td>30 kwh</td>-->
<!--                <td>0,009€/kwh</td>-->
<!--              </tr>-->
<!--              <tr class="bg-success">-->
<!--                <td>Georgios Karamanolis</td>-->
<!--                <td>78 kwh</td>-->
<!--                <td>0,01€/kwh</td>-->
<!--              </tr>-->
<!--              <tr class="bg-success">-->
<!--                <td>Vasilis Plavos</td>-->
<!--                <td>100 kwh</td>-->
<!--                <td>0,09€/kwh</td>-->
<!--              </tr>-->
            </tbody>
          </table>
        </div>


        <div class="col">
          <table class="table table-sm table-dark">
              <thead>
              <tr>
                  <th>
                      Consumers
                  </th>
              </tr>
              </thead>
            <thead>
              <tr>
                <th>Buyer</th>
                <th>Storage</th>
                <th>Price per KWH</th>
              </tr>
            </thead>
            <tbody>
            <?php
                $sql = "SELECT USERS.username, ORDERS.price, ORDERS.volume, ORDERS.side FROM USERS, ORDERS WHERE ";
                $sql .= "USERS.id = ORDERS.user_id and side='B' order by price DESC";

                $result = $conn->query($sql);

                if ($result->num_rows > 0)
                {
                    while ($row = $result->fetch_assoc())
                    {
                        echo '<tr class="bg-danger">';
                        echo '<td>' . $row["username"] . '</td>';
                        echo '<td>' . $row["volume"] . ' kwh</td>';
                        echo '<td>' . $row["price"] . ' € /kwh</td>';
                        echo '</tr>';
                    }

                }
            ?>
<!--                Sample data -->
<!--              <tr class="bg-danger">-->
<!--                <td>Jeff Bezos</td>-->
<!--                <td>1.000.000 kwh</td>-->
<!--                <td>0,005€/kwh</td>-->
<!--              </tr>-->
<!--              <tr class="bg-danger">-->
<!--                <td>Mrs Maria</td>-->
<!--                <td>100 kwh</td>-->
<!--                <td>0,006€/kwh</td>-->
<!--              </tr>-->
<!--              <tr class="bg-danger">-->
<!--                <td>GREEN</td>-->
<!--                <td>1.000.000 kwh</td>-->
<!--                <td>0,005€/kwh</td>-->
<!--              </tr>-->

            </tbody>
          </table>
        </div>
      </div>
    </div>   

    <br><br>

    <aside class="call-to-action bg-primary text-white">
      <div class="container text-center">
          <?php

          $url = "https://monitoringapi.solaredge.com/site/12663/overview?api_key=3M02E1TOQF4ACXQCL6IKNUYO226R4768";

          $ch = curl_init();
          $timeout = 5;
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
          $data = curl_exec($ch);
          curl_close($ch);

          $manage = (array) json_decode($data, true);

//          var_dump($manage);
//          var_dump( $manage["overview"] ) ;
//          var_dump( $manage["overview"]["lastDayData"]["energy"] ) ;

//                      $manage["overview"]["lastDayData"]["energy"]/1000
          ?>
        <h4>Your last day kWh <?php echo '<span><b>' . $manage["overview"]["lastDayData"]["energy"]/1000 . '</b></span>' ?></h4>
        <h3>Hi! What do you want to do?</h3>

<form method="post" action="">
    <div class="form-row align-items-center">

        <div class="col-auto">
            <div class="form-check mb-2 mb-sm-0">
                <label class="custom-control custom-radio">
                    <input id="radio1" name="buyer_radio" type="radio" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">I Want to Buy</span>
                </label>

                <label class="custom-control custom-radio">
                    <input id="radio2" name="seller_radio" type="radio" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">I Want to Sell</span>
                </label>
            </div>
        </div>



        <div class="col-auto">
            <label class="sr-only" for="inlineFormInput">Price per KWH</label>
            <input type="text" class="form-control mb-2 mb-sm-0" id="inlineFormInput" placeholder="Price" name="price">
        </div>

        <div class="col-auto">
            <label class="sr-only" for="inlineFormInputGroup">KWH</label>
            <div class="input-group mb-2 mb-sm-0">
            <div class="input-group-addon">KWH</div>
            <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="KWH" name="volume">
            </div>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-light" name="add_submit">Submit</button>
        </div>
    </div>
</form>



      </div>
    </aside>


    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-lg-10 mx-auto text-center">
            <h4>
              <strong>Start Bootstrap</strong>
            </h4>
            <p>3481 Melrose Place
              <br>Beverly Hills, CA 90210</p>
            <ul class="list-unstyled">
              <li>
                <i class="fa fa-phone fa-fw"></i>
                (123) 456-7890</li>
              <li>
                <i class="fa fa-envelope-o fa-fw"></i>
                <a href="mailto:name@example.com">name@example.com</a>
              </li>
            </ul>
            <br>
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-facebook fa-fw fa-3x"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-twitter fa-fw fa-3x"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-dribbble fa-fw fa-3x"></i>
                </a>
              </li>
            </ul>
            <hr class="small">
            <p class="text-muted">Copyright &copy; Your Website 2017</p>
          </div>
        </div>
      </div>
      <a id="to-top" href="#top" class="btn btn-dark btn-lg js-scroll-trigger">
        <i class="fa fa-chevron-up fa-fw fa-1x"></i>
      </a>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/stylish-portfolio.js"></script>

    <?php
    $conn->close();
    ?>
  </body>

</html>
