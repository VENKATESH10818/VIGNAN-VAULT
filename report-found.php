<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}
include 'db.php';

$message = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $student_id = $_SESSION['student_id'];
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $contact_number = $_POST['contact_number'];

    if (empty($_FILES['image']['name'])) {
        $message = "Image is required!";
    } else {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir);
        $imgPath = $targetDir . uniqid() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imgPath);

        $stmt = $conn->prepare("INSERT INTO found_items (student_id, item_name, description, image, contact_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $student_id, $name, $desc, $imgPath, $contact_number);
        if ($stmt->execute()) {
            $message = "Found item reported successfully!";
        } else {
            $message = "Error reporting item.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Report Found Item - Vignan Vault</title>
    <link rel="stylesheet" href="vault-style.css">
    <style>
    .report-container {
        max-width: 500px;
        margin: 50px auto;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 2px 16px #a084ee22;
        padding: 36px 34px 30px 34px;
    }
    .report-title {
        font-size: 1.7rem;
        font-weight: 700;
        color: #6c63ff;
        margin-bottom: 22px;
        text-align: center;
    }
    .vault-message { margin-bottom: 16px; }
    </style>
</head>
<body style="background: linear-gradient(120deg, #6c63ff 0%, #a084ee 100%); min-height:100vh;">
    <div class="report-container">
        <div class="report-title">Report Found Item</div>
        <?php if ($message) { echo "<div class='vault-message'>$message</div>"; } ?>
        <form method="post" enctype="multipart/form-data" class="vault-form">
            <label>Item Name</label>
            <input type="text" name="name" required>
            <label>Description</label>
            <textarea name="description" rows="3" required style="padding:12px; border-radius:8px; border:1.5px solid #ececff;"></textarea>
            <label>Contact Number</label>
            <input type="text" name="contact_number" pattern="[0-9]{10,}" maxlength="15" required placeholder="Enter contact number">
            <label>Image (required)</label>
            <input type="file" name="image" accept="image/*" required>
            <button type="submit" class="vault-btn">Report Found Item</button>
        </form>
    </div>
</body>
</html>