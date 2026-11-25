<?php
// The file must start with "<?php" on line 1: anything before it (even an
// empty line) is sent to the browser and can break session_start() and header().

// Start the session (only once, even if this file is included twice)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


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
// (header.php calls this on every page, so pages don't need to call it)
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

// No closing "?>" tag: leaving it out means no stray spaces or empty lines
// after it can be sent to the browser by accident.
