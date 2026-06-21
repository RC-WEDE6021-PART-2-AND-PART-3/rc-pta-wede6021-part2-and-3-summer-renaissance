<?php
include "DBConn.php";
include "pastimes_helpers.php";

$sessionID = cartSessionID();
$userID = currentUserID();

$stmt = $conn->prepare("
    SELECT c.*, p.price
    FROM tblCart c
    JOIN tblClothes p ON c.clothID = p.clothID
    WHERE c.sessionID = ?
");

$stmt->bind_param("s", $sessionID);
$stmt->execute();

$cart = $stmt->get_result();

$total = 0;
$rows = [];

while ($r = $cart->fetch_assoc()) {
    $rows[] = $r;
    $total += $r['price'] * $r['quantity'];
}

$error = '';

if (isset($_POST['checkout']) && count($rows) > 0) {

    $name = trim($_POST['customerName']);
    $email = trim($_POST['customerEmail']);
    $address = trim($_POST['customerAddress']);

    $order = $conn->prepare("
        INSERT INTO tblOrder
        (userID, sessionID, customerName, customerEmail, customerAddress, totalAmount)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $order->bind_param(
        "issssd",
        $userID,
        $sessionID,
        $name,
        $email,
        $address,
        $total
    );

    if ($order->execute()) {

        $orderID = $conn->insert_id;

        foreach ($rows as $row) {

            $item = $conn->prepare("
                INSERT INTO tblOrderItem
                (orderID, clothID, quantity, price)
                VALUES (?, ?, ?, ?)
            ");

            $item->bind_param(
                "iiid",
                $orderID,
                $row['clothID'],
                $row['quantity'],
                $row['price']
            );

            $item->execute();
        }

        $clear = $conn->prepare("
            DELETE FROM tblCart
            WHERE sessionID = ?
        ");

        $clear->bind_param("s", $sessionID);
        $clear->execute();

        header("Location: orderConfirmation.php?orderID=" . $orderID);
        exit();

    } else {

        $error = "Could not complete checkout.";

    }
}
?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>Pastimes — Checkout</title>
    <link rel="stylesheet" href="pastimes.css">
</head>

<body>

<div class="layout">

<?php renderSidebar('cart'); ?>

<main class="main">

```
<div class="page-header">
    <div>
        <h1 class="page-title">Checkout</h1>
        <p class="page-sub">
            Complete your Pastimes purchase.
        </p>
    </div>

    <a class="btn btn-secondary" href="cart.php">
        Back to Cart
    </a>
</div>

<?php
if ($error) {
    echo '<div class="alert alert-error">' . e($error) . '</div>';
}

if (count($rows) == 0) {
    echo '<div class="card muted">Your cart is empty.</div>';
} else {
?>

<div class="card">

    <h2 class="product-title">
        Order Total: <?php echo money($total); ?>
    </h2>

    <form method="POST">

        <div class="field">
            <label>Full Name</label>
            <input type="text"
                   name="customerName"
                   required>
        </div>

        <div class="field">
            <label>Email Address</label>
            <input type="email"
                   name="customerEmail"
                   required>
        </div>

        <div class="field">
            <label>Delivery Address</label>
            <textarea name="customerAddress"
                      required></textarea>
        </div>

        <button class="btn" name="checkout">
            Complete Purchase
        </button>

    </form>

</div>

<?php } ?>
```

</main>

</div>

</body>
</html>
