<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}
include 'db.php';

// Get today's date (in Y-m-d format)
$today = date('Y-m-d');
$sql = "SELECT * FROM lost_items WHERE DATE(created_at) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Today's Lost Items - Vignan Vault</title>
    <link rel="stylesheet" href="vault-style.css">
    <style>
    .items-container {
        max-width: 850px;
        margin: 40px auto;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 20px #a084ee33;
        padding: 30px 35px;
    }
    .items-title {
        font-size: 1.8rem;
        color: #6c63ff;
        font-weight: 700;
        margin-bottom: 20px;
        text-align: center;
    }
    .item-row {
        padding: 18px 0;
        border-bottom: 1px solid #ececff;
        display: flex;
        gap: 32px;
        align-items: center;
    }
    .item-row:last-child { border-bottom: none; }
    .item-img {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 10px;
        background: #ececff;
    }
    .item-details {
        flex: 1;
    }
    .item-name {
        font-weight: 600;
        font-size: 1.15rem;
        color: #222;
    }
    .item-desc {
        color: #777;
        margin-top: 4px;
        margin-bottom: 2px;
    }
    .item-meta {
        font-size: 0.95rem;
        color: #888;
    }
    </style>
</head>
<body style="background: linear-gradient(120deg, #6c63ff 0%, #a084ee 100%); min-height:100vh;">
    <div class="items-container">
        <div class="items-title">Lost Items Reported Today</div>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="item-row">
                    <?php if ($row['image']): ?>
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" class="item-img" alt="Lost Item">
                    <?php else: ?>
                        <img src="https://img.icons8.com/fluency/96/box-important.png" class="item-img" alt="No Image">
                    <?php endif; ?>
                    <div class="item-details">
                        <div class="item-name"><?php echo htmlspecialchars($row['item_name']); ?></div>
                        <div class="item-desc"><?php echo htmlspecialchars($row['description']); ?></div>
                        <div class="item-meta">Reported by: <?php echo htmlspecialchars($row['student_id']); ?> | <?php echo date('H:i', strtotime($row['created_at'])); ?></div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="text-align:center; color:#888; margin:25px 0;">No lost items reported today.</div>
        <?php endif; ?>
    </div>
</body>
</html>