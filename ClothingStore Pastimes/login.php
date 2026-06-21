<?php include "DBConn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pastimes — Login</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  :root {
    --bg:        #0d0d0d;
    --surface:   #151515;
    --surface2:  #1c1c1c;
    --border:    #2a2a2a;
    --border2:   #333;
    --text:      #f0ece4;
    --muted:     #6b6560;
    --accent:    #c8a97e;
    --accent2:   #e8c99a;
    --success:   #5a9e72;
    --error:     #c05a5a;
    --warning:   #b8934a;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1fr 1fr;
  }


  .brand-panel {
    background: var(--surface);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 3rem;
    position: relative;
    overflow: hidden;
  }
  .brand-panel::before {
    content: '';
    position: absolute;
    top: -80px; left: -80px;
    width: 320px; height: 320px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,169,126,0.08) 0%, transparent 70%);
    pointer-events: none;
  }
  .brand-panel::after {
    content: '';
    position: absolute;
    bottom: -60px; right: -60px;
    width: 240px; height: 240px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,169,126,0.06) 0%, transparent 70%);
    pointer-events: none;
  }

  .brand-logo {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .brand-logo .wordmark {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    font-weight: 700;
    color: var(--accent);
    letter-spacing: 0.04em;
  }
  .brand-logo .dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--accent);
    margin-top: 2px;
  }

  .brand-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 1.5rem;
  }
  .brand-headline {
    font-family: 'Playfair Display', serif;
    font-size: clamp(28px, 3vw, 42px);
    line-height: 1.2;
    color: var(--text);
    font-weight: 500;
  }
  .brand-headline em {
    font-style: italic;
    color: var(--accent);
  }
  .brand-desc {
    font-size: 14px;
    color: var(--muted);
    line-height: 1.7;
    max-width: 320px;
  }

  .brand-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 0.5rem;
  }
  .tag {
    font-size: 11px;
    font-weight: 500;
    padding: 4px 12px;
    border-radius: 20px;
    border: 1px solid var(--border2);
    color: var(--muted);
    letter-spacing: 0.04em;
    text-transform: uppercase;
  }

  .brand-footer {
    font-size: 11px;
    color: #3a3a3a;
    letter-spacing: 0.04em;
  }

 
  .form-panel {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 2.5rem;
    background: var(--bg);
  }
  .form-inner { width: 100%; max-width: 360px; }

  .form-header { margin-bottom: 2rem; }
  .form-title {
    font-family: 'Playfair Display', serif;
    font-size: 26px;
    font-weight: 500;
    color: var(--text);
    margin-bottom: 6px;
  }
  .form-sub { font-size: 13px; color: var(--muted); }

  .divider {
    width: 32px; height: 2px;
    background: var(--accent);
    border-radius: 2px;
    margin: 1rem 0;
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
    background: var(--surface);
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
  .field input::placeholder { color: #3a3632; }

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

  .alert {
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 13px;
    margin-top: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .alert-success { background: rgba(90,158,114,0.1); color: #7bcb96; border: 1px solid rgba(90,158,114,0.2); }
  .alert-error   { background: rgba(192,90,90,0.1);  color: #e08080; border: 1px solid rgba(192,90,90,0.2); }
  .alert-warning { background: rgba(184,147,74,0.1); color: #d4a85a; border: 1px solid rgba(184,147,74,0.2); }

  .footer-link {
    text-align: center;
    margin-top: 1.5rem;
    font-size: 13px;
    color: var(--muted);
  }
  .footer-link a { color: var(--accent); text-decoration: none; }
  .footer-link a:hover { text-decoration: underline; }

  @media (max-width: 700px) {
    body { grid-template-columns: 1fr; }
    .brand-panel { display: none; }
  }
</style>
</head>
<body>


<div class="brand-panel">
  <div class="brand-logo">
    <div class="dot"></div>
    <span class="wordmark">PASTIMES</span>
  </div>
  <div class="brand-body">
    <h2 class="brand-headline">Pre-loved.<br><em>Premium</em><br>brands.</h2>
    <p class="brand-desc">Buy and sell second-hand branded clothing in excellent condition — sustainably and affordably.</p>
    <div class="brand-tags">
      <span class="tag">Like New</span>
      <span class="tag">Good</span>
      <span class="tag">Fair</span>
    </div>
  </div>
  <div class="brand-footer">&copy; 2025 Pastimes &middot; All rights reserved</div>
</div>


<div class="form-panel">
  <div class="form-inner">
    <div class="form-header">
      <p class="form-title">Welcome back</p>
      <div class="divider"></div>
      <p class="form-sub">Enter your credentials to continue</p>
    </div>

    <form method="POST">
      <div class="field">
        <label>Email Address</label>
        <input type="email" name="email" placeholder="you@example.com" required
          value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
      </div>
      <div class="field">
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>
      <button class="btn" name="login">Sign In</button>
    </form>

    <?php
    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $pass  = md5($_POST['password']);
        $sql   = "SELECT * FROM tblUser WHERE email='$email' AND password='$pass'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $user = $result->fetch_assoc();
            if($user['status'] == 'verified'){
                echo "<div class='alert alert-success'>&#10003; Welcome, " . htmlspecialchars($user['fullName']) . "! You are now logged in.</div>";
            } else {
                echo "<div class='alert alert-warning'>&#9888; Your account is awaiting admin approval.</div>";
            }
        } else {
            echo "<div class='alert alert-error'>&#10007; Invalid email or password.</div>";
        }
    }
    ?>

    <p class="footer-link">Don't have an account? <a href="register.php">Create one</a></p>
  </div>
</div>
</body>
</html>