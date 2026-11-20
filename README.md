# 🏥 City Hospital – Hospital Management System

**Course:** CCS2305 Web Programming
**Built with:** HTML · CSS (Bootstrap 5) · PHP · MySQL

| Member | Name | Student ID | Part |
|--------|------|-----------|------|
| Member 1 | _(name)_ | _(id)_ | Database + Accounts (register, login, sessions) |
| Member 2 | _(name)_ | _(id)_ | Patient + Doctor pages |
| Member 3 | _(name)_ | _(id)_ | Admin pages |

---

## 📑 Contents

1. [About the project](#1-about-the-project)
2. [Database design (ERD)](#2-database-design-erd)
3. [Course requirements checklist](#3-course-requirements-checklist)
4. [Setup – run it on your computer](#4-setup--run-it-on-your-computer)
5. [What is already done](#5-what-is-already-done)
6. [Who does what](#6-who-does-what)
7. [Member 1 guide – Database + Accounts](#7-member-1-guide--database--accounts)
8. [Member 2 guide – Patient + Doctor pages](#8-member-2-guide--patient--doctor-pages)
9. [Member 3 guide – Admin pages](#9-member-3-guide--admin-pages)
10. [PHP cheat sheet (everyone reads this)](#10-php-cheat-sheet-everyone-reads-this)
11. [Git workflow for the team](#11-git-workflow-for-the-team)
12. [Troubleshooting](#12-troubleshooting)
13. [Next phase – Bonuses](#13-next-phase--bonuses)

---

## 1. About the project

### Introduction
**City Hospital** is a website where patients book appointments online, doctors manage their appointments, and admins manage the whole hospital. There are **three types of users** – Admin, Doctor, Patient – and each one has its own pages.

### Problem definition
Many clinics still book by **phone or paper**. That means long waits on the phone, **double bookings**, lost records, and patients who don't know if their appointment is confirmed.
Our website puts everything in one place and **blocks double bookings automatically**.

### What each user can do

| Patient | Doctor | Admin |
|---------|--------|-------|
| Register & log in | Log in (account made by admin) | Log in |
| Book an appointment | See appointments booked with them | See totals (patients, doctors…) |
| See their appointments + doctor notes | Confirm / complete / cancel | See & delete any appointment |
| Cancel an appointment | Write notes for the patient | Add / edit / delete departments |
| Edit their profile | Edit their profile | Add & delete doctors |
| | | Search & delete patients |

---

## 2. Database design (ERD)

> GitHub draws this diagram automatically. For the written documentation, take a screenshot of it.

```mermaid
erDiagram
    USERS ||--o| DOCTORS : "can be a"
    DEPARTMENTS ||--o{ DOCTORS : "has"
    USERS ||--o{ APPOINTMENTS : "books (as patient)"
    DOCTORS ||--o{ APPOINTMENTS : "handles"

    USERS {
        int id PK
        varchar full_name
        varchar email UK
        varchar password "hashed"
        varchar phone
        enum gender "male, female"
        date date_of_birth
        enum role "admin, doctor, patient"
        timestamp created_at
    }
    DEPARTMENTS {
        int id PK
        varchar name UK
        text description
    }
    DOCTORS {
        int id PK
        int user_id FK "UNIQUE, users.id"
        int department_id FK "departments.id"
        varchar specialization
    }
    APPOINTMENTS {
        int id PK
        int patient_id FK "users.id"
        int doctor_id FK "doctors.id"
        date appointment_date
        time appointment_time
        varchar reason
        enum status "pending, confirmed, completed, cancelled"
        text doctor_notes
        timestamp created_at
    }
```

**How to read it**

| Line | Meaning |
|------|---------|
| USERS – DOCTORS | One user can be **zero or one** doctor. Only users with role `doctor` have a row in `doctors`. |
| DEPARTMENTS – DOCTORS | One department has **many** doctors. |
| USERS – APPOINTMENTS | One patient books **many** appointments. |
| DOCTORS – APPOINTMENTS | One doctor has **many** appointments. |

**PK** = Primary Key (unique id) · **FK** = Foreign Key (points to another table's id) · **UK** = Unique

**Why it's designed this way**
- **One `users` table for everyone.** All three roles log in with email + password, so one table + a `role` column = one simple login page.
- **`doctors` only stores the extra doctor info** (department, specialization).
- When a user is deleted, their doctor row and appointments should be deleted too → `ON DELETE CASCADE`.
- When a department is deleted, its doctors stay but lose the department → `ON DELETE SET NULL`.

---

## 3. Course requirements checklist

| Requirement | Where | Who |
|-------------|-------|-----|
| HTML | All pages | ✅ Done |
| CSS (Bootstrap) | All pages + `css/style.css` | ✅ Done |
| PHP Validation | Every form | Everyone |
| PHP Sessions | Login, logout, page protection | Member 1 (everyone uses it) |
| Database | `database/hospital.sql`, `includes/db.php` | Member 1 (everyone uses it) |
| Insert / Select / Update / Delete | Every member uses all four (see section 6) | Everyone |
| Admin with own interface | `admin_*.php` | Member 3 |
| User: register, login, use a feature | `register.php`, `login.php`, booking | Member 1 + 2 |
| Extra user type | Doctor | Member 2 |

---

## 4. Setup – run it on your computer

**1. Install** (once):
- **XAMPP** – <https://www.apachefriends.org> (gives you Apache to run PHP + MySQL for the database)
- **Git** – <https://git-scm.com/downloads>
- **VS Code** – <https://code.visualstudio.com>

**2. Clone the project into XAMPP's `htdocs` folder** (XAMPP only runs files in there):

```bash
cd C:/xampp/htdocs
```

```bash
git clone https://github.com/YOUR-USERNAME/YOUR-REPO-NAME.git hospital
```

**3. Start the server:** open the **XAMPP Control Panel** → click **Start** on **Apache** and **MySQL**.

**4. Open the site:** <http://localhost/hospital>

**5. Database** (after Member 1 has pushed `database/hospital.sql`):
open <http://localhost/phpmyadmin> → **Import** tab → choose `database/hospital.sql` → **Import**.
Re-import it whenever Member 1 changes it.

> ⚠️ Always open pages through `http://localhost/hospital/...`. Double-clicking a `.php` file will **not** work.

---

## 5. What is already done

✅ **All HTML + Bootstrap pages** are finished, with **sample data** so you can see how they look.

Each page is saved as `.php` (a `.php` file can contain plain HTML), so you add PHP **inside the same file** – no renaming, links keep working.

Inside every page you'll find comments like this:

```html
<!-- PHP TODO (Member 2): repeat ONE <tr> for every appointment. These rows are samples. -->
```

That's your job marker. Search your files for `PHP TODO` to find all of them.

```
hospital/
├── index.php               Home page                     → Member 3 (departments list)
├── register.php            Patient sign-up               → Member 1
├── login.php               Login for all roles           → Member 1
├── profile.php             Edit my profile               → Member 2
├── patient_dashboard.php   Patient's appointments        → Member 2
├── book_appointment.php    Book an appointment           → Member 2
├── doctor_dashboard.php    Doctor's appointments         → Member 2
├── admin_dashboard.php     Totals + all appointments     → Member 3
├── admin_departments.php   Manage departments            → Member 3
├── admin_doctors.php       Manage doctors                → Member 3
├── admin_patients.php      Manage patients               → Member 3
└── css/style.css           Our extra styles              ✅ done
```

---

## 6. Who does what

Every member uses **Validation, Sessions, and all 4 database actions**, so everyone can answer questions in the individual discussion.

| | Member 1 – Database + Accounts | Member 2 – Patient + Doctor | Member 3 – Admin |
|-|-------------------------------|-----------------------------|------------------|
| **Files** | `database/hospital.sql` (new), `includes/*` (new), `logout.php` (new), `register.php`, `login.php` | `book_appointment.php`, `patient_dashboard.php`, `doctor_dashboard.php`, `profile.php` | `admin_dashboard.php`, `admin_departments.php`, `admin_doctors.php`, `admin_patients.php`, `index.php` |
| **INSERT** | Register a patient | Book an appointment | Add department, add doctor |
| **SELECT** | Login | Appointments lists, doctor list | Totals, all lists, search |
| **UPDATE** | – (sample data) | Cancel, doctor status/notes, profile | Edit department |
| **DELETE** | – | – | Delete appointment / department / doctor / patient |
| **Validation** | Register + login forms | Booking + profile forms | Department + doctor forms |
| **Sessions** | Builds it (login/logout/protection) | Uses it (who is logged in) | Uses it (admin only) |

### Order of work (important!)

```
Week 1:  Member 1 → Steps 1–3 (database + includes)  → push  → tell the team
         Member 2 & 3 → read section 10, practise your SQL queries in phpMyAdmin
Week 2+: Everyone works on their own pages, in their own branch, at the same time
```

Member 1 goes first because everyone needs the database and the shared files.

---

## 7. Member 1 guide – Database + Accounts

### Step 1 – Create `database/hospital.sql`
1. Make a folder `database` and a file `hospital.sql` inside it.
2. Write `CREATE TABLE` for the 4 tables in the ERD (section 2). Start the file with:
   ```sql
   DROP DATABASE IF EXISTS hospital_db;
   CREATE DATABASE hospital_db;
   USE hospital_db;
   ```
3. Order matters: create `users` and `departments` **before** `doctors`, and `doctors` before `appointments` (you can't point to a table that doesn't exist yet).
4. Example of one foreign key line:
   ```sql
   FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
   ```
5. Add **sample data**: 4 departments, 1 admin, 2 doctors (a `users` row + a `doctors` row each), 1 patient.
6. Passwords must be **hashed**. To get a hash, make a temporary file `hash.php`, open it at `localhost/hospital/hash.php`, copy the result, then delete the file:
   ```php
   <?php echo password_hash('password', PASSWORD_DEFAULT);
   ```
7. Import it in phpMyAdmin to test. Push it.

### Step 2 – Create `includes/db.php`
Connects to the database. Every page will `require_once 'includes/db.php';` and then use `$conn`. See [cheat sheet 10.1](#101-connect-to-the-database).

### Step 3 – Create the shared files in `includes/`
| File | What goes in it |
|------|-----------------|
| `header.php` | Everything from `<!DOCTYPE html>` down to `<main ...>` (copy it from any page). Make the **navbar change by role** using `$_SESSION['role']` (the 4 navbar versions are already in the pages – look at them). Also call `show_flash();` right after `<main>`. |
| `footer.php` | From `</main>` to `</html>`. |
| `auth.php` | `session_start()` and these small functions: `require_login($role)`, `set_flash($msg)`, `show_flash()`, `e($text)`. See [10.5](#105-sessions) and [10.7](#107-print-safely-with-e). |

Then **in every page**, replace the copied navbar/footer with:
```php
<?php $page_title = 'Login'; require 'includes/header.php'; ?>
   ... the page content ...
<?php require 'includes/footer.php'; ?>
```
Push this **before** the others start, so nobody gets merge conflicts.

### Step 4 – `register.php`
1. When the form is sent (`POST`), read every field from `$_POST`.
2. **Validate** ([10.4](#104-validation)): name ≥ 3 letters, valid email, phone digits only, gender is male/female, date of birth not in the future, password ≥ 6, both passwords match.
3. Check the email isn't already used (`SELECT`).
4. If no errors → `password_hash()` the password → `INSERT` with role `'patient'` → flash "Account created" → redirect to `login.php`.
5. If errors → show them in the red box, and keep what the user typed (`value="<?= e($email) ?>"`).

### Step 5 – `login.php`
1. Validate email + password are filled.
2. `SELECT id, full_name, password, role FROM users WHERE email = ?`
3. `password_verify($typed, $user['password'])` → if true, save `user_id`, `full_name`, `role` in `$_SESSION`.
4. Redirect by role: admin → `admin_dashboard.php`, doctor → `doctor_dashboard.php`, patient → `patient_dashboard.php`.
5. Wrong → show "Wrong email or password."

### Step 6 – `logout.php` (new file, no HTML)
`session_start()`, `session_destroy()`, redirect to `login.php`.

✅ **Done when:** you can register, log in as each role, land on the right dashboard, and log out.

---

## 8. Member 2 guide – Patient + Doctor pages

Start each page with:
```php
<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_login('patient');   // or 'doctor' on the doctor page
```

### `book_appointment.php` (INSERT)
1. Fill the doctor `<select>` with a `SELECT` that JOINs `doctors` → `users` (name) → `departments` (name). [10.6](#106-join--combine-tables)
2. On submit, **validate**: doctor exists, date is today or later, time is in the list, reason 5–255 chars.
3. **Block double booking:** `SELECT` an appointment with the same doctor + date + time whose status isn't `'cancelled'`. If found → error.
4. `INSERT` the appointment with `patient_id = $_SESSION['user_id']` → flash → redirect to `patient_dashboard.php`.

### `patient_dashboard.php` (SELECT + UPDATE)
1. `SELECT` the appointments `WHERE patient_id = ?` (your own `user_id`), JOIN to get the doctor's name and department.
2. Loop and print one `<tr>` per row ([10.3](#103-show-rows-in-a-table)). Show the "no appointments" box if there are 0 rows.
3. Show the **Cancel** button only for `pending` or `confirmed`.
4. Cancel: `UPDATE appointments SET status = 'cancelled' WHERE id = ? AND patient_id = ?`
   (the `AND patient_id` stops patients cancelling other people's appointments).

### `doctor_dashboard.php` (SELECT + UPDATE)
1. ⚠️ `users.id` is **not** the same as `doctors.id`. First find the doctor's id:
   `SELECT id FROM doctors WHERE user_id = ?`
2. `SELECT` the appointments `WHERE doctor_id = ?`, JOIN `users` for the patient's info. One card per row.
3. Save button: validate the status is one of the 4 allowed values → `UPDATE ... SET status = ?, doctor_notes = ? WHERE id = ? AND doctor_id = ?`.

### `profile.php` (SELECT + UPDATE)
1. `require_login();` (no role = any logged-in user).
2. `SELECT` the user's info and put it in the inputs' `value`.
3. On submit: validate name + phone → `UPDATE`. If "new password" isn't empty → hash it → `UPDATE` the password too.
4. Update `$_SESSION['full_name']` so the navbar shows the new name.

✅ **Done when:** a patient can book, see, and cancel; a doctor sees it, changes the status, writes a note; the patient sees the note.

---

## 9. Member 3 guide – Admin pages

Start each admin page with `require_login('admin');` (see Member 2's first snippet).

### `admin_dashboard.php` (SELECT + DELETE)
1. 4 numbers: `SELECT COUNT(*) AS c FROM users WHERE role = 'patient'`, and the same for `doctors`, `departments`, `appointments`.
2. All appointments: JOIN `appointments` → `users` (patient name) and → `doctors` → `users` again (doctor name). Tip: give the same table two nicknames: `JOIN users p ...` and `JOIN users du ...`.
3. Delete button: `DELETE FROM appointments WHERE id = ?`.

### `admin_departments.php` (all 4: INSERT, SELECT, UPDATE, DELETE)
This is the best page to explain CRUD in the discussion.
1. **SELECT** all departments into the table.
2. Form sent with `id = 0` → **INSERT**. With `id > 0` → **UPDATE**.
3. Clicking **Edit** opens `admin_departments.php?edit=3` → read `$_GET['edit']`, `SELECT` that department, fill the form, put its id in the hidden input, and change the title to "Edit department".
4. Validate: name ≥ 2 chars and not already used.
5. **DELETE** when `action = delete`.

### `admin_doctors.php` (INSERT into 2 tables + DELETE)
1. Fill the department `<select>` from the database.
2. Validate all fields + email not already used.
3. `INSERT` into `users` with role `'doctor'` → get the new id with `$conn->insert_id` → `INSERT` into `doctors` with that `user_id`.
4. Delete: `DELETE FROM users WHERE id = ? AND role = 'doctor'` (the doctors row disappears by itself thanks to `ON DELETE CASCADE`).

### `admin_patients.php` (SELECT with search + DELETE)
1. Read `$_GET['search']`. Use `WHERE role = 'patient' AND (full_name LIKE ? OR email LIKE ?)` with `'%' . $search . '%'`.
2. Delete: `DELETE FROM users WHERE id = ? AND role = 'patient'`.

### `index.php`
Replace the 4 sample department cards with a loop over `SELECT name, description FROM departments`.

✅ **Done when:** you can add/edit/delete a department, add a doctor who can then log in, search & delete patients, and delete appointments.

---

## 10. PHP cheat sheet (everyone reads this)

### 10.1 Connect to the database
```php
<?php
$conn = new mysqli('localhost', 'root', '', 'hospital_db');   // XAMPP: user root, no password
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
```

### 10.2 Run a query safely (prepared statements)
❌ Never put user input straight into SQL (*SQL injection*):
```php
$conn->query("SELECT * FROM users WHERE email = '$email'");
```
✅ Always use `?` placeholders:
```php
$stmt = $conn->prepare('SELECT id, full_name FROM users WHERE email = ?');
$stmt->bind_param('s', $email);      // one letter per ?   s = string, i = integer
$stmt->execute();
$result = $stmt->get_result();       // only for SELECT
$user = $result->fetch_assoc();      // one row as an array, or null
```
INSERT / UPDATE / DELETE are the same, just without `get_result()`.

### 10.3 Show rows in a table
```php
<?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= e($row['full_name']) ?></td>
        <td><?= e($row['email']) ?></td>
    </tr>
<?php endwhile; ?>
```
`<?= ... ?>` is short for `<?php echo ...; ?>`. Check `$result->num_rows === 0` for "nothing found".

### 10.4 Validation
```php
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email.';
    if (strlen($password) < 6)                     $errors[] = 'Password too short.';
    if (!preg_match('/^[0-9]{8,15}$/', $phone))    $errors[] = 'Phone: digits only.';
    if ($date < date('Y-m-d'))                     $errors[] = 'Date is in the past.';

    if (empty($errors)) {
        // safe to save to the database
    }
}
```
The HTML already checks in the browser (`required`, `minlength`, `pattern`), but **PHP must check again** because anyone can bypass the browser.

### 10.5 Sessions
```php
session_start();                          // top of every page (put it in auth.php)
$_SESSION['user_id'] = $user['id'];       // save (at login)
$id = $_SESSION['user_id'];               // read (on any page)
session_destroy();                        // forget everything (at logout)
```
Protect a page:
```php
function require_login($role = null) {
    if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
    if ($role && $_SESSION['role'] !== $role) { header('Location: index.php'); exit; }
}
```
Flash message (shows once on the next page):
```php
function set_flash($msg) { $_SESSION['flash'] = $msg; }
function show_flash() {
    if (isset($_SESSION['flash'])) {
        echo '<div class="alert alert-success">' . e($_SESSION['flash']) . '</div>';
        unset($_SESSION['flash']);
    }
}
```

### 10.6 JOIN – combine tables
```sql
SELECT a.appointment_date, u.full_name AS doctor_name
FROM appointments a
JOIN doctors d ON a.doctor_id = d.id     -- appointment -> doctor
JOIN users u   ON d.user_id   = u.id     -- doctor -> their name
WHERE a.patient_id = ?
```
Tip: write and test your SQL in **phpMyAdmin → SQL tab** first, then put it in PHP.

### 10.7 Print safely with `e()`
```php
function e($text) { return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8'); }
```
Always print user data as `<?= e($row['name']) ?>` so nobody can inject `<script>` (*XSS*).

### 10.8 Passwords
```php
$hash = password_hash($password, PASSWORD_DEFAULT);   // register: store $hash
password_verify($typed, $user['password']);           // login: true or false
```

### 10.9 Redirect after saving
```php
set_flash('Saved!');
header('Location: patient_dashboard.php');
exit;
```
This stops the form being sent twice when someone presses F5. Do all PHP logic **above** `require 'includes/header.php'`, because a redirect fails once HTML has been printed.

---

## 11. Git workflow for the team

**Rules:** never work on `main` directly · pull before you start · only edit **your own files**.

**1. Get the latest code**
```bash
git checkout main
```
```bash
git pull
```
**2. Make your own branch** (once per feature)
```bash
git checkout -b member2-booking
```
**3. Save your work**
```bash
git add .
```
```bash
git commit -m "Add booking validation and insert"
```
**4. Upload it**
```bash
git push -u origin member2-booking
```
**5. On GitHub:** click **Compare & pull request** → **Create pull request** → a teammate checks it → **Merge**.

**6. Back to main and update**
```bash
git checkout main
```
```bash
git pull
```

**Merge conflict?** Git marks the file with `<<<<<<<`, `=======`, `>>>>>>>`. Keep the right lines, delete the markers, then `git add .` and `git commit`. VS Code shows *Accept Current / Incoming / Both* buttons to help.

---

## 12. Troubleshooting

| Problem | Fix |
|---------|-----|
| Browser shows code instead of the page | Open through `http://localhost/hospital/...` |
| `Not Found` | The folder isn't in `C:\xampp\htdocs`, or has another name |
| `Connection failed` | Start MySQL in XAMPP |
| `Unknown database 'hospital_db'` | Import `database/hospital.sql` |
| Apache won't start | Port 80 is busy: XAMPP → Apache **Config** → `httpd.conf` → change `Listen 80` to `Listen 8080`, use `localhost:8080/hospital` |
| `Cannot modify header information` | You printed HTML before `header('Location: ...')`. Move the PHP logic above the HTML |
| Blank white page | Add `ini_set('display_errors', 1); error_reporting(E_ALL);` at the top to see the error |
| No styling | Bootstrap loads from the internet – check your connection |

---

## 13. Next phase – Bonuses

Up to **+5 marks**. Starts once the PHP is working. One bonus per person, kept simple:

| Bonus | Idea | Who |
|-------|------|-----|
| Cookies + Dark/Light mode | "Remember my email" on login; dark mode toggle that is remembered | Member 1 |
| JavaScript | "Are you sure?" before Delete/Cancel; live "passwords match" check | Member 2 |
| jQuery | Live search on the patients table without reloading | Member 3 |
| Arabic + English | Language switch (together at the end, if time allows) | Everyone |
| Angular / React / Node.js | Skipped – too big for this project | – |
