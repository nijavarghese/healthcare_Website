<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
}
include 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Start a transaction
    $conn->begin_transaction();

    try {
        // Insert into the patient table
        $stmt1 = $conn->prepare("INSERT INTO patient (fname, lname, gender, DOB, phone, email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param("ssssss", $_POST['first_name'], $_POST['last_name'], $_POST['gender'], $_POST['dob'], $_POST['phone'], $_POST['email']);
        
        if (!$stmt1->execute()) {
            throw new Exception("Error inserting into patient table: " . $stmt1->error);
        }

        // Get the patientid of the newly inserted patient
        $patientid = $conn->insert_id;

        // Insert into the patient_address table
        $stmt2 = $conn->prepare("INSERT INTO patient_address (fk_patient_id, address, province, city, postal_code) VALUES (?, ?, ?, ?, ?)");
        $stmt2->bind_param("issss", $patientid, $_POST['address'], $_POST['province'], $_POST['city'], $_POST['postal_code']);
        
        if (!$stmt2->execute()) {
            throw new Exception("Error inserting into patient_address table: " . $stmt2->error);
        }

        // Insert into the patient_records table
        $stmt3 = $conn->prepare("INSERT INTO patient_record (fk_patient_id, allergies, records, referrals) VALUES (?, ?, ?, ?)");
        $stmt3->bind_param("isss", $patientid, $_POST['allergies'], $_POST['medications'], $_POST['referring_doctor']);
        
        if (!$stmt3->execute()) {
            throw new Exception("Error inserting into patient_records table: " . $stmt3->error);
        }

        // Commit the transaction
        $conn->commit();
        echo "Patient added successfully!";

    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo "Failed to add patient: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Patient</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="styles.css" rel="stylesheet"> <!-- Linking an external CSS file for additional styles -->
</head>
<body>
    <!-- Breadcrumb navigation for better UX -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li> <!-- Link to the homepage -->
            <li class="breadcrumb-item active" aria-current="page">Add a Patient</li> <!-- Current page indicator -->
        </ol>
    </nav>

    <!-- form for adding a patient-->
<div class="container mt-5">
    <h2 class="mb-4">Add New Patient</h2>
    <form action="add_patient.php" method="POST" class="border p-4 bg-light rounded">
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="form-group">
            <label for="gender">Gender:</label>
            <select class="form-control" id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" class="form-control" id="dob" name="dob" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" name="address">
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" class="form-control" id="city" name="city">
        </div>
        <div class="form-group">
            <label for="province">Province:</label>
            <input type="text" class="form-control" id="province" name="province">
        </div>
        <div class="form-group">
            <label for="postal_code">Postal Code:</label>
            <input type="text" class="form-control" id="postal_code" name="postal_code">
        </div>
        <div class="form-group">
            <label for="medications">Medications:</label>
            <textarea class="form-control" id="medications" name="medications" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="allergies">Allergies:</label>
            <textarea class="form-control" id="allergies" name="allergies" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="referring_doctor">Referring Doctor:</label>
            <input type="text" class="form-control" id="referring_doctor" name="referring_doctor">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>