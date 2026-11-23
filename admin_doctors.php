<?php
// admin_doctors.php - the admin creates doctor accounts and deletes doctors
// PHP TODO (Member 5): validate the form, then INSERT into users (role 'doctor')
//                      AND INSERT into doctors. List doctors (SELECT + JOIN). Delete (DELETE).
$page_title = 'Doctors';
require 'includes/header.php';
?>

    <h2 class="mb-4">Doctors</h2>

    <div class="row g-4">
        <!-- ===== Left: Add doctor form ===== -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Add a doctor</h5>
                    <form method="POST" action="admin_doctors.php">
                        <input type="hidden" name="action" value="add">
                        <div class="mb-2">
                            <label class="form-label" for="full_name">Full name</label>
                            <input class="form-control" id="full_name" name="full_name" required minlength="3" placeholder="Dr. ...">
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control" type="email" id="email" name="email" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="phone">Phone</label>
                            <input class="form-control" type="tel" id="phone" name="phone" required pattern="[0-9]{8,15}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="gender">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Choose...</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="department_id">Department</label>
                            <select class="form-select" id="department_id" name="department_id" required>
                                <option value="">Choose...</option>
                                <!-- PHP TODO (Member 5): one <option> per department. value = departments.id -->
                                <option value="2">Cardiology</option>
                                <option value="1">General Medicine</option>
                                <option value="4">Orthopedics</option>
                                <option value="3">Pediatrics</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="specialization">Specialization</label>
                            <input class="form-control" id="specialization" name="specialization" required minlength="3" placeholder="e.g. Cardiologist">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Starting password</label>
                            <input class="form-control" type="password" id="password" name="password" required minlength="6">
                        </div>
                        <button class="btn btn-success w-100" type="submit">Add doctor</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ===== Right: list of doctors ===== -->
        <div class="col-lg-8">
            <div class="table-responsive">
                <table class="table table-striped bg-white align-middle">
                    <thead class="table-dark">
                        <tr><th>Name</th><th>Department</th><th>Contact</th><th>Appointments</th><th></th></tr>
                    </thead>
                    <tbody>
                        <!-- PHP TODO (Member 5): one <tr> per doctor. Sample rows below. -->
                        <tr>
                            <td>Dr. Sara Ahmed<br><small class="text-muted">Cardiologist</small></td>
                            <td>Cardiology</td>
                            <td><small>sara@hospital.com<br>0500000002</small></td>
                            <td>2</td>
                            <td>
                                <form method="POST" action="admin_doctors.php" class="d-inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="user_id" value="2">
                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>Dr. Omar Khalid<br><small class="text-muted">Pediatrician</small></td>
                            <td>Pediatrics</td>
                            <td><small>omar@hospital.com<br>0500000003</small></td>
                            <td>1</td>
                            <td>
                                <form method="POST" action="admin_doctors.php" class="d-inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="user_id" value="3">
                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php require 'includes/footer.php'; ?>
