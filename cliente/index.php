<?php
require_once "header.php";
if (!isset($_SESSION["cliente"])) {
    header("Location: login.php");
}
?>


<?php require_once "footer.php"; ?>