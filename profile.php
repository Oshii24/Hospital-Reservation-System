<!DOCTYPE html>
<!--
    profile.php - ANY logged-in user edits their own name, phone and password
    HTML: done.
    PHP TODO (Member 1): fill the form with the user's data (SELECT) and save changes (UPDATE).
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile | City Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<!-- ===== NAVBAR (patient version shown here - the real navbar will change by role) ===== -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">&#127973; City Hospital</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="patient_dashboard.php">My Appointments</a></li>
                <li class="nav-item"><a class="nav-link" href="book_appointment.php">Book Appointment</a></li>
                <li class="nav-item"><a class="nav-link active" href="profile.php">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout (Ali Hassan)</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4 flex-grow-1">
    <div class="form-box">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="mb-1">My Profile</h2>
                <p class="text-muted">
                    Role: <span class="badge bg-info text-dark">patient</span>
                    &middot; Member since 20 Nov 2026
                </p>

                <form method="POST" action="profile.php">
                    <div class="mb-3">
                        <label class="form-label">Email (cannot be changed)</label>
                        <input class="form-control" type="email" value="patient@hospital.com" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="full_name">Full name</label>
                        <input class="form-control" type="text" id="full_name" name="full_name" value="Ali Hassan" required minlength="3">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone">Phone</label>
                        <input class="form-control" type="tel" id="phone" name="phone" value="0500000004" required pattern="[0-9]{8,15}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="new_password">New password <small class="text-muted">(leave empty to keep the old one)</small></label>
                        <input class="form-control" type="password" id="new_password" name="new_password" minlength="6">
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</main>

<footer class="bg-dark text-light text-center py-3 mt-auto">
    <small>&copy; 2026 City Hospital &middot; CCS2305 Web Programming Project</small>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
