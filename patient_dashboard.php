<?php
// patient_dashboard.php - a patient sees their appointments and can cancel them

// Only logged-in patients can access this page
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_login('patient');

// Flash helpers: use Member 2's functions if they exist, otherwise a simple fallback
if (!function_exists('set_flash')) {
    function set_flash($msg) { $_SESSION['flash'] = $msg; }
}
if (!function_exists('get_flash')) {
    function get_flash() {
        $msg = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);          // shown only once
        return $msg;
    }
}
if (!function_exists('e')) {
    function e($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); }
}

$patient_id = (int) $_SESSION['user_id'];

// --- Cancel (UPDATE). "AND patient_id = ?" = you can only cancel YOUR OWN appointments ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_id'])) {
    $cancel_id = (int) $_POST['cancel_id'];

    $stmt = $conn->prepare(
        "UPDATE appointments SET status = 'cancelled'
         WHERE id = ? AND patient_id = ? AND status IN ('pending', 'confirmed')"
    );
    $stmt->bind_param('ii', $cancel_id, $patient_id);
    $stmt->execute();

    set_flash($stmt->affected_rows > 0 ? 'Appointment cancelled.' : 'That appointment could not be cancelled.');
    header('Location: patient_dashboard.php');
    exit;
}

// --- My appointments (SELECT + JOINs) ---
$stmt = $conn->prepare(
    "SELECT a.id, a.appointment_date, a.appointment_time, a.reason, a.status, a.doctor_notes,
            u.full_name AS doctor_name, d.specialization, dep.name AS department_name
     FROM appointments a
     JOIN doctors d ON a.doctor_id = d.id
     JOIN users u   ON d.user_id   = u.id
     LEFT JOIN departments dep ON d.department_id = dep.id
     WHERE a.patient_id = ?
     ORDER BY a.appointment_date DESC, a.appointment_time DESC"
);
$stmt->bind_param('i', $patient_id);
$stmt->execute();
$result = $stmt->get_result();

// Status badge colours
$badges = [
    'pending'   => 'bg-warning',
    'confirmed' => 'bg-primary',
    'completed' => 'bg-success',
    'cancelled' => 'bg-secondary',
];

$flash = get_flash();

$page_title = 'My Appointments';
require 'includes/header.php';
?>

    <?php if ($flash): ?>
        <div class="alert alert-success"><?= e($flash) ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">My Appointments</h2>
        <a href="book_appointment.php" class="btn btn-success">+ Book Appointment</a>
    </div>

    <?php if ($result->num_rows === 0): ?>
        <div class="alert alert-info">You have no appointments yet. <a href="book_appointment.php">Book one now</a>.</div>
    <?php else: ?>
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
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= e($row['appointment_date']) ?></td>
                    <td><?= e(substr($row['appointment_time'], 0, 5)) ?></td>
                    <td><?= e($row['doctor_name']) ?><br><small class="text-muted"><?= e($row['specialization']) ?></small></td>
                    <td><?= e($row['department_name'] ?? '-') ?></td>
                    <td><?= e($row['reason']) ?></td>
                    <td><span class="badge <?= $badges[$row['status']] ?? 'bg-secondary' ?>"><?= e($row['status']) ?></span></td>
                    <td><?= e($row['doctor_notes'] ?? '') ?></td>
                    <td>
                        <?php if (in_array($row['status'], ['pending', 'confirmed'], true)): ?>
                        <!-- The hidden input tells PHP WHICH appointment to cancel -->
                        <form method="POST" action="patient_dashboard.php" class="d-inline"
                              data-confirm="Are you sure you want to cancel this appointment?">
                            <input type="hidden" name="cancel_id" value="<?= (int) $row['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger" type="submit">Cancel</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <script src="js/main.js"></script>

<?php require 'includes/footer.php'; ?>
