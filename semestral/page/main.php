<?php
$lifetime = $_COOKIE["user"];
// Set the content type to HTML
header('Content-Type: text/html');

include 'component/header.php';
echo "
<div class='main-container'>
    <h1>Welcome to My Website</h1>
    <p>Your cookie is $lifetime</p>
</div>";
include 'component/footer.php'; ?>