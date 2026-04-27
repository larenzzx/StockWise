<?php
$page_title = 'Contact';
include 'includes/header.php';
?>

<section class="box">
    <h2>Contact</h2>
    <p>For questions about this sample project, contact the system administrator.</p>
    <form method="post" action="contact.php">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Your name">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Your email">

        <label for="message">Message</label>
        <textarea id="message" name="message" rows="5" placeholder="Your message"></textarea>

        <button type="submit">Send Message</button>
    </form>
</section>

<?php include 'includes/footer.php'; ?>
