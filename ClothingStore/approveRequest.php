<?php
include "DBConn.php";
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : '';
if ($id > 0 && in_array($action, ['approve', 'reject'])) {
    $stmt = $conn->prepare("SELECT * FROM tblSellerRequest WHERE requestID=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $request = $stmt->get_result()->fetch_assoc();
    if ($request && $request['status'] === 'pending') {
        if ($action === 'approve') {
            $name = $request['brand'] . ' Seller Item';
            $ins = $conn->prepare("INSERT INTO tblClothes(name, brand, description, size, price, image) VALUES (?, ?, ?, ?, ?, ?)");
            $ins->bind_param("ssssis", $name, $request['brand'], $request['description'], $request['size'], $request['price'], $request['image']);
            $ins->execute();
            $status = 'approved';
        } else {
            $status = 'rejected';
        }
        $up = $conn->prepare("UPDATE tblSellerRequest SET status=? WHERE requestID=?");
        $up->bind_param("si", $status, $id);
        $up->execute();
    }
}
header("Location: viewRequests.php");
exit;
?>
