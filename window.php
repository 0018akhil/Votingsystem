<?php

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_base = "voting";

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_base);

$name = "";
$number = "";
$state = "";
$city = "";
$dob = "";
$address = "";
$person = "";
$status = "";
$style = "";
$disable = "";



session_start();

if ($_SESSION['person'] == "voter") {
    $quary = 'SELECT * FROM user where number="' . $_SESSION['number'] . '";';

    $result = mysqli_query($conn, $quary);

    while ($data = mysqli_fetch_array($result)) {

        $name = $data['name'];
        $number = $data['number'];
        $state = $data['state'];
        $city = $data['city'];
        $dob = $data['dob'];
        $address = $data['address'];
        $person = $data['person'];
        $pathimg = $data['pathimg'];
        if($data['voted']){
            $status = "Voted";
            $style = 'style="color: green;"';
            $disable = "disabled";
        } else {
            $status = "Not Voted";
            $style = 'style="color: red;"';
        }
        
    }
}

if ($_SESSION['person'] == "participent") {

    $quary = 'SELECT * FROM groups where number="' . $_SESSION['number'] . '";';

    $result = mysqli_query($conn, $quary);

    while ($data = mysqli_fetch_array($result)) {

        $name = $data['name'];
        $number = $data['number'];
        $state = $data['state'];
        $city = $data['city'];
        $dob = $data['dob'];
        $address = $data['address'];
        $person = $data['person'];
        $pathimg = $data['pathimg'];
        if($data['voted']){
            $status = "Voted";
            $style = 'style="color: green;"';
            $disable = "disabled";
        } else {
            $status = "Not Voted";
            $style = 'style="color: red;"';
        }
    }
}

if (isset($_REQUEST['logout'])) {
    session_unset();
    session_destroy();
    mysqli_close($conn);
    echo '<script>window.location.replace("./Login.php");</script>';
}

if (isset($_REQUEST['votebtn'])){

    if($person == "voter"){

        $stmt = "UPDATE groups SET votes = votes+1 WHERE number = {$_REQUEST['hidbtn']};";
        $stmttwo = "UPDATE user SET voted = true WHERE number = {$number};";

        mysqli_query($conn, $stmt);
        mysqli_query($conn, $stmttwo);
        
        echo '<script>window.location.replace("./window.php");</script>';
        

    }
    else{

        $stmt = "UPDATE groups SET votes = votes+1 WHERE number = {$_REQUEST['hidbtn']};";
        $stmttwo = "UPDATE groups SET voted = true WHERE number = {$number};";

        mysqli_query($conn, $stmt);
        mysqli_query($conn, $stmttwo);

        echo '<script>window.location.replace("./window.php");</script>';
    }

    

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="userstyle.css">
    <link rel="stylesheet" href="styletwo.css">
    <link rel="stylesheet" href="winstyle.css">

    <!-- JavaScript -->
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

    <!-- Font styles -->
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="navigation">
        Online Voting System
        <div class="vote"><span class="iconify" data-icon="mdi-vote" data-inline="false"></span></div>

        <div class="main-btn">
            <div class="login-user-logo"><span class="iconify" data-icon="mdi:account" data-inline="false"></span></div>
            <div class="logout-btn">
                <form action="" method="post"><input class="logout-btn" type="submit" name="logout" value="Logout">
                </form>
            </div>
        </div>

    </nav>

    <header class="system">

        <div class="groups">

            <?php

            echo '<div class="voter-details">
                <img src="' . $pathimg . '" alt="noimge">

                <div class="voter-name">Name:' . $name . '</div>
                <div class="voter-name">Number:' . $number . '</div>
                <div class="voter-name">State:' . $state . '</div>
                <div class="voter-name">City:' . $city . '</div>
                <div class="voter-name">DOB:' . $dob . '</div>
                <div class="voter-name">Address:' . $address . '</div>
                <div class="voter-name">Person:' . $person . '</div>
                <div class="voter-name">Status: <span class="vote-color" ' . $style . '>' . $status . '</span></div>
            </div>';

            ?>

        </div>

        <div class="login" >

            <?php

            $sql = "SELECT * FROM groups;";

            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                
                echo '<div class="voting-list">
                <div class="grp-name">' . $row['name'] . '</div>
                <div class="grp-img"><img src="' . $row['pathimg'] . '" alt="Participent" srcset=""></div>
                <div class="grp-btn">
                    <form action="window.php" method="post"><input type="hidden" name="hidbtn" value="' . $row['number'] . '"><input class="vote-btn" id="vote-btn" name="votebtn" type="submit" value="Vote"' . $disable . '></form>
                </div>
            </div>';
            }

            ?>
            
            

        </div>
    </header>

</body>

</html>