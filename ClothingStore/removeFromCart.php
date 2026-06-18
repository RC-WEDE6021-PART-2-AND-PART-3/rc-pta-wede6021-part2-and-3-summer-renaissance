<?php
include "DBConn.php";
include "pastimes_helpers.php";
$cartID = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sessionID = cartSessionID();
if ($cartID > 0) {
    $stmt = $conn->prepare("DELETE FROM tblCart WHERE cartID=? AND sessionID=?");
    $stmt->bind_param("is", $cartID, $sessionID);
    $stmt->execute();
}
header("Location: cart.php");
exit;
?>
