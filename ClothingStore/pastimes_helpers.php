<?php
// Shared helper functions for the Pastimes feature pages.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function currentUserID() {
    return isset($_SESSION['userID']) ? (int)$_SESSION['userID'] : null;
}

function cartSessionID() {
    return session_id();
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function money($value) {
    return 'R ' . number_format((float)$value, 2);
}

function saveUploadedImage($fieldName, $oldPath = '') {
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        return $oldPath;
    }
    if ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        return $oldPath;
    }

    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $original = basename($_FILES[$fieldName]['name']);
    $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        return $oldPath;
    }

    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    $fileName = uniqid('pastimes_', true) . '.' . $ext;
    $target = 'uploads/' . $fileName;
    if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $target)) {
        return $target;
    }
    return $oldPath;
}

function renderSidebar($active = '') {
    $items = [
        ['admin.php', 'Dashboard', '■', 'admin'],
        ['viewClothing.php', 'Clothing', '◈', 'clothing'],
        ['addClothing.php', 'Add Clothing', '+', 'addClothing'],
        ['cart.php', 'Cart', '🛒', 'cart'],
        ['sellerRequest.php', 'Sell Item', '⇧', 'sellerRequest'],
        ['viewRequests.php', 'Seller Requests', '☑', 'requests'],
        ['contactBuyer.php', 'Contact Buyer', '✉', 'buyer'],
        ['contactSeller.php', 'Contact Seller', '✉', 'seller'],
        ['login.php', 'Login', '→', 'login']
    ];
    echo '<aside class="sidebar"><div class="logo"><span class="dot"></span><span class="wordmark">PASTIMES</span></div><p class="nav-label">Navigation</p>';
    foreach ($items as $item) {
        $class = $active === $item[3] ? 'nav-item active' : 'nav-item';
        echo '<a class="' . $class . '" href="' . $item[0] . '"><span>' . $item[2] . '</span> ' . $item[1] . '</a>';
    }
    echo '<p class="nav-label">© 2025 Pastimes</p></aside>';
}
?>
