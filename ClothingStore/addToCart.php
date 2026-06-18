<?php
include "DBConn.php";
include "pastimes_helpers.php";
$clothID = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sessionID = cartSessionID();
$userID = currentUserID();
if ($clothID > 0) {
    $stmt = $conn->prepare("SELECT cartID, quantity FROM tblCart WHERE clothID=? AND sessionID=?");
    $stmt->bind_param("is", $clothID, $sessionID);
    $stmt->execute();
    $existing = $stmt->get_result()->fetch_assoc();
    if ($existing) {
        $qty = $existing['quantity'] + 1;
        $up = $conn->prepare("UPDATE tblCart SET quantity=? WHERE cartID=?");
        $up->bind_param("ii", $qty, $existing['cartID']);
        $up->execute();
    } else {
        $ins = $conn->prepare("INSERT INTO tblCart(sessionID, userID, clothID, quantity) VALUES (?, ?, ?, 1)");
        $ins->bind_param("sii", $sessionID, $userID, $clothID);
        $ins->execute();
    }
}
header("Location: cart.php");
exit;
?>
