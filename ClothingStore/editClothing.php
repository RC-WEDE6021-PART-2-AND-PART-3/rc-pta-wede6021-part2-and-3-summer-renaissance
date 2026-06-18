<?php
include "DBConn.php";
include "pastimes_helpers.php";
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $conn->prepare("SELECT * FROM tblClothes WHERE clothID=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();
if (!$item) { die('Clothing item not found.'); }
if (isset($_POST['update'])) {
    $name = trim($_POST['name']);
    $brand = trim($_POST['brand']);
    $description = trim($_POST['description']);
    $size = trim($_POST['size']);
    $price = (float)$_POST['price'];
    $image = saveUploadedImage('image', $item['image']);
    $update = $conn->prepare("UPDATE tblClothes SET name=?, brand=?, description=?, size=?, price=?, image=? WHERE clothID=?");
    $update->bind_param("ssssdsi", $name, $brand, $description, $size, $price, $image, $id);
    $update->execute();
    header("Location: viewClothing.php");
    exit;
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Pastimes — Edit Clothing</title><link rel="stylesheet" href="pastimes.css"></head><body><div class="layout"><?php renderSidebar('clothing'); ?><main class="main"><div class="page-header"><div><h1 class="page-title">Edit Clothing</h1><p class="page-sub">Update details and optionally replace the image.</p></div><a class="btn btn-secondary" href="viewClothing.php">Back</a></div><div class="card"><form method="POST" enctype="multipart/form-data"><div class="form-grid"><div class="field"><label>Name</label><input type="text" name="name" value="<?php echo e($item['name']); ?>" required></div><div class="field"><label>Brand</label><input type="text" name="brand" value="<?php echo e($item['brand']); ?>" required></div><div class="field"><label>Size</label><input type="text" name="size" value="<?php echo e($item['size']); ?>" required></div><div class="field"><label>Price</label><input type="number" step="0.01" min="0" name="price" value="<?php echo e($item['price']); ?>" required></div><div class="field full"><label>Description</label><textarea name="description" required><?php echo e($item['description']); ?></textarea></div><div class="field full"><label>Current Image</label><?php if($item['image']) echo '<br><img class="thumb" src="'.e($item['image']).'">'; ?><input type="file" name="image" accept="image/*"></div></div><button class="btn" name="update">Save Changes</button></form></div></main></div></body></html>
