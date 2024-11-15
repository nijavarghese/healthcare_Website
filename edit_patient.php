<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

// Check if the patient ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch current patient data from each table to pre-fill the form
    $stmt_patient = $conn->prepare("SELECT * FROM patient WHERE patient_id = ?");
    $stmt_patient->bind_param("i", $id);
    $stmt_patient->execute();
    $result_patient = $stmt_patient->get_result();
    $patient = $result_patient->fetch_assoc();

    $stmt_address = $conn->prepare("SELECT * FROM patient_address WHERE fk_patient_id = ?");
    $stmt_address->bind_param("i", $id);
    $stmt_address->execute();
    $result_address = $stmt_address->get_result();
    $address = $result_address->fetch_assoc();

    $stmt_records = $conn->prepare("SELECT * FROM patient_record WHERE fk_patient_id = ?");
    $stmt_records->bind_param("i", $id);
    $stmt_records->execute();
    $result_records = $stmt_records->get_result();
    $records = $result_records->fetch_assoc();

    if (!$patient) {
        echo "Patient not found.";
        exit();
    }
} else {
    echo "No patient ID provided.";
    exit();
}

// Update patient data on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update patient table
    $stmt_patient = $conn->prepare("UPDATE patient SET fname=?, lname=?, gender=?, DOB=?, email=?, phone=? WHERE patient_id=?");
    $stmt_patient->bind_param(
        "ssssssi",
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['gender'],
        $_POST['dob'],
        $_POST['email'],
        $_POST['phone'],
        $id
    );

    // Update patient_address table
    $stmt_address = $conn->prepare("UPDATE patient_address SET address=?, city=?, province=?, postal_code=? WHERE fk_patient_id=?");
    $stmt_address->bind_param(
        "ssssi",
        $_POST['address'],
        $_POST['city'],
        $_POST['province'],
        $_POST['postal_code'],
        $id
    );

    // Update patient_records table
    $stmt_records = $conn->prepare("UPDATE patient_record SET records=?, allergies=?, referrals=? WHERE fk_patient_id=?");
    $stmt_records->bind_param(
        "sssi",
        $_POST['medications'],
        $_POST['allergies'],
        $_POST['referring_doctor'],
        $id
    );

    // Execute all update queries and check for success
    if ($stmt_patient->execute() && $stmt_address->execute() && $stmt_records->execute()) {
        echo "Patient updated successfully!";
        header("Location: patient_list.php");
        exit();
    } else {
        echo "Error updating patient: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <!-- Breadcrumb navigation for better UX -->
     <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li> <!-- Link to the homepage -->
            <li class="breadcrumb-item"><a href="patient_list.php">Patient List</a></li> <!-- link to the patient list page-->
            <li class="breadcrumb-item active" aria-current="page">Edit Patient</li> <!-- Current page indicator -->
        </ol>
    </nav>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h2>Edit Patient</h2>
            </div>
            <div class="card-body">
                <form action="edit_patient.php?id=<?php echo $id; ?>" method="POST">
                    <!-- Patient Information -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="first_name">First Name:</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($patient['fname']); ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">Last Name:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($patient['lname']); ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="gender">Gender:</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="M" <?php if ($patient['gender'] == 'M') echo 'selected'; ?>>Male</option>
                                <option value="F" <?php if ($patient['gender'] == 'F') echo 'selected'; ?>>Female</option>
                                <option value="O" <?php if ($patient['gender'] == 'O') echo 'selected'; ?>>Other</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dob">Date of Birth:</label>
                            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $patient['DOB']; ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="phone">Phone:</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($patient['phone']); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($patient['email']); ?>">
                    </div>

                    <!-- Address Information -->
                    <h5 class="mt-4">Address Information</h5>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($address['address']); ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="city">City:</label>
                            <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($address['city']); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="province">Province:</label>
                            <input type="text" class="form-control" id="province" name="province" value="<?php echo htmlspecialchars($address['province']); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="postal_code">Postal Code:</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($address['postal_code']); ?>">
                        </div>
                    </div>

                    <!-- Medical Information -->
                    <h5 class="mt-4">Medical Information</h5>
                    <div class="form-group">
                        <label for="medications">Medications:</label>
                        <textarea class="form-control" id="medications" name="medications" rows="2"><?php echo htmlspecialchars($records['records']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="allergies">Allergies:</label>
                        <textarea class="form-control" id="allergies" name="allergies" rows="2"><?php echo htmlspecialchars($records['allergies']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="referring_doctor">Referring Doctor:</label>
                        <input type="text" class="form-control" id="referring_doctor" name="referring_doctor" value="<?php echo htmlspecialchars($records['referrals']); ?>">
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

