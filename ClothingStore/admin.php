<?php include "DBConn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pastimes — Admin Panel</title>
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
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    display: flex;
  }

 
  .sidebar {
    width: 220px;
    flex-shrink: 0;
    background: var(--surface);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    padding: 2rem 1.25rem;
    position: sticky;
    top: 0;
    height: 100vh;
  }
  .sidebar-logo {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 2.5rem;
  }
  .sidebar-logo .dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--accent);
  }
  .sidebar-logo .wordmark {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    font-weight: 700;
    color: var(--accent);
    letter-spacing: 0.04em;
  }

  .sidebar-label {
    font-size: 10px;
    font-weight: 600;
    color: #3a3632;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 10px;
    padding: 0 4px;
  }
  .nav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 10px;
    border-radius: 7px;
    font-size: 13px;
    font-weight: 500;
    color: var(--muted);
    cursor: pointer;
    transition: background 0.15s, color 0.15s;
    margin-bottom: 2px;
    text-decoration: none;
  }
  .nav-item:hover, .nav-item.active {
    background: var(--surface2);
    color: var(--text);
  }
  .nav-item .nav-icon { font-size: 14px; width: 18px; text-align: center; }

  .sidebar-footer {
    margin-top: auto;
    font-size: 11px;
    color: #2e2b28;
  }


  .main {
    flex: 1;
    padding: 2.5rem;
    overflow-y: auto;
  }

  .page-header {
    margin-bottom: 2rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid var(--border);
  }
  .page-title {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    font-weight: 500;
    color: var(--text);
  }
  .page-sub { font-size: 13px; color: var(--muted); margin-top: 4px; }

  .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
  .grid-full { grid-column: 1 / -1; }

  .card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1.5rem;
  }

  .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.25rem;
  }
  .section-title {
    font-size: 11px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
  }
  .count-badge {
    font-size: 11px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 20px;
    background: rgba(200,169,126,0.12);
    color: var(--accent);
    border: 1px solid rgba(200,169,126,0.2);
  }

  .user-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid var(--border);
  }
  .user-row:last-child { border-bottom: none; }

  .avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2a2016, #3d3020);
    border: 1px solid rgba(200,169,126,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px;
    font-weight: 600;
    color: var(--accent);
    flex-shrink: 0;
  }
  .user-info { flex: 1; min-width: 0; }
  .user-name { font-size: 14px; font-weight: 500; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .user-email { font-size: 12px; color: var(--muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

  .badge {
    font-size: 10px;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 20px;
    white-space: nowrap;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }
  .badge-pending  { background: rgba(184,147,74,0.12); color: #d4a85a; border: 1px solid rgba(184,147,74,0.25); }
  .badge-verified { background: rgba(90,158,114,0.12); color: #7bcb96; border: 1px solid rgba(90,158,114,0.25); }

  .actions { display: flex; gap: 6px; flex-shrink: 0; }
  .action-btn {
    padding: 5px 11px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    border: none;
    transition: background 0.15s;
    text-decoration: none;
    display: inline-block;
    white-space: nowrap;
  }
  .btn-verify { background: rgba(90,158,114,0.12); color: #7bcb96; border: 1px solid rgba(90,158,114,0.25); }
  .btn-verify:hover { background: rgba(90,158,114,0.22); }
  .btn-edit   { background: rgba(200,169,126,0.1); color: var(--accent); border: 1px solid rgba(200,169,126,0.2); }
  .btn-edit:hover { background: rgba(200,169,126,0.18); }
  .btn-delete { background: rgba(192,90,90,0.1); color: #e08080; border: 1px solid rgba(192,90,90,0.2); }
  .btn-delete:hover { background: rgba(192,90,90,0.2); }

  .empty { font-size: 13px; color: #3a3632; padding: 6px 0; font-style: italic; }

 
  .field { margin-bottom: 14px; }
  .field label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 6px;
  }
  .field input {
    width: 100%;
    padding: 10px 13px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    color: var(--text);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  .field input:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(200,169,126,0.08);
  }
  .field input::placeholder { color: #3a3632; }

  .btn-add {
    width: 100%;
    padding: 11px;
    border: none;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 6px;
    background: var(--accent);
    color: #0d0d0d;
    letter-spacing: 0.03em;
    transition: background 0.2s, transform 0.15s;
  }
  .btn-add:hover { background: var(--accent2); transform: translateY(-1px); }

  .alert {
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 13px;
    margin-top: 12px;
    display: flex; align-items: center; gap: 8px;
  }
  .alert-success { background: rgba(90,158,114,0.1); color: #7bcb96; border: 1px solid rgba(90,158,114,0.2); }

  @media (max-width: 860px) {
    .grid { grid-template-columns: 1fr; }
    .sidebar { display: none; }
  }
</style>
</head>
<body>


<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="dot"></div>
    <span class="wordmark">PASTIMES</span>
  </div>
  <p class="sidebar-label">Navigation</p>
  <a class="nav-item active" href="admin.php"><span class="nav-icon">&#9632;</span> Dashboard</a>
  <a class="nav-item" href="register.php"><span class="nav-icon">&#43;</span> Add User</a>
  <a class="nav-item" href="login.php"><span class="nav-icon">&#8594;</span> Back to Login</a>
  <div class="sidebar-footer">&copy; 2025 Pastimes</div>
</aside>


<main class="main">
  <div class="page-header">
    <h1 class="page-title">Admin Panel</h1>
    <p class="page-sub">Manage users, approvals, and accounts</p>
  </div>

  <div class="grid">

  
    <div class="card">
      <?php
        $pendingResult = $conn->query("SELECT * FROM tblUser WHERE status='pending'");
        $pendingCount  = $pendingResult->num_rows;
      ?>
      <div class="section-header">
        <span class="section-title">Pending Approval</span>
        <span class="count-badge"><?php echo $pendingCount; ?></span>
      </div>
      <?php
      if($pendingCount == 0){
          echo "<p class='empty'>No pending users.</p>";
      }
      while($row = $pendingResult->fetch_assoc()){
          $initials = strtoupper(substr($row['fullName'], 0, 1));
          echo "
          <div class='user-row'>
            <div class='avatar'>{$initials}</div>
            <div class='user-info'>
              <div class='user-name'>" . htmlspecialchars($row['fullName']) . "</div>
              <div class='user-email'>" . htmlspecialchars($row['email']) . "</div>
            </div>
            <span class='badge badge-pending'>Pending</span>
            <div class='actions'>
              <a class='action-btn btn-verify' href='verify.php?id={$row['userID']}'>Verify</a>
            </div>
          </div>";
      }
      ?>
    </div>

   
    <div class="card">
      <div class="section-header">
        <span class="section-title">Add New User</span>
      </div>
      <form method="POST">
        <div class="field">
          <label>Full Name</label>
          <input type="text" name="name" placeholder="Full Name" required>
        </div>
        <div class="field">
          <label>Email</label>
          <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="field">
          <label>Password</label>
          <input type="password" name="password" placeholder="Password" required>
        </div>
        <button class="btn-add" name="add">Add User</button>
      </form>
      <?php
      if(isset($_POST['add'])){
          $name  = $_POST['name'];
          $email = $_POST['email'];
          $pass  = md5($_POST['password']);
          $conn->query("INSERT INTO tblUser(fullName,email,password,status)
                        VALUES('$name','$email','$pass','verified')");
          echo "<div class='alert alert-success'>&#10003; User added successfully.</div>";
      }
      ?>
    </div>

    <div class="card grid-full">
      <div class="section-header">
        <span class="section-title">All Users</span>
        <?php
          $allResult = $conn->query("SELECT COUNT(*) as total FROM tblUser");
          $allRow    = $allResult->fetch_assoc();
          echo "<span class='count-badge'>{$allRow['total']}</span>";
        ?>
      </div>
      <?php
      $result = $conn->query("SELECT * FROM tblUser ORDER BY status ASC, fullName ASC");
      while($row = $result->fetch_assoc()){
          $initials   = strtoupper(substr($row['fullName'], 0, 1));
          $badgeClass = $row['status'] == 'verified' ? 'badge-verified' : 'badge-pending';
          $badgeLabel = ucfirst($row['status']);
          echo "
          <div class='user-row'>
            <div class='avatar'>{$initials}</div>
            <div class='user-info'>
              <div class='user-name'>" . htmlspecialchars($row['fullName']) . "</div>
              <div class='user-email'>" . htmlspecialchars($row['email']) . "</div>
            </div>
            <span class='badge {$badgeClass}'>{$badgeLabel}</span>
            <div class='actions'>
              <a class='action-btn btn-edit'   href='edit.php?id={$row['userID']}'>Edit</a>
              <a class='action-btn btn-delete' href='delete.php?id={$row['userID']}'>Delete</a>
            </div>
          </div>";
      }
      ?>
    </div>

  </div>
</main>

</body>
</html>