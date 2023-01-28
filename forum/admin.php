<?php
require_once "permissions.php";

$displayName = $_SESSION["displayName"];
$role = $_SESSION["role"];

// $topic = ucfirst(htmlspecialchars($_GET["topic"]));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Admin Panel
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.0.13/purify.min.js"></script>
</head>

<body>
    <nav class="navbar navbar navbar-dark bg-primary navbar-expand-lg px-4 mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="main.php">Epic Forum</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="main.php">Topics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <?php if ($role == 1)
                        echo '<li class="nav-item">
                    <a class="nav-link" href="admin.php">Admin</a>
                    </li>' ?>
                        <li class="nav-item"><a class="nav-link" href="#" id="logout">Logout</a></li>
                    </ul>
                    <span class="navbar-text">
                        Welcome
                    <?php echo $displayName ?>
                </span>
            </div>
        </div>
    </nav>

    <div id="page" class="container col-md-6 offset-3" style="display: none">
        <div class="row mb-4">
            <span>
                <h1 class="text-center">
                    Admin Panel
                </h1>
                <ul class="list-group" id="topics">
                </ul>
            </span>
        </div>

        <form id="form-create" class="text-center">
            <div class="form-floating mb-3">
                <input class="form-control" placeholder="Name" id="newName"></input>
                <label for="comment">Name</label>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Description" id="newDescription"
                    style="height: 100px"></textarea>
                <label for="comment">Description</label>
            </div>
            <button type="submit" class="btn btn-primary">
                Create new topic
            </button>
        </form>
    </div>
    <script src="./assets/pages/helper.js"></script>
    <script src="./assets/pages/logout.js"></script>
    <script src="./assets/pages/admin.js"></script>
</body>

</html>