<!DOCTYPE html>
<!--
    admin_dashboard.php - totals at the top + every appointment in the hospital
    HTML: done.
    PHP TODO (Member 3): only admins can open this page, count rows for the 4 boxes (SELECT COUNT(*)),
                         list all appointments (SELECT + JOIN), and make Delete work (DELETE).
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard | City Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<!-- ===== NAVBAR (admin version) ===== -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">&#127973; City Hospital</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="admin_dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_doctors.php">Doctors</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_departments.php">Departments</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_patients.php">Patients</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout (System Admin)</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4 flex-grow-1">
    <h2 class="mb-4">Admin Dashboard</h2>

    <!-- ===== 4 number boxes ===== -->
    <!-- PHP TODO (Member 3): replace each number with a COUNT(*) from the database -->
    <div class="row g-4 mb-5 text-center">
        <div class="col-6 col-lg-3">
            <a href="admin_patients.php" class="text-decoration-none">
                <div class="card card-hover border-primary"><div class="card-body">
                    <div class="stat-number text-primary">12</div>Patients
                </div></div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <a href="admin_doctors.php" class="text-decoration-none">
                <div class="card card-hover border-success"><div class="card-body">
                    <div class="stat-number text-success">4</div>Doctors
                </div></div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <a href="admin_departments.php" class="text-decoration-none">
                <div class="card card-hover border-warning"><div class="card-body">
                    <div class="stat-number text-warning">4</div>Departments
                </div></div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card card-hover border-danger"><div class="card-body">
                <div class="stat-number text-danger">27</div>Appointments
            </div></div>
        </div>
    </div>

    <!-- ===== All appointments ===== -->
    <h3 class="mb-3">All Appointments</h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover bg-white align-middle">
            <thead class="table-dark">
                <tr><th>#</th><th>Date</th><th>Time</th><th>Patient</th><th>Doctor</th><th>Reason</th><th>Status</th><th></th></tr>
            </thead>
            <tbody>
                <!-- PHP TODO (Member 3): one <tr> per appointment. Sample rows below. -->
                <tr>
                    <td>1</td>
                    <td>2026-11-25</td>
                    <td>10:00</td>
                    <td>Ali Hassan</td>
                    <td>Dr. Sara Ahmed</td>
                    <td>Chest pain when running</td>
                    <td><span class="badge bg-warning">pending</span></td>
                    <td>
                        <form method="POST" action="admin_dashboard.php" class="d-inline">
                            <input type="hidden" name="delete_id" value="1">
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>2026-11-27</td>
                    <td>11:30</td>
                    <td>Mona Saleh</td>
                    <td>Dr. Sara Ahmed</td>
                    <td>Follow-up on blood pressure</td>
                    <td><span class="badge bg-primary">confirmed</span></td>
                    <td>
                        <form method="POST" action="admin_dashboard.php" class="d-inline">
                            <input type="hidden" name="delete_id" value="2">
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</main>

<footer class="bg-dark text-light text-center py-3 mt-auto">
    <small>&copy; 2026 City Hospital &middot; CCS2305 Web Programming Project</small>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
