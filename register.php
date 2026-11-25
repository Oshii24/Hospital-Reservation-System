<?php

// Connect to database and start session
require_once 'includes/db.php';
require_once 'includes/auth.php';

$error = "";

// Start empty, so the form can show what the user typed after an error
$name = "";
$email = "";
$phone = "";
$gender = "";
$dob = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get information from the registration form
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];
    $dob = $_POST['date_of_birth'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Check empty fields
    if (
        empty($name) || empty($email) || empty($phone) ||
        empty($gender) || empty($dob) ||
        empty($password) || empty($confirm)
    ) {
        $error = "Please fill all required fields.";
    }

    // Check name
    elseif (strlen($name) < 3) {
        $error = "Name must be at least 3 characters.";
    }

    // Check email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email.";
    }

    // Check phone
    elseif (!preg_match("/^[0-9]{8,15}$/", $phone)) {
        $error = "Invalid phone number.";
    }

    // Check gender
    elseif ($gender != "male" && $gender != "female") {
        $error = "Choose a valid gender.";
    }

    // Check date
    elseif ($dob > date("Y-m-d")) {
        $error = "Invalid date of birth.";
    }

    // Check password
    elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    }

    // Confirm password
    elseif ($password != $confirm) {
        $error = "Passwords do not match.";
    }

    else {

        // Check if email already exists
        $stmt = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $error = "Email already exists.";

        } else {

            // Hash the password
            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Insert patient into database
            $stmt->close();

            $stmt = $conn->prepare(
                "INSERT INTO users
                (full_name, email, phone, gender, date_of_birth, password, role)
                VALUES (?, ?, ?, ?, ?, ?, 'patient')"
            );

            $stmt->bind_param(
                "ssssss",
                $name,
                $email,
                $phone,
                $gender,
                $dob,
                $hashed_password
            );

            if ($stmt->execute()) {

                // Save success message
                set_flash("Account created successfully!");

                // Go to login page
                header("Location: login.php");
                exit();

            } else {

                $error = "Registration failed.";
            }
        }

        $stmt->close();
    }
}

$page_title = 'Register';
require 'includes/header.php';
?>

<div class="form-box">
    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h2 class="mb-4 text-center">Create a Patient Account</h2>

            <?php if ($error != "") { ?>
                <div class="alert alert-danger">
                    <?= e($error) ?>
                </div>
            <?php } ?>

            <form method="POST" action="register.php">

                <div class="mb-3">
                    <label class="form-label" for="full_name">Full name</label>
                    <input class="form-control" type="text"
                           id="full_name" name="full_name"
                           value="<?= e($name) ?>" required minlength="3">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" type="email"
                           id="email" name="email"
                           value="<?= e($email) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="phone">Phone</label>
                    <input class="form-control" type="tel"
                           id="phone" name="phone"
                           value="<?= e($phone) ?>" required pattern="[0-9]{8,15}"
                           placeholder="Numbers only">
                </div>

                <div class="row">

                    <div class="col-6 mb-3">
                        <label class="form-label" for="gender">Gender</label>
                        <select class="form-select" id="gender"
                                name="gender" required>
                            <option value="">Choose...</option>
                            <option value="male" <?= $gender === 'male' ? 'selected' : '' ?>>Male</option>
                            <option value="female" <?= $gender === 'female' ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>

                    <div class="col-6 mb-3">
                        <label class="form-label" for="date_of_birth">
                            Date of birth
                        </label>
                        <input class="form-control" type="date"
                               id="date_of_birth"
                               name="date_of_birth" value="<?= e($dob) ?>"
                               max="<?= date('Y-m-d') ?>" required>
                    </div>

                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" type="password"
                           id="password" name="password"
                           required minlength="6">
                </div>

                <div class="mb-4">
                    <label class="form-label" for="confirm_password">
                        Confirm password
                    </label>
                    <input class="form-control" type="password"
                           id="confirm_password"
                           name="confirm_password"
                           required minlength="6">
                </div>

                <button class="btn btn-primary w-100" type="submit">
                    Register
                </button>

            </form>

            <p class="text-center mt-3 mb-0">
                Already have an account?
                <a href="login.php">Log in</a>
            </p>

        </div>
    </div>
</div>

<?php require 'includes/footer.php'; ?>