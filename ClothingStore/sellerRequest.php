<?php
include "DBConn.php";
include "pastimes_helpers.php";
$message = '';
if (isset($_POST['submitRequest'])) {
    $sellerName = trim($_POST['sellerName']);
    $sellerEmail = trim($_POST['sellerEmail']);
    $brand = trim($_POST['brand']);
    $description = trim($_POST['description']);
    $size = trim($_POST['size']);
    $price = (float)$_POST['price'];
    $image = saveUploadedImage('image');
    $stmt = $conn->prepare("INSERT INTO tblSellerRequest(sellerName, sellerEmail, brand, description, size, price, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssds", $sellerName, $sellerEmail, $brand, $description, $size, $price, $image);
    $message = $stmt->execute() ? 'Your seller request was submitted for admin approval.' : 'Could not submit request.';
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Pastimes — Seller Request</title><link rel="stylesheet" href="pastimes.css"></head><body><div class="layout"><?php renderSidebar('sellerRequest'); ?><main class="main"><div class="page-header"><div><h1 class="page-title">Sell Clothing</h1><p class="page-sub">Submit a branded item for admin approval.</p></div></div><?php if($message) echo '<div class="alert alert-success">'.e($message).'</div>'; ?><div class="card"><form method="POST" enctype="multipart/form-data"><div class="form-grid"><div class="field"><label>Seller Name</label><input type="text" name="sellerName" required></div><div class="field"><label>Seller Email</label><input type="email" name="sellerEmail" required></div><div class="field"><label>Brand</label><input type="text" name="brand" required></div><div class="field"><label>Size</label><input type="text" name="size" required></div><div class="field"><label>Price</label><input type="number" step="0.01" min="0" name="price" required></div><div class="field"><label>Image</label><input type="file" name="image" accept="image/*"></div><div class="field full"><label>Description</label><textarea name="description" required></textarea></div></div><button class="btn" name="submitRequest">Submit Request</button></form></div></main></div></body></html>
