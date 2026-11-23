<?php
// admin_departments.php - add, edit and delete departments
// PHP TODO (Member 4): this page uses ALL FOUR database actions:
//     INSERT (Add button), SELECT (the table), UPDATE (Edit -> Save), DELETE (Delete button).
$page_title = 'Departments';
require 'includes/header.php';
?>

    <h2 class="mb-4">Departments</h2>

    <div class="row g-4">
        <!-- ===== Left: Add / Edit form ===== -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- PHP TODO (Member 4): title says "Edit department" when the page is opened as
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
                        <!-- PHP TODO (Member 4): one <tr> per department. Sample rows below. -->
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

<?php require 'includes/footer.php'; ?>
