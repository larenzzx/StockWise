<?php
require_once 'includes/auth.php';
require_once 'config.php';

if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$page_title = 'Login';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        $sql = 'SELECT id, username, password FROM users WHERE username = ? LIMIT 1';
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        $password_matches = $user && password_verify($password, $user['password']);

        // The SQL file includes a plain default password to keep setup simple.
        // After the first successful login, it is replaced with a secure hash.
        if ($user && !$password_matches && $password === $user['password']) {
            $new_hash = password_hash($password, PASSWORD_DEFAULT);
            $update_sql = 'UPDATE users SET password = ? WHERE id = ?';
            $update_stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($update_stmt, 'si', $new_hash, $user['id']);
            mysqli_stmt_execute($update_stmt);
            $password_matches = true;
        }

        if ($user && $password_matches) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: dashboard.php');
            exit;
        }

        $error = 'Invalid username or password.';
    }
}

include 'includes/header.php';
?>

<section class="box form-card narrow">
    <h2>Login</h2>
    <p>Sign in to access the dashboard and manage product records.</p>
    <?php if ($error !== '') : ?>
        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="login.php">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">

        <label for="password">Password</label>
        <input type="password" id="password" name="password">

        <div class="form-actions">
            <button type="submit">Login</button>
        </div>
    </form>
    <p class="help-text">Default account: <strong>admin</strong> / <strong>admin123</strong></p>
    <p>New user? <a href="register.php">Create an account</a>.</p>
</section>

<?php include 'includes/footer.php'; ?>
