<?php
// login.php - ONE login page for admins, doctors and patients
// PHP TODO (Member 2): check the email + password, start the session,
//                      and send the user to the dashboard of their role.
$page_title = 'Login';
require 'includes/header.php';
?>

    <div class="form-box">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="mb-4 text-center">Login</h2>

                <!-- PHP TODO (Member 2): show ONLY when login fails -->
                <div class="alert alert-danger">Wrong email or password.</div>

                <form method="POST" action="login.php">
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" type="email" id="email" name="email" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control" type="password" id="password" name="password" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Login</button>
                </form>
                <p class="text-center mt-3 mb-0">New patient? <a href="register.php">Create an account</a></p>
            </div>
        </div>
    </div>

<?php require 'includes/footer.php'; ?>
