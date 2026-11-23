<?php
// book_appointment.php - a patient books an appointment with a doctor
// PHP TODO (Member 3): fill the doctor list from the database (SELECT),
//                      validate the form, block double bookings, and save it (INSERT).
$page_title = 'Book Appointment';
require 'includes/header.php';
?>

    <div class="form-box">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="mb-4 text-center">Book an Appointment</h2>

                <!-- PHP TODO (Member 3): show ONLY when there are validation errors -->
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <li>Example error: This doctor is already booked at that time.</li>
                    </ul>
                </div>

                <form method="POST" action="book_appointment.php">
                    <div class="mb-3">
                        <label class="form-label" for="doctor_id">Doctor</label>
                        <select class="form-select" id="doctor_id" name="doctor_id" required>
                            <option value="">Choose a doctor...</option>
                            <!-- PHP TODO (Member 3): one <option> per doctor. value = doctors.id -->
                            <option value="1">Dr. Sara Ahmed &mdash; Cardiology (Cardiologist)</option>
                            <option value="2">Dr. Omar Khalid &mdash; Pediatrics (Pediatrician)</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label" for="appointment_date">Date</label>
                            <!-- PHP TODO (Member 3): add min="today's date" so past days can't be picked -->
                            <input class="form-control" type="date" id="appointment_date" name="appointment_date" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" for="appointment_time">Time</label>
                            <select class="form-select" id="appointment_time" name="appointment_time" required>
                                <option value="">Choose...</option>
                                <option>09:00</option><option>09:30</option>
                                <option>10:00</option><option>10:30</option>
                                <option>11:00</option><option>11:30</option>
                                <option>12:00</option><option>12:30</option>
                                <option>13:00</option><option>13:30</option>
                                <option>14:00</option><option>14:30</option>
                                <option>15:00</option><option>15:30</option>
                                <option>16:00</option><option>16:30</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="reason">Reason for the visit</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required minlength="5" maxlength="255"></textarea>
                    </div>
                    <button class="btn btn-success w-100" type="submit">Book</button>
                </form>
            </div>
        </div>
    </div>

<?php require 'includes/footer.php'; ?>
