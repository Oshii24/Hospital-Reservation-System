<?php
// register.php - a new PATIENT creates an account
// PHP TODO (Member 2): validate the form and INSERT the patient into the users table.
$page_title = 'Register';
require 'includes/header.php';
?>

    <div class="form-box">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="mb-4 text-center">Create a Patient Account</h2>

                <!-- PHP TODO (Member 2): show this red box ONLY when there are validation errors -->
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <li>Example error: Password must be at least 6 characters.</li>
                    </ul>
                </div>

                <!-- The "name" of every input is what PHP reads with $_POST['name'] -->
                <form method="POST" action="register.php">
                    <div class="mb-3">
                        <label class="form-label" for="full_name">Full name</label>
                        <input class="form-control" type="text" id="full_name" name="full_name" required minlength="3">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" type="email" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone">Phone</label>
                        <input class="form-control" type="tel" id="phone" name="phone" required pattern="[0-9]{8,15}" placeholder="Numbers only">
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label" for="gender">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Choose...</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" for="date_of_birth">Date of birth</label>
                            <input class="form-control" type="date" id="date_of_birth" name="date_of_birth" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control" type="password" id="password" name="password" required minlength="6">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="confirm_password">Confirm password</label>
                        <input class="form-control" type="password" id="confirm_password" name="confirm_password" required minlength="6">
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Register</button>
                </form>
                <p class="text-center mt-3 mb-0">Already have an account? <a href="login.php">Log in</a></p>
            </div>
        </div>
    </div>

<?php require 'includes/footer.php'; ?>
