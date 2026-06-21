<?php
include "DBConn.php";
include "pastimes_helpers.php";
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $like = '%' . $search . '%';
    $stmt = $conn->prepare("SELECT * FROM tblClothes WHERE name LIKE ? OR brand LIKE ? ORDER BY clothID DESC");
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM tblClothes ORDER BY clothID DESC");
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Pastimes — Clothing</title><link rel="stylesheet" href="pastimes.css"></head><body><div class="layout"><?php renderSidebar('clothing'); ?><main class="main"><div class="page-header"><div><h1 class="page-title">Clothing Store</h1><p class="page-sub">View, search, edit and shop Pastimes clothing.</p></div><a class="btn" href="addClothing.php">Add Clothing</a></div><div class="card"><form class="searchbar" method="GET"><div class="field" style="margin:0"><input type="text" name="search" placeholder="Search by name or brand" value="<?php echo e($search); ?>"></div><button class="btn" type="submit">Search</button><a class="btn btn-secondary" href="viewClothing.php">Clear</a></form></div><div class="grid"><?php if($result->num_rows == 0){ echo '<div class="card muted">No clothing items found.</div>'; } while($row = $result->fetch_assoc()): ?><div class="product-card"><img src="<?php echo e($row['image'] ?: 'uploads/.gitkeep'); ?>" alt="<?php echo e($row['name']); ?>"><div class="product-body"><div class="brand"><?php echo e($row['brand']); ?></div><h2 class="product-title"><?php echo e($row['name']); ?></h2><p class="muted"><?php echo e($row['description']); ?></p><p class="muted">Size: <?php echo e($row['size']); ?></p><div class="price"><?php echo money($row['price']); ?></div><div class="actions"><a class="btn" href="addToCart.php?id=<?php echo $row['clothID']; ?>">Add to Cart</a><a class="btn btn-secondary" href="editClothing.php?id=<?php echo $row['clothID']; ?>">Edit</a><a class="btn btn-danger" onclick="return confirm('Delete this item?')" href="deleteClothing.php?id=<?php echo $row['clothID']; ?>">Delete</a></div></div></div><?php endwhile; ?></div></main></div></body></html>
