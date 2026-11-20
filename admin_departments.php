<!DOCTYPE html>
<!--
    admin_departments.php - add, edit and delete departments
    HTML: done.
    PHP TODO (Member 3): this page uses ALL FOUR database actions:
        INSERT (Add button), SELECT (the table), UPDATE (Edit -> Save), DELETE (Delete button).
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Departments | City Hospital</title>
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
                <li class="nav-item"><a class="nav-link active" href="admin_departments.php">Departments</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_patients.php">Patients</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout (System Admin)</a></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4 flex-grow-1">
    <h2 class="mb-4">Departments</h2>

    <div class="row g-4">
        <!-- ===== Left: Add / Edit form ===== -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- PHP TODO (Member 3): title says "Edit department" when the page is opened as
                         admin_departments.php?edit=3 and the form is filled with that department -->
                    <h5>Add a department</h5>
                    <form method="POST" action="admin_departments.php">
                        <input type="hidden" name="action" value="save">
                        <!-- id = 0 means "new". When editing, put the department's id here -->
                        <input type="hidden" name="id" value="0">
                        <div class="mb-3">
                            <label class="form-label" for="name">Name</label>
                            <input class="form-control" id="name" name="name" required minlength="2">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <button class="btn btn-primary" type="submit">Add</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ===== Right: list of departments ===== -->
        <div class="col-lg-8">
            <div class="table-responsive">
                <table class="table table-striped bg-white align-middle">
                    <thead class="table-dark">
                        <tr><th>Name</th><th>Description</th><th>Doctors</th><th></th></tr>
                    </thead>
                    <tbody>
                        <!-- PHP TODO (Member 3): one <tr> per department. Sample rows below. -->
                        <tr>
                            <td>Cardiology</td>
                            <td>Heart and blood vessel care.</td>
                            <td>1</td>
                            <td class="text-nowrap">
                                <a href="admin_departments.php?edit=2" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form method="POST" action="admin_departments.php" class="d-inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="2">
                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>Pediatrics</td>
                            <td>Medical care for children.</td>
                            <td>1</td>
                            <td class="text-nowrap">
                                <a href="admin_departments.php?edit=3" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form method="POST" action="admin_departments.php" class="d-inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="3">
                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
