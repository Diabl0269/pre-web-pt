<?php
require_once "permissions.php";

$user = $_SESSION["user"];
$userid = $_SESSION["userid"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bank - Profile</title>
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
                        <a href="main.php" class="col-md-offset-3 col-md-2">Main</a>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p>
                                    <kbd>username:</kbd>
                                    <span id="name" style="float:right;">
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
                        Profile
                    </div>
                    <div class="panel-body">
                        <form id="form" class="col-md-offset-4 col-md-4 my-2">
                            <div id="helper" class="text-danger mb-2"></div>
                            <input id="username" class="form-control mb-2" name="username" type="text"
                                placeholder="Username" required value="<?php echo $user ?>">
                            <input class="form-control mb-2" id="password" type="password" name="password"
                                placeholder="Password" class="form-control">
                            <button id="update_profile" type="submit" class="btn btn-primary btn-block">Update
                                Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/pages/helper.js"></script>
    <script src="./assets/pages/main.js"></script>
    <script src="./assets/pages/profile.js"></script>
</body>

</html>