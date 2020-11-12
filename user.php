<?php

if (isset($_REQUEST['password']) && isset($_REQUEST['con-password'])) {

    if ($_REQUEST['password'] != $_REQUEST['con-password']) {

        echo '<div class="password-warning">
        <div class="pass-icon">
            <span class="iconify" data-icon="emojione-v1:cross-mark" data-inline="false"></span>
        </div>
        Password should match
        <form action="" method="post">
            <input type="submit" value="OK" name="ok" class="ok">
        </form>
    </div>';
    } elseif (isset($_REQUEST['number'])) {

        if (featch($conn)) {
            echo '<div class="password-warning">
            <div class="pass-icon">
                <span class="iconify" data-icon="emojione-v1:cross-mark" data-inline="false"></span>
            </div>
            User already exists
            <form action="" method="post">
                <input type="submit" value="OK" name="ok" class="ok">
            </form>
        </div>';
        } else {

            $pattern = "^[789]\d{9}$^";

            if (preg_match($pattern, $_REQUEST['number'])) {

                $sql = "INSERT INTO user VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

                $stmt = mysqli_prepare($conn, $sql);

                mysqli_stmt_bind_param($stmt, "sssssssssb", $name, $number, $state, $city, $password, $dob, $address, $participent, $imgres, $voted);

                $filename = $_FILES['image']['name'];
                $filepath = "img/" . basename($filename);

                $crypt = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);

                $name = $_REQUEST['name'];
                $number = $_REQUEST['number'];
                $state = $_REQUEST['state'];
                $city = $_REQUEST['city'];
                $password = $crypt;
                $dob = $_REQUEST['dob'];
                $address = $_REQUEST['address'];
                $participent = $_REQUEST['person'];
                $imgres = $filepath;
                $voted = false;

                mysqli_stmt_execute($stmt);

                if (move_uploaded_file($_FILES['image']['tmp_name'], $filepath)) {

                    echo '<div class="password-warning">
                <div class="tick-icon">
                    <span class="iconify" data-icon="clarity:success-standard-solid" data-inline="false"></span>
                </div>
                Registered
                <form action="Login.php" method="post">
                    <input type="submit" value="OK" name="ok" class="ok">
                </form>
            </div>';
                }
            } else {
                echo '<div class="password-warning">
            <div class="pass-icon">
                <span class="iconify" data-icon="emojione-v1:cross-mark" data-inline="false"></span>
            </div>
            Wrong Number
            <form action="" method="post">
                <input type="submit" value="OK" name="ok" class="ok">
            </form>
        </div>';
            }
        }
    }
}

?>