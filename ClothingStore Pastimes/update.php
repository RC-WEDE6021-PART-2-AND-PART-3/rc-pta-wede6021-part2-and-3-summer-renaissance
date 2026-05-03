<?php include "DBConn.php"; ?>

<?php
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM tblUser WHERE userID=$id");
$user = $result->fetch_assoc();
?>

<form method="POST">
    <input type="text" name="name" value="<?php echo $user['fullName']; ?>">
    <input type="email" name="email" value="<?php echo $user['email']; ?>">
    <button name="update">Update</button>
</form>

<?php
if(isset($_POST['update'])){
    $name = $_POST['name'];
    $email = $_POST['email'];

    $conn->query("UPDATE tblUser SET fullName='$name', email='$email' WHERE userID=$id");

    header("Location: admin.php");
}
?>