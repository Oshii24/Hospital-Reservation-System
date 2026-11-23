<?php
// doctor_dashboard.php - the doctor sees appointments booked with them,
//                        changes the status and writes notes
// PHP TODO (Member 4): only doctors can open this page, list THEIR appointments (SELECT + JOIN),
//                      and make the Save button work (UPDATE status + doctor_notes).
$page_title = 'Doctor Dashboard';
require 'includes/header.php';
?>

    <h2 class="mb-3">Appointments booked with me</h2>

    <div class="row g-4">
        <!-- PHP TODO (Member 4): repeat ONE card (the whole col-md-6 div) for every appointment.
             These two cards are samples. -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header d-flex justify-content-between">
                    <strong>2026-11-25 &middot; 10:00</strong>
                    <span class="badge bg-warning">pending</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Ali Hassan</h5>
                    <p class="mb-1"><small class="text-muted">male &middot; born 1998-04-12 &middot; &#128222; 0500000004</small></p>
                    <p><strong>Reason:</strong> Chest pain when running</p>

                    <form method="POST" action="doctor_dashboard.php">
                        <input type="hidden" name="appointment_id" value="1">
                        <div class="mb-2">
                            <select class="form-select form-select-sm" name="status">
                                <option value="pending" selected>Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <textarea class="form-control form-control-sm" name="doctor_notes" rows="2" placeholder="Notes for the patient..."></textarea>
                        </div>
                        <button class="btn btn-sm btn-primary w-100" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header d-flex justify-content-between">
                    <strong>2026-11-27 &middot; 11:30</strong>
                    <span class="badge bg-primary">confirmed</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Mona Saleh</h5>
                    <p class="mb-1"><small class="text-muted">female &middot; born 1985-09-03 &middot; &#128222; 0500000005</small></p>
                    <p><strong>Reason:</strong> Follow-up on blood pressure</p>

                    <form method="POST" action="doctor_dashboard.php">
                        <input type="hidden" name="appointment_id" value="2">
                        <div class="mb-2">
                            <select class="form-select form-select-sm" name="status">
                                <option value="pending">Pending</option>
                                <option value="confirmed" selected>Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <textarea class="form-control form-control-sm" name="doctor_notes" rows="2" placeholder="Notes for the patient...">Bring your last test results.</textarea>
                        </div>
                        <button class="btn btn-sm btn-primary w-100" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php require 'includes/footer.php'; ?>
