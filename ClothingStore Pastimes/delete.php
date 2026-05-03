<?php
include "DBConn.php";
$id = $_GET['id'];
$conn->query("DELETE FROM tblUser WHERE userID=$id");
header("Location: admin.php");
?>