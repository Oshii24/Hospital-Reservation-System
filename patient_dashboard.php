<!DOCTYPE html>
<!--
    patient_dashboard.php - the patient sees their appointments and can cancel them
    HTML: done.
    PHP TODO (Member 3): only patients can open this page, list THEIR appointments (SELECT + JOIN),
                         and make the Cancel button work (UPDATE status to 'cancelled').
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Appointments | City Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<!-- ===== NAVBAR (patient version) ===== -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">&#127973; City Hospital</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="patient_dashboard.php">My Appointments</a></li>
                <li class="nav-item"><a class="nav-link" href="book_appointment.php">Book Appointment</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout (Ali Hassan)</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4 flex-grow-1">

    <!-- PHP TODO (Member 2): "flash" message after an action, shown once -->
    <div class="alert alert-success">Appointment booked! The doctor will confirm it soon.</div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">My Appointments</h2>
        <a href="book_appointment.php" class="btn btn-success">+ Book Appointment</a>
    </div>

    <!-- PHP TODO (Member 3): show this box instead of the table when there are no appointments -->
    <div class="alert alert-info">You have no appointments yet. <a href="book_appointment.php">Book one now</a>.</div>

    <div class="table-responsive">
        <table class="table table-striped table-hover bg-white align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Doctor</th>
                    <th>Department</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Doctor notes</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP TODO (Member 3): repeat ONE <tr> for every appointment. These rows are samples. -->
                <tr>
                    <td>2026-11-25</td>
                    <td>10:00</td>
                    <td>Dr. Sara Ahmed<br><small class="text-muted">Cardiologist</small></td>
                    <td>Cardiology</td>
                    <td>Chest pain when running</td>
                    <td><span class="badge bg-warning">pending</span></td>
                    <td></td>
                    <td>
                        <!-- The hidden input tells PHP WHICH appointment to cancel -->
                        <form method="POST" action="patient_dashboard.php" class="d-inline">
                            <input type="hidden" name="cancel_id" value="1">
                            <button class="btn btn-sm btn-outline-danger" type="submit">Cancel</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>2026-11-10</td>
                    <td>14:30</td>
                    <td>Dr. Omar Khalid<br><small class="text-muted">Pediatrician</small></td>
                    <td>Pediatrics</td>
                    <td>Yearly check-up</td>
                    <td><span class="badge bg-success">completed</span></td>
                    <td>All good. Come back next year.</td>
                    <td><!-- no Cancel button for completed / cancelled appointments --></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Status badge colours: pending = bg-warning, confirmed = bg-primary,
         completed = bg-success, cancelled = bg-secondary -->
</main>

<footer class="bg-dark text-light text-center py-3 mt-auto">
    <small>&copy; 2026 City Hospital &middot; CCS2305 Web Programming Project</small>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
