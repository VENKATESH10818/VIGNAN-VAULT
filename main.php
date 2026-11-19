<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}
$name = htmlspecialchars($_SESSION['name']);
$student_id = htmlspecialchars($_SESSION['student_id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Main - Vignan Vault</title>
    <link rel="stylesheet" href="vault-style.css">
    <style>
    .vault-main-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 26px 50px 16px 50px;
        background: #fff;
        border-bottom: 1px solid #ececff;
    }
    .vault-main-logo {
        font-size: 2rem;
        font-weight: bold;
        color: #6c63ff;
        letter-spacing: 2px;
        line-height: 1.1;
    }
    .vault-nav {
        display: flex;
        gap: 28px;
    }
    .vault-nav a, .vault-nav form {
        color: #555;
        text-decoration: none;
        font-weight: 500;
        font-size: 1.06rem;
        transition: color 0.2s;
        padding: 5px 18px;
        border-radius: 20px;
        background: none;
        border: none;
        outline: none;
        display: flex;
        align-items: center;
    }
    .vault-nav a:hover, .vault-nav a.active {
        background: #ececff;
        color: #6c63ff;
    }
    .vault-logout-btn {
        background: #6c63ff;
        color: #fff;
        border: none;
        border-radius: 18px;
        font-size: 1rem;
        font-weight: 500;
        padding: 8px 24px;
        margin-left: 30px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .vault-logout-btn:hover {
        background: #5549d5;
    }
    .vault-main-content {
        max-width: 900px;
        margin: 50px auto;
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 8px 40px 0 rgba(108,99,255,0.11);
        padding: 40px 48px 35px 48px;
        text-align: center;
    }
    .vault-main-title {
        font-size: 2.1rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: #222;
    }
    .vault-main-welcome {
        color: #888;
        font-size: 1.1rem;
        margin-bottom: 28px;
    }
    .vault-main-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 34px;
        margin-bottom: 30px;
    }
    .vault-main-card {
        background: linear-gradient(120deg, #6c63ff10 0%, #a084ee11 100%);
        border-radius: 18px;
        box-shadow: 0 1px 10px #ececff66;
        padding: 38px 46px 28px 46px;
        min-width: 200px;
        cursor: pointer;
        transition: box-shadow 0.2s, transform 0.2s;
        text-align: center;
        color: #444;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
    }
    .vault-main-card:hover {
        box-shadow: 0 4px 24px #c3baff66;
        transform: translateY(-5px) scale(1.04);
        color: #6c63ff;
        text-decoration: none;
    }
    .vault-main-card i {
        font-size: 2.6rem;
        margin-bottom: 10px;
        color: #6c63ff;
    }
    .vault-main-card span {
        display: block;
        font-size: 1.12rem;
        font-weight: 600;
        text-decoration: underline;
        margin-top: 10px;
    }
    @media (max-width: 900px) {
        .vault-main-content { padding: 24px 10px; }
        .vault-main-header { padding: 16px 8px 10px 8px; }
        .vault-main-title { font-size: 1.48rem; }
        .vault-main-actions { gap: 12px;}
        .vault-main-card { min-width: 120px; padding: 16px; }
    }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body style="background: linear-gradient(120deg, #6c63ff 0%, #a084ee 100%); min-height:100vh;">
    <div class="vault-main-header">
        <div class="vault-main-logo">VIGNAN<br>VAULT</div>
        <nav class="vault-nav">
            <a href="main.php" class="active">Home</a>
            <a href="my-account.php">My Account</a>
            <form action="logout.php" method="post" style="display:inline;">
                <button type="submit" class="vault-logout-btn">Logout</button>
            </form>
        </nav>
    </div>
    <div class="vault-main-content">
        <div class="vault-main-title">Welcome to Vignan Vault!</div>
        <div class="vault-main-welcome">
            Hello, <strong style="font-weight:700;"><?php echo $name; ?></strong> (<?php echo $student_id; ?>)<br>
            What would you like to do today?
        </div>
        <div class="vault-main-actions">
            <a href="report-lost.php" class="vault-main-card">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>Report Lost Item</span>
            </a>
            <a href="report-found.php" class="vault-main-card">
                <i class="fa-solid fa-plus-circle"></i>
                <span>Report Found Item</span>
            </a>
            <a href="view-lost-items.php" class="vault-main-card">
                <i class="fa-solid fa-list"></i>
                <span>View Lost Items</span>
            </a>
            <a href="view-found-items.php" class="vault-main-card">
                <i class="fa-solid fa-box-open"></i>
                <span>View Found Items</span>
            </a>
        </div>
    </div>
</body>
</html>