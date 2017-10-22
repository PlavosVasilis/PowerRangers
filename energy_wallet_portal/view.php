<?php
session_start();

if ( ! isset( $_SESSION['username'] ) || ! isset( $_SESSION['account_id'] ) || ! isset( $_SESSION['IBAN'] ) )
{
    header("Location: index.php");
}

if ( isset($_GET['logout']) )
{
    if ( $_GET['logout'] == 'yes' )
    {
        unset($_SESSION['username']);
        unset($_SESSION['account_id']);
        unset($_SESSION['IBAN']);
        header("Location: index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Book</title>
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="css/myStyle.css" />
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

    <div class="container">

        <?php
            if ( isset( $_SESSION['username'] ) )
                echo "<p class=username> Hello " . $_SESSION['username'] . " (<a href=\"/view.php?logout=yes\" title=\"Logout\">logout</a>)</p>" ;
        ?>

        <h1 class="text-center myTitle">Order Book</h1>

        <table class="table table-hover table-inverse table-striped">
            <thead>
                <tr>
                    <th>Buyer</th>
                    <th>Value</th>
                    <th>Seller</th>
                </tr>
            </thead>
            <tbody>

            <!-- Buyers -->
            <tr class="bg-danger">
                <th scope="row"></th>
                <td>$ 13</td>
                <td>4 kWh</td>
            </tr>
            <tr class="bg-danger">
                <th scope="row"></th>
                <td>$ 15</td>
                <td>18 kWh</td>
            </tr>
            <tr class="bg-danger">
                <th scope="row"></th>
                <td>$ 30</td>
                <td>80 kWh</td>
            </tr>
            <tr class="bg-danger">
                <th scope="row"></th>
                <td>$ 15</td>
                <td>18 kWh</td>
            </tr>

            <!-- The current value-->
            <tr class="bg-success success">
                <th scope="col"> </th>
                <th scope="col"> $ 10</th>
                <th scope="col"></th>
            </tr>

            <!-- Sellers -->
            <tr class="bg-primary">
                <td scope="row">80 kWh</td>
                <td>$ 30</td>
                <td> </td>
            </tr>

            <tr class="bg-primary">
                <td scope="row">10 kWh</td>
                <td>$ 5</td>
                <td> </td>
            </tr>

            <tr class="bg-primary">
                <td scope="row">23 kWh</td>
                <td>$ 14</td>
                <td> </td>
            </tr>
            <tr class="bg-primary">
                <td scope="row">80 kWh</td>
                <td>$ 30</td>
                <td> </td>
            </tr>

            </tbody>
        </table>





    </div>

</body>
</html>