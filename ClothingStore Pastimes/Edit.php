<?php include "DBConn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pastimes — Edit User</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  :root {
    --bg:      #0d0d0d;
    --surface: #151515;
    --border:  #2a2a2a;
    --text:    #f0ece4;
    --muted:   #6b6560;
    --accent:  #c8a97e;
    --accent2: #e8c99a;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
  }
  .container { width: 100%; max-width: 420px; }

  .back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: var(--muted);
    text-decoration: none;
    margin-bottom: 1.5rem;
    transition: color 0.15s;
  }
  .back-link:hover { color: var(--accent); }

  .logo { text-align: center; margin-bottom: 2rem; }
  .wordmark {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    font-weight: 700;
    color: var(--accent);
    letter-spacing: 0.04em;
  }

  .card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1.75rem;
  }
  .card-title {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    font-weight: 500;
    color: var(--text);
    margin-bottom: 6px;
  }
  .divider {
    width: 28px; height: 2px;
    background: var(--accent);
    border-radius: 2px;
    margin: 12px 0 1.25rem;
  }

  .field { margin-bottom: 16px; }
  .field label {
    display: block;
    font-size: 11px;
    font-weight: 600;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 7px;
  }
  .field input {
    width: 100%;
    padding: 11px 14px;
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
    box-shadow: 0 0 0 3px rgba(200,169,126,0.1);
  }

  .btn {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 8px;
    background: var(--accent);
    color: #0d0d0d;
    letter-spacing: 0.03em;
    transition: background 0.2s, transform 0.15s;
  }
  .btn:hover { background: var(--accent2); transform: translateY(-1px); }
</style>
</head>
<body>
<div class="container">
  <a class="back-link" href="admin.php">&#8592; Back to Admin</a>

  <div class="logo">
    <span class="wordmark">PASTIMES</span>
  </div>

  <?php
  $id     = $_GET['id'];
  $result = $conn->query("SELECT * FROM tblUser WHERE userID=$id");
  $user   = $result->fetch_assoc();
  ?>

  <div class="card">
    <p class="card-title">Edit User</p>
    <div class="divider"></div>

    <form method="POST">
      <div class="field">
        <label>Full Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['fullName']); ?>" required>
      </div>
      <div class="field">
        <label>Email Address</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
      </div>
      <button class="btn" name="update">Save Changes</button>
    </form>
  </div>

  <?php
  if(isset($_POST['update'])){
      $name  = $_POST['name'];
      $email = $_POST['email'];
      $conn->query("UPDATE tblUser SET fullName='$name', email='$email' WHERE userID=$id");
      header("Location: admin.php");
  }
  ?>
</div>
</body>
</html>