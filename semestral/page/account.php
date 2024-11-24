<?php
setcookie("user", "sdfsdfsdfsdfsdfsdf", time() + 3600, "/");
// Set the content type to HTML
header('Content-Type: text/html');

// Output the HTML content
echo "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Account page</title>
</head>
<body>
    <h1>You are login in!</h1>
</body>
</html>
";