<?php
require_once '../configuration/DatabaseConnection.php';
require_once '../function/Validator.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = Validator::getInstance();
    // 1. Sanitize input
    $account = $validator->validateAccountPost();
    $errors = [];

    // 2. Validate input
    if (empty($firstName)) $errors[] = "First name is required.";
    if (empty($lastName)) $errors[] = "Last name is required.";
    if (empty($username)) $errors[] = "Username is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($password) || strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // Check if username or email already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "Username or email already exists.";
    }

    // 3. Handle avatar upload
    if (!empty($avatar['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($avatar['type'], $allowedTypes)) {
            $errors[] = "Only JPG, PNG, or GIF images are allowed.";
        } elseif ($avatar['size'] > 2 * 1024 * 1024) { // 2MB limit
            $errors[] = "Avatar file size must not exceed 2MB.";
        } else {
            $avatarPath = 'uploads/' . uniqid() . '-' . basename($avatar['name']);
            if (!move_uploaded_file($avatar['tmp_name'], $avatarPath)) {
                $errors[] = "Failed to upload avatar.";
            }
        }
    } else {
        $avatarPath = null; // No avatar uploaded
    }

    // 4. Insert into database if no errors
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, username, email, password, avatar) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$firstName, $lastName, $username, $email, $hashedPassword, $avatarPath])) {
            echo "Account successfully created!";
        } else {
            echo "Failed to create account. Please try again.";
        }
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
