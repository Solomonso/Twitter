<?php
/***********************************************/
/****** Author: solomon              ***********/
/****** Desc: Login page
 ***
 ******            ********************
 ******  *****            **********************
 ******                                        *******/
/****** Date Created: dd-mm-yyyy 06-24-2019 ********/
/******  ****************************************/
/**********************************************/

?>
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../../css/basic.css">
</head>
<body>
<div class="header-img">
    <p class="twitter-text">Stenden Twitter</p>
    <a href='../../index.php'>
        <button class='style-login-right'>Home</button>
    </a>
</div>

<div id="full-body-signup">
    <?php
        include '../../include/db_connect.php';

        if (isset($_POST["submit"])) {

            $user = $_POST["user_name"];
            $user_name = filter_var($user, FILTER_SANITIZE_STRING);
            $password = $_POST["password"];

            if (empty($user_name) || empty($password)) {
                echo "<p style=color:white;font-size:20px;>Please Enter your details</p>";
            }

            $query = "SELECT user_id,user_name,user_pass FROM stenden_user WHERE user_name = ?";
            if ($stmt = mysqli_prepare($conn, $query)) {

                //the purpose of bind_param it tells php which variables that should be substituted for the ?
                mysqli_stmt_bind_param($stmt, "s", $user_name);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<h1></h1>" . "<br>";
                } else {
                    echo "Error could not execute" . mysqli_error($conn);
                }

                //binding and storing the columns am selecting
                mysqli_stmt_bind_result($stmt, $user_id, $user_name, $hash_pass);
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) != 0) {

                    //fetch the result from the database
                    while (mysqli_stmt_fetch($stmt)) {
                        if ($verify = password_verify($password, $hash_pass)) {
                            echo "Login successfull" . "<br>";

                            //check for the username and password
                            if ($user_name == true && $verify == true) {
                                echo "You are logged in";
                                $_SESSION["valid_id"] = $user_id;
                                $_SESSION["valid_name"] = $user_name;

                                if (isset($_SESSION["valid_id"]) && isset($_SESSION["valid_name"])) {
                                    header("location: ../addMsg/addmsg.php");
                                }

                            } else {
                                echo "<h1>Not registered yet</h1>";
                            }

                        } else {
                            echo "<h1>Login failed</h1>";
                            echo "<h1>Try Again</h1>";
                        }
                    }
                } else {
                    echo "<h1>Not registered yet</h1>" . "<br>";
                    echo "<a href=../signup/signup.php><button class=sign-up>Sign Up</button></a>";
                }

                mysqli_stmt_free_result($stmt);
                mysqli_stmt_close($stmt);
                mysqli_close($conn);

            } else {
                echo "error " . mysqli_error($conn);
            }

        }

    ?>
    <div class="form-div-login">
        <div class="form-style-login">
            <form action="login.php" method="POST">
                <h2 class="head-text-color">Login</h2>
                <p class="form-field"><input type="text" name="user_name" id="name-field" placeholder="UserName"
                                             class="style" required></p>
                <p class="form-field"><input type="password" name="password" id="pass-field-login"
                                             placeholder="Password" class="style" required></p>

                <input type="submit" name="submit" value="Login" class="login-button">
            </form>
        </div>
    </div>
</div>
</body>
</html>
