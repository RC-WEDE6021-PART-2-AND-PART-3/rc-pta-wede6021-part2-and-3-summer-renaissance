<?php
include "DBConn.php";
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM tblClothes WHERE clothID=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: viewClothing.php");
exit;
?>
