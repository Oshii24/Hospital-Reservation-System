
<?php

// Start the session
session_start();


// Check if the user is logged in
function require_login($role = null) {

    // If no user is logged in, go to login page
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    // Check the user's role (patient, doctor, or admin)
    if ($role && $_SESSION['role'] !== $role) {
        header('Location: index.php');
        exit;
    }
}


// Save a success message
function set_flash($msg) {
    $_SESSION['flash'] = $msg;
}


// Display the success message
function show_flash() {

    if (isset($_SESSION['flash'])) {

        echo '<div class="alert alert-success">'
            . e($_SESSION['flash']) .
            '</div>';

        unset($_SESSION['flash']);
    }
}


// Protect text from XSS
function e($text) {
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

?>
