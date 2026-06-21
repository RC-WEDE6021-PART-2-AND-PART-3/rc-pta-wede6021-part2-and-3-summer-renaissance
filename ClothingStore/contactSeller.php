<?php
include "DBConn.php";
include "pastimes_helpers.php";

$message = "";

if(isset($_POST['send'])){
    $senderName = "Admin";
    $receiverName = trim($_POST['sellerName']);
    $subject = trim($_POST['subject']);
    $msg = trim($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO tblMessages(senderName,receiverName,receiverType,subject,message)
                            VALUES(?,?,?,?,?)");

    $type = "seller";

    $stmt->bind_param(
        "sssss",
        $senderName,
        $receiverName,
        $type,
        $subject,
        $msg
    );

    if($stmt->execute()){
        $message = "Message sent successfully.";
    } else {
        $message = "Failed to send message.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Pastimes - Contact Seller</title>
<link rel="stylesheet" href="pastimes.css">
</head>
<body>

<div class="layout">

<?php renderSidebar('seller'); ?>

<main class="main">

<div class="page-header">
    <div>
        <h1 class="page-title">Contact Seller</h1>
        <p class="page-sub">Send messages to sellers.</p>
    </div>
</div>

<?php
if($message){
    echo "<div class='alert alert-success'>$message</div>";
}
?>

<div class="card">

<form method="POST">

<div class="field">
<label>Seller Name</label>
<input type="text" name="sellerName" required>
</div>

<div class="field">
<label>Subject</label>
<input type="text" name="subject" required>
</div>

<div class="field">
<label>Message</label>
<textarea name="message" required></textarea>
</div>

<button class="btn" name="send">
Send Message
</button>

</form>

</div>

</main>
</div>

</body>
</html>