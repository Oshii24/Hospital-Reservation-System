<?php
// profile.php - ANY logged-in user edits their own name, phone and password
// PHP TODO (Member 2): fill the form with the user's data (SELECT) and save changes (UPDATE).
$page_title = 'My Profile';
require 'includes/header.php';
?>

    <div class="form-box">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="mb-1">My Profile</h2>
                <p class="text-muted">
                    Role: <span class="badge bg-info text-dark">patient</span>
                    &middot; Member since 20 Nov 2026
                </p>

                <form method="POST" action="profile.php">
                    <div class="mb-3">
                        <label class="form-label">Email (cannot be changed)</label>
                        <input class="form-control" type="email" value="patient@hospital.com" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="full_name">Full name</label>
                        <input class="form-control" type="text" id="full_name" name="full_name" value="Ali Hassan" required minlength="3">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone">Phone</label>
                        <input class="form-control" type="tel" id="phone" name="phone" value="0500000004" required pattern="[0-9]{8,15}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="new_password">New password <small class="text-muted">(leave empty to keep the old one)</small></label>
                        <input class="form-control" type="password" id="new_password" name="new_password" minlength="6">
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Save changes</button>
                </form>
            </div>
        </div>
    </div>

<?php require 'includes/footer.php'; ?>
