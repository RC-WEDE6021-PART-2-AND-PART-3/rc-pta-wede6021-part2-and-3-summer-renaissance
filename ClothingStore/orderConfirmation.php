<?php
include "DBConn.php";
include "pastimes_helpers.php";
$orderID = isset($_GET['orderID']) ? (int)$_GET['orderID'] : 0;
$stmt = $conn->prepare("SELECT * FROM tblOrder WHERE orderID=?");
$stmt->bind_param("i", $orderID);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Pastimes — Order Confirmation</title><link rel="stylesheet" href="pastimes.css"></head><body><div class="layout"><?php renderSidebar('cart'); ?><main class="main"><div class="page-header"><div><h1 class="page-title">Order Confirmation</h1><p class="page-sub">Thank you for shopping with Pastimes.</p></div><a class="btn" href="viewClothing.php">Continue Shopping</a></div><?php if(!$order): ?><div class="card muted">Order not found.</div><?php else: ?><div class="card"><h2 class="product-title">Order #<?php echo $order['orderID']; ?> Confirmed</h2><p class="muted">A confirmation has been recorded for <?php echo e($order['customerName']); ?> at <?php echo e($order['customerEmail']); ?>.</p><p class="price">Total Paid: <?php echo money($order['totalAmount']); ?></p><p class="muted">Status: <?php echo e($order['status']); ?></p></div><?php endif; ?></main></div></body></html>
