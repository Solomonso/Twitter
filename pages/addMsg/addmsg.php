<?php
/***********************************************/
/****** Author: solomon              ***********/
/****** Desc: Add message page
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
    <title>Add Message</title>
    <link rel="stylesheet" type="text/css" href="../../css/basic.css">
</head>
<body>
<?php
if (isset($_SESSION["valid_id"]) && isset($_SESSION["valid_name"])) {
    echo "<div class='header-img' >
				<p class='twitter-text float-header'>Stenden Twitter</p>
				<div class='button'>
					<a href='../logout/logout.php'><button class='button-style'>Logout</button></a>
					<a href='../../index.php'><button class='right'>Back to home</button></a>
				</div>
			</div>";

} else {
    echo "<div class='header-img' >
				<p class='twitter-text float-header'>Stenden Twitter</p>
				<div class='button'>
					<a href='../../index.php'><button class='button-style'>Home</button></a>
				</div>
			</div>";
}
?>
<div id="full-body-signup">
    <?php
     include '../../include/db_connect.php';

        if (isset($_POST["submit"])) {
            if (isset($_SESSION["valid_id"]) && isset($_SESSION["valid_name"])) {
                $message = $_POST["add_msg"];
                $msg = filter_var($message, FILTER_SANITIZE_STRING);
            
                if (empty($msg)) {
                    echo "<p style=color:white;font-size:20px;>Your message is empty please write your message<p>";
                } else {
                    $query = "INSERT INTO stenden_message VALUES(NULL,'" . $_SESSION['valid_id'] . "',?)";
                    if ($stmt = mysqli_prepare($conn, $query)) {

                        mysqli_stmt_bind_param($stmt, "s", $msg);

                        if (mysqli_stmt_execute($stmt)) {
                            echo "<h1>Post made</h1>" . "<br>";
                            echo "<a href=../../index.php><button>Click here to see your Post</button></a>";

                        } else {
                            echo "Unable to make post " . mysqli_error($conn);
                        }

                        echo "<br>";

                    } else {
                        echo "Unable to prepare" . mysqli_error($conn);
                    }
                }
            } else {
                echo "<p style=color:white;font-size:20px;>Session not set</p>" . "<br>";
                echo "<p style=color:white;font-size:20px;>You are not login you cannot add a message</p>" . "<br>";
                echo "<a href=../login/login.php><button>Click Here to login</button></a>";
            }
        }

    ?>

    <form action="addmsg.php" method="post">
        <h2 class="text-msg-add">Add Your Message:</h2>
        <p><textarea name="add_msg" cols="60" rows="10"></textarea></p>
        <br>
        <input type="submit" name="submit" value="add your msg">
    </form>
</div>
</body>
</html>
