<?php
/***********************************************/
/****** Author: solomon              ***********/
/****** Desc: Logout  page
 ***
 ******            ********************
 ******  *****            **********************
 ******                                        *******/
/****** Date Created: dd-mm-yyyy 06-24-2019 ********/
/******  ****************************************/
/**********************************************/
?>
<!DOCTYPE html>
<html>
<head>
    <title>LogOut</title>
    <link rel="stylesheet" type="text/css" href="../../css/basic.css">
</head>
<body>
<div class="header-img">
    <p class="twitter-text">Stenden Twitter</p>
</div>

<div id="logout-body">
    <?php
    session_start();
    session_destroy();
    unset($_SESSION["valid_id"]);
    unset($_SESSION["valid_name"]);
    echo "<a href='../../index.php'><button>Back to home</button></a>";
    ?>
</div>

</body>
</html>
