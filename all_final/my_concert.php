<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500;700&family=Mohave:wght@700&display=swap"
        rel="stylesheet">

    <!-- bootstrap link and script -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <!-- add style -->
    <style>
        * {
            font-family: 'Dosis', sans-serif;
            font-weight: 700;
        }

        .navbar-brand {
            font-family: 'Mohave', sans-serif;
        }

        .container-fluid {
            color: white;
        }

        .nav-link:hover {
            color: white;
            font-weight: bolder;
        }

        .btn-light {
            background-color: #C2D9FF;
            border-color: #C2D9FF;
        }

        .btn-outline-danger {
            color: white;
            border-color: white;
        }

        .card-text {
            max-width: 50ch;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .card {
            margin: auto;
        }
    </style>

</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-md sticky-top shadow p-2 mb-5 " style="background-color : #0097B2">
        <div class="container-fluid">
            <a class="navbar-brand" href="index_user.php">
                <img src="upload/logo/TICKCON.png" alt="Logo" width="150px" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 p-1 ms-0 ps-0">
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="index_user.php">Home</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link " href="index_user.php">Concerts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="myticket.php">My Tickets</a>
                    </li>
                </ul>
                <?php
                require_once 'config/db.php';
                $member_id = $_SESSION['member_id'];
                $sql = <<<EOF
                SELECT * from concert
                WHERE member_id = $member_id;
                EOF;
                $ret = $db->query($sql);
                $count = 0;
                $status = array();
                while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                    array_push($status, $row['status']);
                    $count++;
                }
                if ($count > 0) {
                    echo '<form class="d-flex mb-2 mb-lg-0 me-1" action="my_concert.php">
                    <button class="btn btn-light position-relative" type="submit" style = "background-color: white;">My Concert';
                    if(in_array("approved", $status) || in_array("rejected", $status)){
                        echo '<span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger rounded-circle">
                        </span>';
                    }
                    
                    echo '</button>
                    </form>';
                }
                ?>
                <form class="d-flex mb-2 mb-lg-0 me-1" action="createcon_db.php">
                    <button class="btn btn-light" type="submit">Create Concert</button>
                </form>
                <form class="d-flex mb-2 mb-lg-0" action="index_notlogin.php">
                    <button class="btn btn-outline-danger" type="submit">Log Out</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- code -->
    <a href="index_user.php"><button class="btn btn-secondary">back</button></a>
    <h4 style="text-align:center">My Concert</h4>
    <?php
    //connect to database
    require_once 'config/db.php';

    $member_id = $_SESSION['member_id'];
    $sql = <<<EOF
    SELECT * from concert
    WHERE member_id = $member_id;
    EOF;
    $ret = $db->query($sql);
    $count = 0;
    while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
        $count++;
    }
    if ($count > 0) {
        echo "<div class = 'show'>";
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            echo '<div class="card" style="width: 18rem;">
            <img src="' . $row['concert_img_path'] . '" class="card-img-top">
                <div class="card-body">
                <div class="d-flex justify-content-between align-items-center"><h5 class="card-title">' . $row['concert_name'] . '</h5>';
                if($row['status'] == 'checking'){
                    echo'<span class="badge bg-secondary rounded-pill">' . $row['status'] . '</span>';
                }elseif ($row['status'] == 'approved'){
                    echo'<span class="badge bg-success rounded-pill">' . $row['status'] . '</span>';
                }elseif ($row['status'] == 'rejected'){
                    echo'<span class="badge bg-danger rounded-pill">' . $row['status'] . '</span>';
                }
                
                echo '</div>
                <p class="card-text"></p>
                <a href="each_my_concert.php?concert_id=' . $row['concert_id'] . '" class="btn btn-primary">see more</a>
                </div>
            </div>';
        }
        echo "</div>";
    }
    ?>
    <!-- footer -->
    <hr>
    <footer class="py-3 my-4 ">
        <p class="text-center text-muted">© 2023 TICKCON</p>
    </footer>
</body>

</html>