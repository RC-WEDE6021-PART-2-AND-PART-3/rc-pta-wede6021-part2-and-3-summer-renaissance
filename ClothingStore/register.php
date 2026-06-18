<?php include "DBConn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pastimes — Register</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  :root {
    --bg:       #0d0d0d;
    --surface:  #151515;
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
    top: -80px; right: -80px;
    width: 300px; height: 300px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,169,126,0.07) 0%, transparent 70%);
    pointer-events: none;
  }

  .brand-logo {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .brand-logo .dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--accent);
    margin-top: 2px;
  }
  .brand-logo .wordmark {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    font-weight: 700;
    color: var(--accent);
    letter-spacing: 0.04em;
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
    font-size: clamp(26px, 2.8vw, 40px);
    line-height: 1.25;
    font-weight: 500;
    color: var(--text);
  }
  .brand-headline em { font-style: italic; color: var(--accent); }

  .steps { display: flex; flex-direction: column; gap: 16px; margin-top: 0.5rem; }
  .step { display: flex; align-items: flex-start; gap: 14px; }
  .step-num {
    width: 24px; height: 24px;
    border-radius: 50%;
    border: 1px solid var(--accent);
    color: var(--accent);
    font-size: 11px;
    font-weight: 600;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
  }
  .step-text { font-size: 13px; color: var(--muted); line-height: 1.6; }
  .step-text strong { color: var(--text); font-weight: 500; }

  .brand-footer { font-size: 11px; color: #3a3a3a; letter-spacing: 0.04em; }

  
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
  .divider {
    width: 32px; height: 2px;
    background: var(--accent);
    border-radius: 2px;
    margin: 1rem 0;
  }
  .form-sub { font-size: 13px; color: var(--muted); line-height: 1.6; }

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
    <h2 class="brand-headline">Join the<br><em>community</em><br>of conscious<br>fashion.</h2>
    <div class="steps">
      <div class="step">
        <div class="step-num">1</div>
        <p class="step-text"><strong>Create your account</strong> — fill in your details below.</p>
      </div>
      <div class="step">
        <div class="step-num">2</div>
        <p class="step-text"><strong>Admin approval</strong> — your account is reviewed before activation.</p>
      </div>
      <div class="step">
        <div class="step-num">3</div>
        <p class="step-text"><strong>Start shopping</strong> — browse pre-loved branded clothing at great prices.</p>
      </div>
    </div>
  </div>
  <div class="brand-footer">&copy; 2025 Pastimes &middot; All rights reserved</div>
</div>


<div class="form-panel">
  <div class="form-inner">
    <div class="form-header">
      <p class="form-title">Create account</p>
      <div class="divider"></div>
      <p class="form-sub">Your account will need admin approval before you can sign in.</p>
    </div>

    <form method="POST">
      <div class="field">
        <label>Full Name</label>
        <input type="text" name="name" placeholder="e.g. Thandi Khumalo" required>
      </div>
      <div class="field">
        <label>Email Address</label>
        <input type="email" name="email" placeholder="you@example.com" required>
      </div>
      <div class="field">
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>
      <button class="btn" name="register">Create Account</button>
    </form>

    <?php
    if(isset($_POST['register'])){
        $name  = $_POST['name'];
        $email = $_POST['email'];
        $pass  = md5($_POST['password']);
        $conn->query("INSERT INTO tblUser(fullName,email,password)
                      VALUES('$name','$email','$pass')");
        echo "<div class='alert alert-success'>&#10003; Registered! Waiting for admin approval.</div>";
    }
    ?>

    <p class="footer-link">Already have an account? <a href="login.php">Sign in</a></p>
  </div>
</div>
</body>
</html>