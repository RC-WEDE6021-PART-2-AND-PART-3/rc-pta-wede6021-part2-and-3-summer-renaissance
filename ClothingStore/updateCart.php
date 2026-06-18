<?php
include "DBConn.php";
include "pastimes_helpers.php";
if (isset($_POST['update'])) {
    $cartID = (int)$_POST['cartID'];
    $quantity = max(1, (int)$_POST['quantity']);
    $sessionID = cartSessionID();
    $stmt = $conn->prepare("UPDATE tblCart SET quantity=? WHERE cartID=? AND sessionID=?");
    $stmt->bind_param("iis", $quantity, $cartID, $sessionID);
    $stmt->execute();
}
header("Location: cart.php");
exit;
?>
