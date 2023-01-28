<?php
require_once "permissions.php";

$user = $_SESSION["user"];
$userid = $_SESSION["userid"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bank</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/custom.css">

    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Bank</a>
            </div>
            <ul class="nav navbar-nav" style="float: right">
                <li><a href="#" id="logout">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row" id="page" hidden>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading container-fluid">
                        <span class="col-md-6">Account Info</span>
                        <a href="profile.php" class="col-md-offset-3 col-md-2">Profile</a>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p>
                                    <kbd>username:</kbd>
                                    <span style="float:right;">
                                        <?php echo htmlentities(strip_tags($user), ENT_QUOTES, "UTF-8"); ?>
                                    </span>
                                </p>
                            </li>
                            <li class="list-group-item">
                                <p>
                                    <kbd>ip address</kbd>
                                    <span style="float:right;">
                                        <?php echo $_SERVER["REMOTE_ADDR"]; ?>
                                    </span>
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Transactions History
                    </div>
                    <div class="panel-body">
                        <ul class="list-group" id="transaction_history">
                        </ul>
                    </div>
                </div>
                <form id="form" class="col-md-offset-4 col-md-4 mb-4">
                    <div id="error" class="text-danger mb-2"></div>
                    <input id="user_to_name" class="form-control mb-2" name="user_to_name" type="text"
                        placeholder="Recipient Name" required>
                    <input class="form-control mb-2" id="amount" type="number" min="1" name="amount"
                        placeholder="Amount" class="form-control" required>
                    <button id="send_transaction" type="submit" class="btn btn-primary btn-block">Send</button>
                </form>
            </div>
        </div>
    </div>
    <script src="./assets/pages/helper.js"></script>
    <script src="./assets/pages/main.js"></script>
</body>

</html>