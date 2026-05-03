<?php
include "DBConn.php";


$conn->query("SET FOREIGN_KEY_CHECKS = 0");

$conn->query("DROP TABLE IF EXISTS tblOrder");
$conn->query("DROP TABLE IF EXISTS tblClothes");
$conn->query("DROP TABLE IF EXISTS tblAdmin");
$conn->query("DROP TABLE IF EXISTS tblUser");

$conn->query("SET FOREIGN_KEY_CHECKS = 1");

$conn->query("CREATE TABLE IF NOT EXISTS tblUser (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    fullName VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255),
    status VARCHAR(20) DEFAULT 'pending'
)");

$conn->query("CREATE TABLE IF NOT EXISTS tblAdmin (
    adminID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    password VARCHAR(255)
)");


$conn->query("CREATE TABLE IF NOT EXISTS tblClothes (
    clothID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    price DECIMAL(10,2),
    size VARCHAR(10)
)");

$conn->query("CREATE TABLE IF NOT EXISTS tblOrder (
    orderID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    clothID INT,
    FOREIGN KEY (userID) REFERENCES tblUser(userID),
    FOREIGN KEY (clothID) REFERENCES tblClothes(clothID)
)");

echo "ClothingStore database loaded successfully!";
?>