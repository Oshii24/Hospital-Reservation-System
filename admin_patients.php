<?php
// admin_patients.php - the admin searches and deletes patients
// PHP TODO (Member 5): list patients (SELECT ... WHERE role = 'patient'),
//                      make Search work (LIKE), and make Delete work (DELETE).
$page_title = 'Patients';
require 'includes/header.php';
?>

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
                <!-- PHP TODO (Member 5): one <tr> per patient. Sample rows below.
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

<?php require 'includes/footer.php'; ?>
