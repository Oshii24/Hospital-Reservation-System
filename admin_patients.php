<!DOCTYPE html>
<!--
    admin_patients.php - the admin searches and deletes patients
    HTML: done.
    PHP TODO (Member 3): list patients (SELECT ... WHERE role = 'patient'),
                         make Search work (LIKE), and make Delete work (DELETE).
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patients | City Hospital</title>
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
                <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_doctors.php">Doctors</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_departments.php">Departments</a></li>
                <li class="nav-item"><a class="nav-link active" href="admin_patients.php">Patients</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout (System Admin)</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4 flex-grow-1">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h2 class="mb-0">Patients</h2>
        <!-- GET form: the search word appears in the address bar, e.g. admin_patients.php?search=ali -->
        <form method="GET" action="admin_patients.php" class="d-flex gap-2">
            <input class="form-control" type="search" name="search" placeholder="Search name or email">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped bg-white align-middle">
            <thead class="table-dark">
                <tr><th>Name</th><th>Email</th><th>Phone</th><th>Gender</th><th>Date of birth</th><th>Appointments</th><th>Joined</th><th></th></tr>
            </thead>
            <tbody>
                <!-- PHP TODO (Member 3): one <tr> per patient. Sample rows below.
                     When nothing is found show:
                     <tr><td colspan="8" class="text-center text-muted">No patients found.</td></tr> -->
                <tr>
                    <td>Ali Hassan</td>
                    <td>patient@hospital.com</td>
                    <td>0500000004</td>
                    <td>male</td>
                    <td>1998-04-12</td>
                    <td>2</td>
                    <td>20 Nov 2026</td>
                    <td>
                        <form method="POST" action="admin_patients.php" class="d-inline">
                            <input type="hidden" name="delete_id" value="4">
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>Mona Saleh</td>
                    <td>mona@example.com</td>
                    <td>0500000005</td>
                    <td>female</td>
                    <td>1985-09-03</td>
                    <td>1</td>
                    <td>18 Nov 2026</td>
                    <td>
                        <form method="POST" action="admin_patients.php" class="d-inline">
                            <input type="hidden" name="delete_id" value="5">
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
