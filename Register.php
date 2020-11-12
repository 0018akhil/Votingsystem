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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        <div class="container">

            <h2>Registration</h2>

            <div class="form-reg">
                <form action="#" method="post" enctype='multipart/form-data'>
                    <div class="name-num">

                        <input type="text" name="name" id="name" placeholder="Name">
                        <input type="tel" name="number" id="number" placeholder="Number">
                    </div>

                    <div class="state-city">
                        <input type="text" name="state" id="state" placeholder="State">
                        <input type="text" name="city" id="city" placeholder="City">
                    </div>

                    <div class="pass-conpass">
                        <input type="password" name="password" id="password" placeholder="Password">
                        <input type="password" name="con-password" id="con-password" placeholder="Confirm Password">
                    </div>

                    <div class="date-add">
                        <input type="date" name="dob" id="dob" placeholder="DateOfBirth">
                        <input type="text" name="address" id="address" placeholder="Address">
                    </div>

                    <div class="file-input">
                        <select name="person" id="person">
                            <option value="voter">voter</option>
                            <option value="participent">participent</option>
                        </select>
                        <div class="inputfile-box">
                            <input type="file" id="file" name="image" class="inputfile" onchange='uploadFile(this)' accept="image/*">
                            <label for="file">
                                <span id="file-name" class="file-box">UploadImage</span>
                                <span class="file-button">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    Browse
                                </span>
                            </label>
                        </div>
                    </div>

                    <input id="sub" name="reg" type="submit" value="Register">
                </form>
            </div>
        </div>
    </header>
    <?php
    if (mysqli_connect_error($conn)) {
        die($conn);
    } else {

        if (isset($_REQUEST['reg'])) {

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

            if ($_REQUEST['name'] == "" || $_REQUEST['number'] == "" || $_REQUEST['state'] == "" || $_REQUEST['city'] == "" || $_REQUEST['password'] == "" || $_REQUEST['con-password'] == "" || $_REQUEST['dob'] == "" || $_REQUEST['address'] == "") {
                echo '<script>alert("Fields Cannot Be Empty")</script>';
            } else {
                if($_REQUEST['person'] == "voter"){
                    include('user.php');
                }
                else{
                    include('group.php');
                }
            }
        }
    }
    ?>

    <script>
        function uploadFile(target) {
            document.getElementById("file-name").innerHTML = target.files[0].name;
        }
    </script>


</body>

</html>