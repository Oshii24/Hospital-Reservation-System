<?php
// book_appointment.php - a patient books an appointment with a doctor
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_login('patient');

// Flash helper: uses Member 2's set_flash() if it exists, otherwise a simple fallback
if (!function_exists('set_flash')) {
    function set_flash($msg) { $_SESSION['flash'] = $msg; }
}
if (!function_exists('e')) {
    function e($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); }
}

$times = ['09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30',
          '13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30'];

$errors    = [];
$doctor_id = 0;
$date      = '';
$time      = '';
$reason    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = (int) ($_POST['doctor_id'] ?? 0);
    $date      = trim($_POST['appointment_date'] ?? '');
    $time      = trim($_POST['appointment_time'] ?? '');
    $reason    = trim($_POST['reason'] ?? '');

    // 1. doctor exists
    $stmt = $conn->prepare('SELECT id FROM doctors WHERE id = ?');
    $stmt->bind_param('i', $doctor_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows === 0) {
        $errors[] = 'Please choose a doctor from the list.';
    }

    // 2. date is real and today or later
    $d = DateTime::createFromFormat('Y-m-d', $date);
    if (!$d || $d->format('Y-m-d') !== $date) {
        $errors[] = 'Please choose a valid date.';
    } elseif ($date < date('Y-m-d')) {
        $errors[] = 'The date must be today or later.';
    }

    // 3. time is in the list
    if (!in_array($time, $times, true)) {
        $errors[] = 'Please choose a time from the list.';
    }

    // 4. reason 5-255 characters
    $len = mb_strlen($reason);
    if ($len < 5 || $len > 255) {
        $errors[] = 'The reason must be between 5 and 255 characters.';
    }

    // 5. block double booking (cancelled appointments free the slot)
    if (empty($errors)) {
        $stmt = $conn->prepare(
            "SELECT id FROM appointments
             WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ?
               AND status <> 'cancelled'"
        );
        $stmt->bind_param('iss', $doctor_id, $date, $time);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $errors[] = 'This doctor is already booked at that time. Please pick another slot.';
        }
    }

    // 6. INSERT, flash, redirect
    if (empty($errors)) {
        $patient_id = (int) $_SESSION['user_id'];   // from the session, never from the form
        $stmt = $conn->prepare(
            "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, reason, status)
             VALUES (?, ?, ?, ?, ?, 'pending')"
        );
        $stmt->bind_param('iisss', $patient_id, $doctor_id, $date, $time, $reason);
        $stmt->execute();

        set_flash('Appointment booked! The doctor will confirm it soon.');
        header('Location: patient_dashboard.php');
        exit;
    }
}

// Doctors for the <select>: doctors -> users (name) -> departments (name)
$doctors = $conn->query(
    "SELECT d.id, u.full_name, d.specialization, dep.name AS department_name
     FROM doctors d
     JOIN users u ON d.user_id = u.id
     LEFT JOIN departments dep ON d.department_id = dep.id
     ORDER BY u.full_name"
);

$page_title = 'Book Appointment';
require 'includes/header.php';
?>

    <div class="form-box">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="mb-4 text-center">Book an Appointment</h2>

                <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $err): ?>
                            <li><?= e($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <form method="POST" action="book_appointment.php">
                    <div class="mb-3">
                        <label class="form-label" for="doctor_id">Doctor</label>
                        <select class="form-select" id="doctor_id" name="doctor_id" required>
                            <option value="">Choose a doctor...</option>
                            <?php while ($doc = $doctors->fetch_assoc()): ?>
                                <option value="<?= (int) $doc['id'] ?>" <?= $doctor_id === (int) $doc['id'] ? 'selected' : '' ?>>
                                    <?= e($doc['full_name']) ?> &mdash; <?= e($doc['department_name'] ?? 'No department') ?> (<?= e($doc['specialization']) ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label" for="appointment_date">Date</label>
                            <input class="form-control" type="date" id="appointment_date" name="appointment_date"
                                   min="<?= date('Y-m-d') ?>" value="<?= e($date) ?>" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" for="appointment_time">Time</label>
                            <select class="form-select" id="appointment_time" name="appointment_time" required>
                                <option value="">Choose...</option>
                                <?php foreach ($times as $t): ?>
                                    <option <?= $time === $t ? 'selected' : '' ?>><?= $t ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="reason">Reason for the visit</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required minlength="5" maxlength="255"><?= e($reason) ?></textarea>
                    </div>
                    <button class="btn btn-success w-100" type="submit">Book</button>
                </form>
            </div>
        </div>
    </div>

<?php require 'includes/footer.php'; ?>