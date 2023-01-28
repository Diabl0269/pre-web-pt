<?php
require_once './DatabaseInterface.php';

$databaseObj = new DatabaseInterface();

/* Start session if none */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/* Check if the user already logged in */
if (isset($_SESSION["user"])) {
    Header("Location: ./main.php");
}

$error_message = null;
$success_message = null;

if (isset($_POST['r_password']) && isset($_POST['r_username']) && isset($_POST['displayName'])) {
    $password = $_POST['r_password'];
    $username = $_POST['r_username'];
    $displayName = $_POST['displayName'];
    $return_array = $databaseObj->Register($username, $password, $displayName);

    if ($return_array["success"] == false) {
        $error_message = $return_array["data"];
    } else {
        $success_message = $return_array["data"];
    }

} else if (isset($_POST['l_password']) && isset($_POST['l_username'])) {
    $password = $_POST['l_password'];
    $username = $_POST['l_username'];

    $return_array = $databaseObj->Login($username, $password);

    if ($return_array["success"] == false) {
        $error_message = $return_array["data"];
    } else {
        /* set session */
        $_SESSION["user"] = $return_array["data"]["username"];
        $_SESSION["userid"] = $return_array["data"]["id"];
        $_SESSION["displayName"] = $return_array["data"]["displayName"];
        $_SESSION["role"] = $return_array["data"]["role"];

        /* set cookie */
        die(Header("Location: ./main.php"));
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login/Regsiter</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h1 class="text-center my-4">Forum</h1>
        <div class="col-4 offset-4">

            <div id="login-panel">
                <form action="#" method="POST">
                    <div class="form-floating">
                        <input id="l_username" type="text" class="form-control" name="l_username"
                            placeholder="Username">
                        <label for="l_username">Username</label>
                    </div>
                    <br>
                    <div class="form-floating">
                        <input id="l_password" type="password" class="form-control" name="l_password"
                            placeholder="Password">
                        <label for="l_password">Password</label>
                    </div>
                    <br>
                    <div class="d-flex justify-content-around mb-4">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                        <a href="#" id="register" class="my-2 flex"><i
                                class="glyphicon glyphicon-info-sign"></i>Register</a>
                    </div>
                    <?php
                    if (isset($error_message)) {
                        echo "<div class='alert alert-danger'><strong>Error: </strong>" . $error_message . "</div>";
                    } else if (isset($success_message)) {
                        echo "<div class='alert alert-success'><strong>Note: </strong>" . $success_message . "</div>";
                    }
                    ?>
                </form>
            </div>
            <form action="#" method="POST">
                <div id="register-panel" style="display: none">
                    <div class="form-floating">
                        <input id="r_username" type="text" class="form-control" name="r_username"
                            placeholder="Username">
                        <label for="r_username">Username</label>
                    </div>
                    <br>
                    <div class="form-floating"">
                            <input id=" r_password" type="password" class="form-control" name="r_password"
                        placeholder="Password">
                        <label for="r_password">Password</label>
                    </div>
                    <br>
                    <div class="form-floating"">
                            <input id=" displayName" type="text" class="form-control" name="displayName"
                        placeholder="Display Name">
                        <label for="displayName">Display Name</label>
                    </div>
                    <br>
                    <div class="d-flex justify-content-around">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                        <a href="#" id="login" class="my-2 flex"><i class="glyphicon glyphicon-info-sign"></i>Login</a>
                    </div>
            </form>
        </div>
    </div>
    <script src="./assets/pages/index.js"></script>
</body>

</html>