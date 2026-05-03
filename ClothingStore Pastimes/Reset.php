<?php
include "DBConn.php";

$conn->query("SET FOREIGN_KEY_CHECKS = 0");
$conn->query("DROP TABLE IF EXISTS tblOrder");
$conn->query("DROP TABLE IF EXISTS tblClothes");
$conn->query("DROP TABLE IF EXISTS tblAdmin");
$conn->query("DROP TABLE IF EXISTS tblUser");
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

$conn->query("CREATE TABLE tblUser (
    userID   INT AUTO_INCREMENT PRIMARY KEY,
    fullName VARCHAR(100),
    email    VARCHAR(100),
    password VARCHAR(255),
    status   VARCHAR(20) DEFAULT 'pending'
)");

echo "Tables reset successfully!";
?>