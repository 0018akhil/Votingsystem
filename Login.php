<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_base = "voting";

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_base);

function featch($conn)
{

    $sql = "SELECT * FROM user;";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['number'] == $_REQUEST['number']) {
            return true;
        }
    }

    return false;
}

function featchgroup($conn)
{

    $sql = "SELECT * FROM groups;";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['number'] == $_REQUEST['number']) {
            return true;
        }
    }

    return false;
}

if (mysqli_connect_error($conn)) {
    die($conn);
}

function passvoter($conn)
{
    $sql = "SELECT * FROM user;";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['number'] == $_REQUEST['number']) {

            if (password_verify($_REQUEST['password'], $row['password'])) {
                return true;
            }
        }
    }

    return false;
}

function passgroup($conn)
{
    $sql = "SELECT * FROM groups;";

    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['number'] == $_REQUEST['number']) {

            if (password_verify($_REQUEST['password'], $row['password'])) {
                return true;
            }
        }
    }

    return false;
}

if (isset($_REQUEST['ok'])) {
    echo '<div class="password-warning" style="visibility:hidden">
    <div class="pass-icon">
        <span class="iconify" data-icon="emojione-v1:cross-mark" data-inline="false"></span>
    </div>
    Password should match
    <form action="" method="post">
        <input type="submit" value="OK" name="ok" class="ok">
    </form>
</div>';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styletwo.css">

    <!-- JavaScript -->
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

    <!-- Font styles -->
    <link href="https://fonts.googleapis.com/css2?family=Aclonica&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="navigation">Online Voting System<div class="vote"><span class="iconify" data-icon="mdi-vote" data-inline="false"></span></div>
    </nav>

    <header class="system">
        <div class="groups">
            <div class="name">Group</div>

            <div class="gp-box">
                <?php
                $sql = "SELECT * FROM groups;";

                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="group-container">
                        <div class="gp-name">' . $row['name'] . '</div>
                        <div class="gp-image"><img src="' . $row['pathimg'] . '" alt="Participent" width="100px" height="100px"></div>
                        <div class="gp-votes">Votes:' . $row['votes'] . '</div>
                    </div>';
                }
                ?>


            </div>

        </div>
        <div class="login">
            <div class="name">Login</div>
            <div class="login-logo">
                <span class="iconify" data-icon="mdi:account" data-inline="false"></span>
            </div>
            <div class="input">
                <form action="" method="post">
                    <input class="form-adj" type="tel" name="number" id="number" placeholder="number">
                    <input class="form-adj" type="password" name="password" id="password" placeholder="password">
                    <select class="form-adj" name="person" id="person">
                        <option value="voter">voter</option>
                        <option value="participent">participent</option>
                    </select>
                    <input id="btn" name="submit" class="form-adj" type="submit" value="Login">
                </form>
                <div class="Register">Not Registered?<a href="Register.php" target="_blank" rel="noopener noreferrer" style="text-decoration: none;">Register here</a></div>

            </div>

        </div>
    </header>

    <?php

    if (isset($_REQUEST['submit'])) {

        if ($_REQUEST['person'] == "voter") {

            if (featch($conn)) {

                if (passvoter($conn)) {
                    session_start();

                    $_SESSION['number'] = $_REQUEST['number'];
                    $_SESSION['person'] = $_REQUEST['person'];
                    echo '<script>window.location.replace("./window.php");</script>';
                } else {
                    echo '<div class="password-warning">
                    <div class="pass-icon">
                        <span class="iconify" data-icon="emojione-v1:cross-mark" data-inline="false"></span>
                    </div>
                    Password wrong
                    <form action="" method="post">
                        <input type="submit" value="OK" name="ok" class="ok">
                    </form>
                </div>';
                }
            } else {
                echo '<div class="password-warning">
                <div class="pass-icon">
                    <span class="iconify" data-icon="emojione-v1:cross-mark" data-inline="false"></span>
                </div>
                No such user
                <form action="" method="post">
                    <input type="submit" value="OK" name="ok" class="ok">
                </form>
            </div>';
            }
        } else {

            if (featchgroup($conn)) {

                if (passgroup($conn)) {
                    session_start();

                    $_SESSION['number'] = $_REQUEST['number'];
                    $_SESSION['person'] = $_REQUEST['person'];
                    echo '<script>window.location.replace("./window.php");</script>';
                } else {
                    echo '<div class="password-warning">
                    <div class="pass-icon">
                        <span class="iconify" data-icon="emojione-v1:cross-mark" data-inline="false"></span>
                    </div>
                    Password wrong
                    <form action="" method="post">
                        <input type="submit" value="OK" name="ok" class="ok">
                    </form>
                </div>';
                }
            } else {
                echo '<div class="password-warning">
                <div class="pass-icon">
                    <span class="iconify" data-icon="emojione-v1:cross-mark" data-inline="false"></span>
                </div>
                No such group
                <form action="" method="post">
                    <input type="submit" value="OK" name="ok" class="ok">
                </form>
            </div>';
            }
        }
    }


    ?>

</body>

</html>