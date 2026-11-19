<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}
include 'db.php';

$student_id = $_SESSION['student_id'];

// Get user details
$user_stmt = $conn->prepare("SELECT name, student_id, password FROM users WHERE student_id = ?");
$user_stmt->bind_param("s", $student_id);
$user_stmt->execute();
$user_res = $user_stmt->get_result();
$user = $user_res->fetch_assoc();

// Count lost items uploaded
$lost_stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM lost_items WHERE student_id = ?");
$lost_stmt->bind_param("s", $student_id);
$lost_stmt->execute();
$lost_count = $lost_stmt->get_result()->fetch_assoc()['cnt'];

// Count found items uploaded
$found_stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM found_items WHERE student_id = ?");
$found_stmt->bind_param("s", $student_id);
$found_stmt->execute();
$found_count = $found_stmt->get_result()->fetch_assoc()['cnt'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Account - Vignan Vault</title>
    <link rel="stylesheet" href="vault-style.css">
    <style>
    .account-container {
        max-width: 500px;
        margin: 50px auto;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 20px #a084ee22;
        padding: 36px 30px 30px 30px;
        text-align: left;
    }
    .account-title {
        font-size: 2rem;
        color: #6c63ff;
        font-weight: 700;
        margin-bottom: 18px;
    }
    .account-row {
        font-size: 1.13rem;
        margin-bottom: 12px;
        color: #333;
        display: flex;
        justify-content: space-between;
    }
    .account-label {
        color: #888;
        font-weight: 500;
    }
    .account-card {
        background: #f7f7ff;
        border-radius: 10px;
        padding: 14px 18px;
        margin-bottom: 10px;
    }
    .account-count {
        font-size: 1.3rem;
        color: #6c63ff;
        font-weight: 600;
        margin-left: 10px;
    }
    </style>
</head>
<body style="background: linear-gradient(120deg, #6c63ff 0%, #a084ee 100%); min-height:100vh;">
    <div class="account-container">
        <div class="account-title">My Account</div>
        <div class="account-card account-row">
            <span class="account-label">Name:</span> <span><?php echo htmlspecialchars($user['name']); ?></span>
        </div>
        <div class="account-card account-row">
            <span class="account-label">Student ID:</span> <span><?php echo htmlspecialchars($user['student_id']); ?></span>
        </div>
        <div class="account-card account-row">
            <span class="account-label">Password:</span> <span>********</span>
        </div>
        <div class="account-card account-row">
            <span class="account-label">Lost Items Uploaded:</span> <span class="account-count"><?php echo $lost_count; ?></span>
        </div>
        <div class="account-card account-row">
            <span class="account-label">Found Items Uploaded:</span> <span class="account-count"><?php echo $found_count; ?></span>
        </div>
    </div>
</body>
</html>