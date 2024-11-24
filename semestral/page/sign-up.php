<?php
require "function/validator.php";
// Set the content type to HTML
header('Content-Type: text/html');

include 'component/header.php';
echo "
<div class='form-container'>
        <form action='signup.php' method='POST' enctype='multipart/form-data'>
            <h1>Sign Up</h1>
    
            <!-- Username -->
            <label for='username'>Username:</label>
            <input type='text' id='username' name='username' required>
    
            <!-- Email -->
            <label for='email'>Email:</label>
            <input type='email' id='email' name='email' required>
    
            <!-- Password -->
            <label for='password'>Password:</label>
            <input type='password' id='password' name='password' required>
            
            <!-- Password -->
            <label for='repeat-password'>Password:</label>
            <input type='password' id='password' name='repeat-password' required>
    
            <!-- File Upload -->
            <label for='profile_pic'>Profile Picture:</label>
            <input type='file' id='profile_pic' name='profile_pic' accept='image/*' required>
    
            <!-- Submit -->
            <button type='submit'>Sign Up</button>
        </form>
</div>";
include 'component/footer.php'; ?>