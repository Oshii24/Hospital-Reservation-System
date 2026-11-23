<?php
// admin_dashboard.php - totals at the top + every appointment in the hospital (Member 1)
require_once 'includes/db.php';

// TODO: once Member 2 pushes includes/auth.php, uncomment these two lines
// so only admins can open this page:
// require_once 'includes/auth.php';
// require_login('admin');

// ---------- DELETE an appointment ----------
// The Delete button sends a POST with the appointment's id in "delete_id"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = (int) $_POST['delete_id'];   // (int) turns it into a number, for safety

    $stmt = $conn->prepare('DELETE FROM appointments WHERE id = ?');
    $stmt->bind_param('i', $id);       // 'i' = integer
    $stmt->execute();

    // Reload the page, so pressing F5 doesn't send the delete again
    header('Location: admin_dashboard.php');
    exit;
}

// ---------- COUNT rows for the 4 boxes (SELECT COUNT) ----------
$count_patients     = $conn->query("SELECT COUNT(*) AS c FROM users WHERE role = 'patient'")->fetch_assoc()['c'];
$count_doctors      = $conn->query('SELECT COUNT(*) AS c FROM doctors')->fetch_assoc()['c'];
$count_departments  = $conn->query('SELECT COUNT(*) AS c FROM departments')->fetch_assoc()['c'];
$count_appointments = $conn->query('SELECT COUNT(*) AS c FROM appointments')->fetch_assoc()['c'];

// ---------- ALL appointments with names (SELECT + JOIN) ----------
// p  = the patient (a row in users)
// d  = the doctor's row in doctors
// du = the doctor's own row in users (that's where their name is)
$appointments = $conn->query(
    'SELECT a.id, a.appointment_date, a.appointment_time, a.reason, a.status,
            p.full_name  AS patient_name,
            du.full_name AS doctor_name
     FROM appointments a
     JOIN users p   ON a.patient_id = p.id
     JOIN doctors d ON a.doctor_id  = d.id
     JOIN users du  ON d.user_id    = du.id
     ORDER BY a.appointment_date DESC, a.appointment_time DESC'
);

// Bootstrap colour for each status
$badge = [
    'pending'   => 'warning',
    'confirmed' => 'primary',
    'completed' => 'success',
    'cancelled' => 'secondary',
];

$page_title = 'Admin Dashboard';
require 'includes/header.php';
?>

<h2 class="mb-4">Admin Dashboard</h2>

<!-- ===== 4 number boxes ===== -->
<div class="row g-4 mb-5 text-center">
    <div class="col-6 col-lg-3">
        <a href="admin_patients.php" class="text-decoration-none">
            <div class="card card-hover border-primary"><div class="card-body">
                <div class="stat-number text-primary"><?= $count_patients ?></div>Patients
            </div></div>
        </a>
    </div>
    <div class="col-6 col-lg-3">
        <a href="admin_doctors.php" class="text-decoration-none">
            <div class="card card-hover border-success"><div class="card-body">
                <div class="stat-number text-success"><?= $count_doctors ?></div>Doctors
            </div></div>
        </a>
    </div>
    <div class="col-6 col-lg-3">
        <a href="admin_departments.php" class="text-decoration-none">
            <div class="card card-hover border-warning"><div class="card-body">
                <div class="stat-number text-warning"><?= $count_departments ?></div>Departments
            </div></div>
        </a>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-hover border-danger"><div class="card-body">
            <div class="stat-number text-danger"><?= $count_appointments ?></div>Appointments
        </div></div>
    </div>
</div>

<!-- ===== All appointments ===== -->
<h3 class="mb-3">All Appointments</h3>

<?php if ($appointments->num_rows === 0): ?>
    <div class="alert alert-info">There are no appointments yet.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover bg-white align-middle">
            <thead class="table-dark">
                <tr><th>#</th><th>Date</th><th>Time</th><th>Patient</th><th>Doctor</th><th>Reason</th><th>Status</th><th></th></tr>
            </thead>
            <tbody>
                <?php while ($row = $appointments->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['appointment_date']) ?></td>
                        <td><?= substr($row['appointment_time'], 0, 5) ?></td>
                        <td><?= htmlspecialchars($row['patient_name']) ?></td>
                        <td><?= htmlspecialchars($row['doctor_name']) ?></td>
                        <td><?= htmlspecialchars($row['reason']) ?></td>
                        <td><span class="badge bg-<?= $badge[$row['status']] ?>"><?= $row['status'] ?></span></td>
                        <td>
                            <form method="POST" action="admin_dashboard.php" class="d-inline">
                                <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>
