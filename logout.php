<?php

// Start the session
require_once 'includes/auth.php';

// Remove all session data
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
header('Location: login.php');
exit;

?>