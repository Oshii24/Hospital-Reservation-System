<?php
// header.php - the top of every page.
// Each page sets $page_title BEFORE including this file.

// Sessions remember who is logged in (Member 2 fills $_SESSION at login)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$role = $_SESSION['role'] ?? null;            // 'admin', 'doctor', 'patient', or null = visitor
$name = $_SESSION['full_name'] ?? '';
$current_page = basename($_SERVER['PHP_SELF']); // e.g. "login.php"

// Prints one menu link. Highlights it when it's the page we're on.
function nav_link($file, $label)
{
    global $current_page;
    $active = ($file === $current_page) ? ' active' : '';
    echo '<li class="nav-item"><a class="nav-link' . $active . '" href="' . $file . '">' . $label . '</a></li>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($page_title ?? 'Home') ?> | City Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">&#127973; City Hospital</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <?php
                // Different links for each role
                if ($role === 'admin') {
                    nav_link('admin_dashboard.php', 'Dashboard');
                    nav_link('admin_doctors.php', 'Doctors');
                    nav_link('admin_departments.php', 'Departments');
                    nav_link('admin_patients.php', 'Patients');
                } elseif ($role === 'doctor') {
                    nav_link('doctor_dashboard.php', 'My Appointments');
                } elseif ($role === 'patient') {
                    nav_link('patient_dashboard.php', 'My Appointments');
                    nav_link('book_appointment.php', 'Book Appointment');
                }

                if ($role) {   // anyone logged in
                    nav_link('profile.php', 'Profile');
                    nav_link('logout.php', 'Logout (' . htmlspecialchars($name) . ')');
                } else {       // visitor
                    nav_link('index.php', 'Home');
                    nav_link('login.php', 'Login');
                    nav_link('register.php', 'Register');
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4 flex-grow-1">
<?php
// One-time messages like "Appointment booked!".
// show_flash() is written by Member 2 in auth.php; until then this is skipped.
if (function_exists('show_flash')) {
    show_flash();
}
?>