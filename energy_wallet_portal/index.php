<?php
session_start();


if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) )
{
    // Create a database connection
    $conn = new mysqli('localhost',
        'root',
        '123456789',
        'energy_wallet');

    if ($conn->connect_error)
    {
        die("<b>Connection failed</b>: " . $conn->connect_error);
    }
    else
    {
        $sql = "SELECT id, username, password, account_id, IBAN FROM USERS WHERE username='" . $_POST['username'] . "'";
        $sql .= "and password='" . $_POST['password'] . "'";
        $result = $conn->query($sql);

        // User credentials are valid.
        if ($result->num_rows > 0)
        {
            while( $row = $result->fetch_assoc() )
            {
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["account_id"] = $row["account_id"];
                $_SESSION["IBAN"] = $row["IBAN"];
            }

            print_r($_SESSION);
            header("Location: trading.php");
        }
        else
        {
            echo "<b>Your credentials are invalid</b>";
            header("Location: index.php");
        }

        $conn->close();

    }


}
else
{
    echo "No POST request";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Energy Wallet</title>
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="css/sign_in.css" />
    <link type="text/css" rel="stylesheet" href="css/login-style.css" />
</head>
<body>

<div class="container">
    <form class="form-signin" method="post" action="trading.php">

        <h2 class="form-signin-heading my_head">Please login in</h2>

        <label class="sr-only" for="inputEmail">Email address</label>
        <input id="inputEmail" class="form-control" placeholder="Username" required="" autofocus="" name="username">
        <label class="sr-only" for="inputPassword">Password</label>
        <input id="inputPassword" class="form-control" placeholder="Password" required="" type="password" name="password">

        <button class="btn btn-lg btn-primary btn-block my_btn" type="submit" name="submit">Login in</button>

    </form>
</div>

</body>
</html>