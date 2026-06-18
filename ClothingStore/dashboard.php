<?php
include "DBConn.php";
include "pastimes_helpers.php";

// Redirect to login if not logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}

$userName = $_SESSION['userName'] ?? 'Guest';
$userInitial = strtoupper(substr($userName, 0, 1));

// Stats
$totalUsers    = $conn->query("SELECT COUNT(*) AS c FROM tblUser")->fetch_assoc()['c'] ?? 0;
$pendingUsers  = $conn->query("SELECT COUNT(*) AS c FROM tblUser WHERE status='pending'")->fetch_assoc()['c'] ?? 0;
$totalClothes  = $conn->query("SELECT COUNT(*) AS c FROM tblClothes")->fetch_assoc()['c'] ?? 0;
$totalOrders   = $conn->query("SELECT COUNT(*) AS c FROM tblOrder")->fetch_assoc()['c'] ?? 0;
$totalRevenue  = $conn->query("SELECT COALESCE(SUM(totalAmount),0) AS r FROM tblOrder")->fetch_assoc()['r'] ?? 0;
$pendingRequests = $conn->query("SELECT COUNT(*) AS c FROM tblSellerRequest WHERE status='pending'")->fetch_assoc()['c'] ?? 0;

// Recent orders
$recentOrders = $conn->query("SELECT * FROM tblOrder ORDER BY orderDate DESC LIMIT 5");

// Recent clothing
$recentClothes = $conn->query("SELECT * FROM tblClothes ORDER BY created_at DESC LIMIT 4");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pastimes — Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
:root {
  --bg:       #0d0d0d;
  --surface:  #151515;
  --surface2: #1c1c1c;
  --border:   #2a2a2a;
  --border2:  #333;
  --text:     #f0ece4;
  --muted:    #6b6560;
  --accent:   #c8a97e;
  --accent2:  #e8c99a;
  --success:  #5a9e72;
  --error:    #c05a5a;
  --warning:  #b8934a;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
  font-family: 'DM Sans', sans-serif;
  background: var(--bg);
  color: var(--text);
  min-height: 100vh;
  display: flex;
}

/* ── Sidebar ── */
.sidebar {
  width: 230px;
  flex-shrink: 0;
  background: var(--surface);
  border-right: 1px solid var(--border);
  padding: 2rem 1.25rem;
  position: sticky;
  top: 0;
  height: 100vh;
  display: flex;
  flex-direction: column;
  overflow-y: auto;
}
.logo {
  display: flex;
  align-items: center;
  gap: 9px;
  margin-bottom: 2.5rem;
}
.dot { width: 6px; height: 6px; border-radius: 50%; background: var(--accent); }
.wordmark {
  font-family: 'Playfair Display', serif;
  color: var(--accent);
  font-size: 20px;
  font-weight: 700;
  letter-spacing: .04em;
}
.nav-label {
  font-size: 10px;
  color: #3a3632;
  text-transform: uppercase;
  letter-spacing: .1em;
  margin: 1.3rem 0 .6rem;
}
.nav-item {
  display: flex;
  gap: 10px;
  align-items: center;
  padding: 9px 10px;
  border-radius: 8px;
  color: var(--muted);
  text-decoration: none;
  font-size: 13px;
  font-weight: 500;
  margin-bottom: 3px;
  transition: background .15s, color .15s;
}
.nav-item:hover, .nav-item.active {
  background: var(--surface2);
  color: var(--text);
}
.nav-item .icon { font-size: 15px; width: 18px; text-align: center; flex-shrink: 0; }

.sidebar-user {
  margin-top: auto;
  padding-top: 1.25rem;
  border-top: 1px solid var(--border);
  display: flex;
  align-items: center;
  gap: 10px;
}
.sidebar-avatar {
  width: 34px; height: 34px;
  border-radius: 50%;
  background: linear-gradient(135deg, #2a2016, #3d3020);
  border: 1px solid rgba(200,169,126,.25);
  display: flex; align-items: center; justify-content: center;
  font-size: 13px; font-weight: 700; color: var(--accent);
  flex-shrink: 0;
}
.sidebar-user-name { font-size: 13px; font-weight: 500; color: var(--text); }
.sidebar-user-role { font-size: 11px; color: var(--muted); }

/* ── Main ── */
.main { flex: 1; overflow-y: auto; }

/* ── Top bar ── */
.topbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1.5rem 2.5rem;
  border-bottom: 1px solid var(--border);
  background: var(--surface);
  position: sticky;
  top: 0;
  z-index: 10;
}
.topbar-title {
  font-family: 'Playfair Display', serif;
  font-size: 22px;
  font-weight: 500;
}
.topbar-right { display: flex; align-items: center; gap: 12px; }
.topbar-date { font-size: 12px; color: var(--muted); }
.logout-btn {
  padding: 7px 14px;
  border-radius: 7px;
  font-size: 12px;
  font-weight: 600;
  font-family: 'DM Sans', sans-serif;
  background: transparent;
  border: 1px solid var(--border2);
  color: var(--muted);
  cursor: pointer;
  text-decoration: none;
  transition: border-color .15s, color .15s;
}
.logout-btn:hover { border-color: var(--accent); color: var(--accent); }

/* ── Content ── */
.content { padding: 2rem 2.5rem; }

/* ── Welcome banner ── */
.welcome-banner {
  background: linear-gradient(135deg, #1a1508 0%, #1c1c1c 60%);
  border: 1px solid rgba(200,169,126,.15);
  border-radius: 16px;
  padding: 1.75rem 2rem;
  margin-bottom: 1.75rem;
  position: relative;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.welcome-banner::before {
  content: '';
  position: absolute;
  right: -60px; top: -60px;
  width: 220px; height: 220px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(200,169,126,.12) 0%, transparent 70%);
}
.welcome-text h2 {
  font-family: 'Playfair Display', serif;
  font-size: 24px;
  font-weight: 500;
  margin-bottom: 5px;
}
.welcome-text h2 em { font-style: italic; color: var(--accent); }
.welcome-text p { font-size: 13px; color: var(--muted); }
.welcome-actions { display: flex; gap: 10px; position: relative; z-index: 1; }
.btn {
  display: inline-block;
  padding: 9px 18px;
  border-radius: 8px;
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  text-decoration: none;
  border: none;
  transition: .15s;
}
.btn-primary { background: var(--accent); color: #0d0d0d; }
.btn-primary:hover { background: var(--accent2); transform: translateY(-1px); }
.btn-ghost { background: transparent; border: 1px solid var(--border2); color: var(--muted); }
.btn-ghost:hover { border-color: var(--accent); color: var(--accent); }

/* ── Stat cards ── */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
  gap: 1rem;
  margin-bottom: 1.75rem;
}
.stat-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 1.25rem 1.25rem 1rem;
  position: relative;
  overflow: hidden;
  transition: border-color .2s;
}
.stat-card:hover { border-color: rgba(200,169,126,.3); }
.stat-card::after {
  content: '';
  position: absolute;
  bottom: -20px; right: -20px;
  width: 80px; height: 80px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(200,169,126,.06) 0%, transparent 70%);
}
.stat-icon {
  font-size: 20px;
  margin-bottom: .6rem;
  display: block;
}
.stat-value {
  font-family: 'Playfair Display', serif;
  font-size: 30px;
  font-weight: 500;
  line-height: 1;
  color: var(--text);
  margin-bottom: 4px;
}
.stat-value.accent { color: var(--accent2); }
.stat-label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: .07em; font-weight: 600; }
.stat-badge {
  position: absolute;
  top: 1rem; right: 1rem;
  font-size: 10px;
  font-weight: 700;
  padding: 2px 7px;
  border-radius: 20px;
  background: rgba(200,169,126,.12);
  color: var(--accent);
  border: 1px solid rgba(200,169,126,.2);
}
.stat-badge.red {
  background: rgba(192,90,90,.12);
  color: #e08080;
  border-color: rgba(192,90,90,.2);
}

/* ── Two-col grid ── */
.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.75rem; }

/* ── Section card ── */
.section-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 1.25rem 1.5rem;
}
.section-head {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}
.section-title {
  font-size: 11px;
  font-weight: 700;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: .09em;
}
.section-link {
  font-size: 12px;
  color: var(--accent);
  text-decoration: none;
  font-weight: 500;
}
.section-link:hover { text-decoration: underline; }

/* ── Recent orders table ── */
.order-row {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 9px 0;
  border-bottom: 1px solid var(--border);
}
.order-row:last-child { border-bottom: none; }
.order-num { font-size: 12px; font-weight: 600; color: var(--accent); min-width: 48px; }
.order-info { flex: 1; }
.order-name { font-size: 13px; font-weight: 500; color: var(--text); }
.order-email { font-size: 11px; color: var(--muted); }
.order-amount { font-size: 14px; font-weight: 600; color: var(--accent2); white-space: nowrap; }
.order-status {
  font-size: 10px;
  font-weight: 700;
  padding: 3px 9px;
  border-radius: 20px;
  text-transform: uppercase;
  letter-spacing: .05em;
  background: rgba(90,158,114,.12);
  color: #7bcb96;
  border: 1px solid rgba(90,158,114,.2);
  white-space: nowrap;
}
.empty-state { font-size: 13px; color: var(--muted); font-style: italic; padding: 8px 0; }

/* ── Recent clothing grid ── */
.clothes-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: .75rem;
}
.clothes-thumb {
  border-radius: 10px;
  overflow: hidden;
  border: 1px solid var(--border);
  position: relative;
  aspect-ratio: 1;
  background: var(--surface2);
}
.clothes-thumb img {
  width: 100%; height: 100%;
  object-fit: cover;
  display: block;
}
.clothes-thumb-info {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  background: linear-gradient(to top, rgba(0,0,0,.85) 0%, transparent 100%);
  padding: .6rem .7rem .5rem;
}
.clothes-thumb-name { font-size: 12px; font-weight: 600; color: var(--text); line-height: 1.3; }
.clothes-thumb-price { font-size: 11px; color: var(--accent2); font-weight: 600; }
.clothes-placeholder {
  width: 100%; height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  color: var(--border2);
}

/* ── Quick actions ── */
.actions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
  gap: .75rem;
  margin-bottom: 1.75rem;
}
.action-tile {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 12px;
  padding: 1.1rem 1rem;
  text-decoration: none;
  text-align: center;
  transition: border-color .2s, background .2s;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
}
.action-tile:hover {
  border-color: rgba(200,169,126,.35);
  background: #1a1508;
}
.action-tile-icon { font-size: 22px; }
.action-tile-label { font-size: 12px; font-weight: 600; color: var(--muted); }
.action-tile:hover .action-tile-label { color: var(--accent); }

/* ── Section label ── */
.section-heading {
  font-size: 11px;
  font-weight: 700;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: .09em;
  margin-bottom: .75rem;
}

@media (max-width: 900px) {
  .sidebar { display: none; }
  .two-col { grid-template-columns: 1fr; }
  .welcome-actions { display: none; }
  .stats-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 600px) {
  .content { padding: 1.25rem; }
  .topbar { padding: 1rem 1.25rem; }
}
</style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
  <div class="logo">
    <div class="dot"></div>
    <span class="wordmark">PASTIMES</span>
  </div>
  <p class="nav-label">Main</p>
  <a class="nav-item active" href="dashboard.php"><span class="icon">◈</span> Dashboard</a>
  <a class="nav-item" href="viewClothing.php"><span class="icon">👗</span> Clothing</a>
  <a class="nav-item" href="addClothing.php"><span class="icon">＋</span> Add Clothing</a>
  <a class="nav-item" href="cart.php"><span class="icon">🛒</span> Cart</a>
  <p class="nav-label">Admin</p>
  <a class="nav-item" href="admin.php"><span class="icon">■</span> Users</a>
  <a class="nav-item" href="viewRequests.php"><span class="icon">☑</span> Seller Requests <?php if($pendingRequests > 0) echo "<span style='margin-left:auto;background:rgba(200,169,126,.15);color:var(--accent);font-size:10px;font-weight:700;padding:1px 7px;border-radius:20px;'>{$pendingRequests}</span>"; ?></a>
  <a class="nav-item" href="sellerRequest.php"><span class="icon">⇧</span> Sell Item</a>
  <p class="nav-label">Messaging</p>
  <a class="nav-item" href="contactBuyer.php"><span class="icon">✉</span> Contact Buyer</a>
  <a class="nav-item" href="contactSeller.php"><span class="icon">✉</span> Contact Seller</a>
  <div class="sidebar-user">
    <div class="sidebar-avatar"><?php echo $userInitial; ?></div>
    <div>
      <div class="sidebar-user-name"><?php echo htmlspecialchars($userName); ?></div>
      <div class="sidebar-user-role">Admin</div>
    </div>
  </div>
</aside>

<!-- Main -->
<div class="main">

  <!-- Topbar -->
  <div class="topbar">
    <div class="topbar-title">Dashboard</div>
    <div class="topbar-right">
      <span class="topbar-date"><?php echo date('D, d M Y'); ?></span>
      <a class="logout-btn" href="logout.php">Sign out</a>
    </div>
  </div>

  <div class="content">

    <!-- Welcome Banner -->
    <div class="welcome-banner">
      <div class="welcome-text">
        <h2>Welcome back, <em><?php echo htmlspecialchars(explode(' ', $userName)[0]); ?></em></h2>
        <p>Here's what's happening in your store today.</p>
      </div>
      <div class="welcome-actions">
        <a class="btn btn-primary" href="addClothing.php">+ Add Clothing</a>
        <a class="btn btn-ghost" href="viewClothing.php">View Store</a>
      </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card">
        <span class="stat-icon">👗</span>
        <div class="stat-value"><?php echo $totalClothes; ?></div>
        <div class="stat-label">Items Listed</div>
      </div>
      <div class="stat-card">
        <span class="stat-icon">📦</span>
        <div class="stat-value"><?php echo $totalOrders; ?></div>
        <div class="stat-label">Total Orders</div>
      </div>
      <div class="stat-card">
        <span class="stat-icon">💰</span>
        <div class="stat-value accent" style="font-size:22px;">R <?php echo number_format($totalRevenue, 0); ?></div>
        <div class="stat-label">Revenue</div>
      </div>
      <div class="stat-card">
        <span class="stat-icon">👥</span>
        <div class="stat-value"><?php echo $totalUsers; ?></div>
        <div class="stat-label">Registered Users</div>
        <?php if($pendingUsers > 0) echo "<div class='stat-badge red'>{$pendingUsers} pending</div>"; ?>
      </div>
      <div class="stat-card">
        <span class="stat-icon">📋</span>
        <div class="stat-value"><?php echo $pendingRequests; ?></div>
        <div class="stat-label">Seller Requests</div>
        <?php if($pendingRequests > 0) echo "<div class='stat-badge'>{$pendingRequests} new</div>"; ?>
      </div>
    </div>

    <!-- Quick Actions -->
    <p class="section-heading">Quick Actions</p>
    <div class="actions-grid">
      <a class="action-tile" href="addClothing.php">
        <span class="action-tile-icon">➕</span>
        <span class="action-tile-label">Add Clothing</span>
      </a>
      <a class="action-tile" href="viewRequests.php">
        <span class="action-tile-icon">☑</span>
        <span class="action-tile-label">Approve Sellers</span>
      </a>
      <a class="action-tile" href="admin.php">
        <span class="action-tile-icon">👤</span>
        <span class="action-tile-label">Manage Users</span>
      </a>
      <a class="action-tile" href="contactBuyer.php">
        <span class="action-tile-icon">✉</span>
        <span class="action-tile-label">Message Buyer</span>
      </a>
      <a class="action-tile" href="contactSeller.php">
        <span class="action-tile-icon">📨</span>
        <span class="action-tile-label">Message Seller</span>
      </a>
      <a class="action-tile" href="cart.php">
        <span class="action-tile-icon">🛒</span>
        <span class="action-tile-label">View Cart</span>
      </a>
    </div>

    <!-- Two columns: Recent Orders + Recent Clothing -->
    <div class="two-col">

      <!-- Recent Orders -->
      <div class="section-card">
        <div class="section-head">
          <span class="section-title">Recent Orders</span>
          <a class="section-link" href="viewOrders.php">View all →</a>
        </div>
        <?php if(!$recentOrders || $recentOrders->num_rows === 0): ?>
          <p class="empty-state">No orders yet.</p>
        <?php else: ?>
          <?php while($order = $recentOrders->fetch_assoc()): ?>
          <div class="order-row">
            <div class="order-num">#<?php echo $order['orderID']; ?></div>
            <div class="order-info">
              <div class="order-name"><?php echo htmlspecialchars($order['customerName']); ?></div>
              <div class="order-email"><?php echo htmlspecialchars($order['customerEmail']); ?></div>
            </div>
            <div class="order-amount">R <?php echo number_format($order['totalAmount'], 2); ?></div>
            <div class="order-status"><?php echo htmlspecialchars($order['status']); ?></div>
          </div>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>

      <!-- Recent Clothing -->
      <div class="section-card">
        <div class="section-head">
          <span class="section-title">Recent Listings</span>
          <a class="section-link" href="viewClothing.php">View all →</a>
        </div>
        <?php if(!$recentClothes || $recentClothes->num_rows === 0): ?>
          <p class="empty-state">No clothing listed yet.</p>
        <?php else: ?>
        <div class="clothes-grid">
          <?php while($item = $recentClothes->fetch_assoc()): ?>
          <a href="editClothing.php?id=<?php echo $item['clothID']; ?>" style="text-decoration:none;">
            <div class="clothes-thumb">
              <?php if($item['image']): ?>
                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
              <?php else: ?>
                <div class="clothes-placeholder">👗</div>
              <?php endif; ?>
              <div class="clothes-thumb-info">
                <div class="clothes-thumb-name"><?php echo htmlspecialchars($item['name']); ?></div>
                <div class="clothes-thumb-price">R <?php echo number_format($item['price'], 2); ?></div>
              </div>
            </div>
          </a>
          <?php endwhile; ?>
        </div>
        <?php endif; ?>
      </div>

    </div>

  </div><!-- /content -->
</div><!-- /main -->

</body>
</html>
