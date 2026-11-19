<?php
include 'db.php';
session_start();
$message = '';

if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the student_id already exists
    $sql = "SELECT * FROM users WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "Account already exists with this Student ID.";
    } else {
        $sql = "INSERT INTO users (name, student_id, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $student_id, $pass);
        if ($stmt->execute()) {
            // Set session and redirect to main.php
            $_SESSION['student_id'] = $student_id;
            $_SESSION['name'] = $name;
            header("Location: main.php");
            exit;
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up - Vignan Vault</title>
    <link rel="stylesheet" href="vault-style.css">
</head>
<body>
<div class="vault-container">
    <div class="vault-left">
        <img src="https://img.icons8.com/fluency/240/lock--v1.png" alt="Vault" class="vault-img">
    </div>
    <div class="vault-right">
        <div class="vault-header">
            <!-- Make the logo a link to signup.php -->
            <a href="signup.php" class="vault-logo" style="text-decoration:none; color:inherit;">VIGNAN<br>VAULT</a>
            <span class="vault-question">Already have an account?</span>
            <a href="login.php" class="vault-signin-btn">SIGN IN</a>
        </div>
        <h2 class="vault-title">Welcome to Vignan Vault!</h2>
        <div class="vault-subtitle">Register your account</div>
        <form method="post" action="" class="vault-form">
            <label>Name</label>
            <input type="text" name="name" required>
            <label>Student ID</label>
            <input type="text" name="student_id" required>
            <label>Password</label>
            <div class="vault-password-row">
                <input type="password" name="password" id="password" required minlength="8" placeholder="8+ characters">
                <span class="vault-eye" onclick="togglePassword()">
                    <svg id="eyeIcon" height="20" width="20" viewBox="0 0 64 64" fill="#bbb"><path d="M32 16C17 16 4.4 28 4.4 28s12.6 12 27.6 12 27.6-12 27.6-12S47 16 32 16zm0 20a8 8 0 1 1 0-16 8 8 0 0 1 0 16z"/><circle cx="32" cy="28" r="4" fill="#fff"/></svg>
                </span>
            </div>
            <button type="submit" name="signup" class="vault-btn">Sign Up</button>
        </form>
        <?php if ($message): ?><div class="vault-message"><?php echo $message; ?></div><?php endif; ?>
    </div>
</div>
<script>
function togglePassword() {
    const pwd = document.getElementById('password');
    const eye = document.getElementById('eyeIcon');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        eye.setAttribute('fill', '#6c63ff');
    } else {
        pwd.type = 'password';
        eye.setAttribute('fill', '#bbb');
    }
}
</script>
</body>
</html>