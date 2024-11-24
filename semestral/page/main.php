<?php
$lifetime = $_COOKIE["user"];
// Set the content type to HTML
header('Content-Type: text/html');

include 'component/header.php'; ?>
<div class="main-container">
    <h1>Welcome to My Website</h1>
    <p>This is the main content of the page.</p>
</div>
<?php include 'component/footer.php'; ?>