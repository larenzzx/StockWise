<?php
require_once 'includes/auth.php';
require_once 'config.php';

if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$page_title = 'Register';
$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($username === '' || $password === '' || $confirm_password === '') {
        $error = 'Please complete all fields.';
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $error = 'Username must be between 3 and 50 characters.';
    } elseif (!preg_match('/^[A-Za-z0-9_]+$/', $username)) {
        $error = 'Username can only contain letters, numbers, and underscores.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        $check_sql = 'SELECT id FROM users WHERE username = ? LIMIT 1';
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, 's', $username);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_fetch_assoc($check_result)) {
            $error = 'That username is already taken.';
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $insert_sql = 'INSERT INTO users (username, password) VALUES (?, ?)';
            $insert_stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($insert_stmt, 'ss', $username, $password_hash);

            if (mysqli_stmt_execute($insert_stmt)) {
                $_SESSION['user_id'] = mysqli_insert_id($conn);
                $_SESSION['username'] = $username;
                header('Location: dashboard.php');
                exit;
            }

            $error = 'Could not create your account. Please try again.';
        }
    }
}

include 'includes/header.php';
?>

<section class="box form-card narrow">
    <h2>Register</h2>
    <p>Create an account so you can log in and manage inventory products.</p>

    <?php if ($error !== '') : ?>
        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="register.php">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">

        <label for="password">Password</label>
        <input type="password" id="password" name="password">

        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password">

        <div class="form-actions">
            <button type="submit">Create Account</button>
            <a class="button secondary" href="login.php">Back to Login</a>
        </div>
    </form>

    <p class="help-text">Already have an account? <a href="login.php">Login here</a>.</p>
</section>

<?php include 'includes/footer.php'; ?>
