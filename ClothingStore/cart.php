<?php
include "DBConn.php";
include "pastimes_helpers.php";
$sessionID = cartSessionID();
$stmt = $conn->prepare("SELECT c.cartID, c.quantity, p.* FROM tblCart c JOIN tblClothes p ON c.clothID=p.clothID WHERE c.sessionID=? ORDER BY c.cartID DESC");
$stmt->bind_param("s", $sessionID);
$stmt->execute();
$items = $stmt->get_result();
$total = 0;
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Pastimes — Cart</title><link rel="stylesheet" href="pastimes.css"></head><body><div class="layout"><?php renderSidebar('cart'); ?><main class="main"><div class="page-header"><div><h1 class="page-title">Shopping Cart</h1><p class="page-sub">Update quantities, remove items, or continue shopping.</p></div><a class="btn btn-secondary" href="viewClothing.php">Continue Shopping</a></div><div class="card table-wrap"><table class="table"><tr><th>Item</th><th>Details</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Action</th></tr><?php if($items->num_rows==0): ?><tr><td colspan="6" class="muted">Your cart is empty.</td></tr><?php endif; while($row=$items->fetch_assoc()): $subtotal=$row['price']*$row['quantity']; $total+=$subtotal; ?><tr><td><img class="thumb" src="<?php echo e($row['image']); ?>"></td><td><strong><?php echo e($row['name']); ?></strong><br><span class="muted"><?php echo e($row['brand']); ?> · Size <?php echo e($row['size']); ?></span></td><td><?php echo money($row['price']); ?></td><td><form method="POST" action="updateCart.php" class="actions"><input type="hidden" name="cartID" value="<?php echo $row['cartID']; ?>"><input style="width:80px" type="number" min="1" name="quantity" value="<?php echo $row['quantity']; ?>"><button class="btn btn-secondary" name="update">Update</button></form></td><td><?php echo money($subtotal); ?></td><td><a class="btn btn-danger" href="removeFromCart.php?id=<?php echo $row['cartID']; ?>">Remove</a></td></tr><?php endwhile; ?></table></div><div class="card"><h2 class="product-title">Total: <?php echo money($total); ?></h2><div class="actions"><a class="btn" href="checkout.php">Checkout</a><a class="btn btn-secondary" href="viewClothing.php">Continue Shopping</a></div></div></main></div></body></html>
