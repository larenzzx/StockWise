<?php
$page_title = 'Contact';
$success = '';
$error = '';
$name = '';
$email = '';
$message_text = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message_text = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $message_text === '') {
        $error = 'Please complete all fields before sending your message.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $success = 'Thank you, ' . $name . '. Your message has been received.';
        $name = '';
        $email = '';
        $message_text = '';
    }
}

include 'includes/header.php';
?>

<section class="box page-heading">
    <h2>Contact</h2>
    <p>Have a question about the inventory system or need help with setup? Send a message using the form below.</p>
</section>

<section class="grid two contact-layout">
    <div class="box">
        <h3>Support Details</h3>
        <p>This contact page is for project questions, setup help, and basic support requests. A real deployment can connect this form to email or a database later.</p>
        <ul class="contact-list">
            <li><strong>Project:</strong> StockWise Inventory</li>
            <li><strong>Technology:</strong> PHP, HTML, CSS, MySQL</li>
            <li><strong>Best for:</strong> Small inventory tracking</li>
        </ul>
    </div>

    <form method="post" action="contact.php" class="box form-card">
        <h3>Send a Message</h3>
        <?php if ($success !== '') : ?>
            <div class="message success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <?php if ($error !== '') : ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Your name" value="<?php echo htmlspecialchars($name); ?>">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="you@example.com" value="<?php echo htmlspecialchars($email); ?>">

        <label for="message">Message</label>
        <textarea id="message" name="message" rows="5" placeholder="How can we help?"><?php echo htmlspecialchars($message_text); ?></textarea>

        <button type="submit">Send Message</button>
    </form>
</section>

<?php include 'includes/footer.php'; ?>
