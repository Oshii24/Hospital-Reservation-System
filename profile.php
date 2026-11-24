<?php

// Connect to database and check login
require_once 'includes/db.php';
require_once 'includes/auth.php';

require_login();

$page_title = 'My Profile';

$error = '';
$success = '';

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Get user information from database
$stmt = $conn->prepare(
    "SELECT full_name, email, phone, role, created_at
     FROM users WHERE id = ?"
);

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $new_password = $_POST['new_password'];

    // Validate name
    if (strlen($full_name) < 3) {

        $error = 'Name must contain at least 3 characters.';

    // Validate phone
    } elseif (!preg_match('/^[0-9]{8,15}$/', $phone)) {

        $error = 'Phone must contain 8 to 15 digits.';

    // Validate new password if provided
    } elseif (!empty($new_password) && strlen($new_password) < 6) {

        $error = 'New password must be at least 6 characters.';

    } else {

        // Update name and phone
        if (!empty($new_password)) {

            // Hash the new password
            $hashed_password = password_hash(
                $new_password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "UPDATE users
                 SET full_name = ?, phone = ?, password = ?
                 WHERE id = ?"
            );

            $stmt->bind_param(
                "sssi",
                $full_name,
                $phone,
                $hashed_password,
                $user_id
            );

        } else {

            // Keep the old password
            $stmt = $conn->prepare(
                "UPDATE users
                 SET full_name = ?, phone = ?
                 WHERE id = ?"
            );

            $stmt->bind_param(
                "ssi",
                $full_name,
                $phone,
                $user_id
            );
        }

        if ($stmt->execute()) {

            // Update session name
            $_SESSION['full_name'] = $full_name;

            // Save success message
            set_flash('Profile updated successfully!');

            // Redirect to avoid submitting the form again
            header('Location: profile.php');
            exit;

        } else {

            $error = 'Something went wrong. Please try again.';
        }

        $stmt->close();
    }
}

require 'includes/header.php';

?>

<div class="form-box">
    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h2 class="mb-1">My Profile</h2>

            <?php show_flash(); ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <p class="text-muted">
                Role:
                <span class="badge bg-info text-dark">
                    <?= e($user['role']) ?>
                </span>

                &middot; Member since
                <?= e(date('d M Y', strtotime($user['created_at']))) ?>
            </p>

            <form method="POST" action="profile.php">

                <div class="mb-3">
                    <label class="form-label">
                        Email (cannot be changed)
                    </label>

                    <input
                        class="form-control"
                        type="email"
                        value="<?= e($user['email']) ?>"
                        disabled
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label" for="full_name">
                        Full name
                    </label>

                    <input
                        class="form-control"
                        type="text"
                        id="full_name"
                        name="full_name"
                        value="<?= e($_POST['full_name'] ?? $user['full_name']) ?>"
                        required
                        minlength="3"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label" for="phone">
                        Phone
                    </label>

                    <input
                        class="form-control"
                        type="tel"
                        id="phone"
                        name="phone"
                        value="<?= e($_POST['phone'] ?? $user['phone']) ?>"
                        required
                        pattern="[0-9]{8,15}"
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label" for="new_password">
                        New password
                        <small class="text-muted">
                            (leave empty to keep the old one)
                        </small>
                    </label>

                    <input
                        class="form-control"
                        type="password"
                        id="new_password"
                        name="new_password"
                        minlength="6"
                    >
                </div>

                <button class="btn btn-primary w-100" type="submit">
                    Save changes
                </button>

            </form>

        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>