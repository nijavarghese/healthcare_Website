<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

// Check if patient ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Delete from patient_address table
        $stmt1 = $conn->prepare("DELETE FROM patient_address WHERE fk_patient_id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();

        // Delete from patient_records table
        $stmt2 = $conn->prepare("DELETE FROM patient_record WHERE fk_patient_id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();

        // Delete from patients table
        $stmt3 = $conn->prepare("DELETE FROM patient WHERE patient_id = ?");
        $stmt3->bind_param("i", $id);
        $stmt3->execute();

        // Commit transaction
        $conn->commit();

        echo "Patient removed successfully!";
        header("Location: patient_list.php"); // Redirect back to patient list
        exit();
    } catch (Exception $e) {
        // Rollback transaction if any delete fails
        $conn->rollback();
        echo "Error removing patient: " . $e->getMessage();
    }
} else {
    echo "No patient ID provided.";
    exit();
}
?>
