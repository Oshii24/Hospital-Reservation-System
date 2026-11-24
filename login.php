<?php

// Connect to database and start session
require_once 'includes/db.php';
require_once 'includes/auth.php';

$page_title = 'Login';

$error = '';
$email = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check if fields are empty
    if (empty($email) || empty($password)) {

        $error = 'Please enter your email and password.';

    } else {

        // Search for the user by email
        $stmt = $conn->prepare(
            "SELECT id, full_name, password, role FROM users WHERE email = ?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Check if user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {

            // Create a new session ID
            session_regenerate_id(true);

            // Save user information in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            // Redirect according to user role
            if ($user['role'] === 'admin') {

                header('Location: admin_dashboard.php');

            } elseif ($user['role'] === 'doctor') {

                header('Location: doctor_dashboard.php');

            } else {

                header('Location: patient_dashboard.php');
            }

            exit;

        } else {

            $error = 'Wrong email or password.';
        }

        $stmt->close();
    }
}

require 'includes/header.php';
?>

<div class="form-box">
    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h2 class="mb-4 text-center">Login</h2>

            <?php show_flash(); ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">

                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>

                    <input
                        class="form-control"
                        type="email"
                        id="email"
                        name="email"
                        value="<?= e($email) ?>"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password">Password</label>

                    <input
                        class="form-control"
                        type="password"
                        id="password"
                        name="password"
                        required
                    >
                </div>

                <button class="btn btn-primary w-100" type="submit">
                    Login
                </button>

            </form>

            <p class="text-center mt-3 mb-0">
                New patient?
                <a href="register.php">Create an account</a>
            </p>

        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>