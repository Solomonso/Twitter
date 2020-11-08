<?php
/***********************************************/
/****** Author: solomon              ***********/
/****** Desc: Page for signing up
 ********************
 ******  *****
 ******            *************************
 ******                                        *******/
/****** Date Created: dd-mm-yyyy 06-24-2019 ********/
/******  ****************************************/
/**********************************************/
?>
<!DOCTYPE html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="../../css/basic.css">
</head>
<body>
<div class="header-img">
    <p class="twitter-text">Stenden Twitter</p>
</div>

<div id="full-body-signup">
    <?php
    include '../../include/db_connect.php';

    echo "<br>";

    if (isset($_POST['submit'])) {

        $user = $_POST["user_name"];
        $user_name = filter_var($user, FILTER_SANITIZE_STRING);

        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

        $email = $_POST["email"];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (empty($user_name) || empty($password) || empty($email)) {
            echo "<h1>Please Enter The details</h1>";

        } else {
            $sql_name = "SELECT user_name FROM stenden_user WHERE user_name = ? LIMIT 1";
            $sql_email = "SELECT user_email FROM stenden_user WHERE user_email = ? LIMIT 1";


            if ($stmt_name = mysqli_prepare($conn, $sql_name)) {
                mysqli_stmt_bind_param($stmt_name, "s", $user_name);

                if (mysqli_stmt_execute($stmt_name)) {

                } else {
                    echo "Unable " . mysqli_error($conn);
                }

                mysqli_stmt_bind_result($stmt_name, $user_name);
                mysqli_stmt_store_result($stmt_name);

                $row = mysqli_stmt_affected_rows($stmt_name);
            }

            if ($stmt_email = mysqli_prepare($conn, $sql_email)) {
                mysqli_stmt_bind_param($stmt_email, "s", $email);

                if (mysqli_stmt_execute($stmt_email)) {

                } else {
                    echo "Unable " . mysqli_error($conn);
                }

                mysqli_stmt_bind_result($stmt_email, $email);
                mysqli_stmt_store_result($stmt_email);

                $row_2 = mysqli_stmt_affected_rows($stmt_email);
            }

            //Check if there are no rows affected in the statement
            if ($row == 0 && $row_2 == 0) {
                mysqli_stmt_close($stmt_name);
                mysqli_stmt_close($stmt_email);
            }

            if ($row == 1) {
                echo "<p style=color:white;font-size:20px;>Username is already take</p>";
                echo "<br>";
            }
            if ($row_2 == 1) {
                echo "<p style=color:white;font-size:20px;>Email is already taken</p>";
            } else {
                $query = "INSERT INTO stenden_user VALUES(NULL,?,?,?,?)";
                if ($stmt = mysqli_prepare($conn, $query)) {
                    $file_name = $_FILES["image"]["name"];

                    $target_dir = "../../upload/";
                    $target_file = $target_dir . $_FILES["image"]["name"];

                    //check for the type of file
                    if ((($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] == "image/png"))
                        && ($_FILES["image"]["size"] < 600000)) {

                        if (file_exists($target_dir. $_FILES["image"]["name"])) {

                            echo $_FILES["image"]["name"] . " <p style=color:white;font-size:14px;>already exists.<br>Choose a different one</p>";

                        } else {
                            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
                            //overwrite the path that is been saved in the database in order to access it from the index page
                            $target_file = "upload/" . $_FILES["image"]["name"];
                            mysqli_stmt_bind_param($stmt, "ssss", $user_name, $password, $email, $target_file);

                            if (mysqli_stmt_execute($stmt)) {
                                echo "<h1>Sign Up Successful</h1>" . "<br>";
                                echo "<a href=../login/login.php class='text'><button>Click Here to Login</button></a>";

                            } else {
                                echo "Unable to Create acoount " . mysqli_error($conn);
                            }

                            echo "<br>";
                            mysqli_stmt_close($stmt);
                        }
                    } else {
                        echo "<p style=color:white;font-size:20px;>Invalid File Choose a jpeg, png or gif </p>";
                    }

                } else {
                    echo "Unable to prepare " . mysqli_error($conn);
                }

            }

        }
    }

    mysqli_close($conn);
    ?>
    <div class="form-div-signup">
        <div class="form-style-signup">
            <form action="signup.php" method="POST" enctype="multipart/form-data">
                <h2 class="head-text-color-">Create a New Account</h2>
                <br>
                <p class="form-field"><input type="text" name="user_name" size="30" id="name-field" class="style"
                                             placeholder="Username"></p>
                <p class="form-field"><input type="password" name="password" size="30" id="pass-field" class="style"
                                             required placeholder="Password"></p>
                <p class="form-field"><input type="email" name="email" size="30" id="email-field" class="style" required
                                             placeholder="Email"></p>
                <p class="form-field">Upload Avatar: <input type="file" name="image"></p>
                <p class="form-field"><input type="submit" name="submit" Value="SignUP"></p>
            </form>
        </div>
    </div>
</div>
</body>
