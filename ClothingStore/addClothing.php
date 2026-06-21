<?php
include "DBConn.php";
include "pastimes_helpers.php";
$message = '';
if (isset($_POST['add'])) {
    $name = trim($_POST['name']);
    $brand = trim($_POST['brand']);
    $description = trim($_POST['description']);
    $size = trim($_POST['size']);
    $price = (float)$_POST['price'];
    $image = saveUploadedImage('image');
    $stmt = $conn->prepare("INSERT INTO tblClothes(name, brand, description, size, price, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssds", $name, $brand, $description, $size, $price, $image);
    $message = $stmt->execute() ? "Clothing item added successfully." : "Could not add clothing item.";
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Pastimes — Add Clothing</title><link rel="stylesheet" href="pastimes.css"></head><body><div class="layout"><?php renderSidebar('addClothing'); ?><main class="main"><div class="page-header"><div><h1 class="page-title">Add Clothing</h1><p class="page-sub">Create a new store item with brand, size, price and image.</p></div><a class="btn btn-secondary" href="viewClothing.php">View Clothing</a></div><?php if($message) echo '<div class="alert alert-success">'.e($message).'</div>'; ?><div class="card"><form method="POST" enctype="multipart/form-data"><div class="form-grid"><div class="field"><label>Name</label><input type="text" name="name" required></div><div class="field"><label>Brand</label><input type="text" name="brand" required></div><div class="field"><label>Size</label><input type="text" name="size" required></div><div class="field"><label>Price</label><input type="number" step="0.01" min="0" name="price" required></div><div class="field full"><label>Description</label><textarea name="description" required></textarea></div><div class="field full"><label>Image Upload</label><input type="file" name="image" accept="image/*"></div></div><button class="btn" name="add">Add Clothing</button></form></div></main></div></body></html>
