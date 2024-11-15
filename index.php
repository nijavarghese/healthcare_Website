<?php
session_start();
include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Defines the character encoding as UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Sets the viewport for responsive design -->

    <title>MH-Care Welcome</title> <!-- Title of the web page -->

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> <!-- Linking Bootstrap CSS for styling -->
    <link href="styles.css" rel="stylesheet"> <!-- Linking an external CSS file for additional styles -->
    
</head>
<body>
    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-collapse bg-light">

        <!-- Brand logo that links to the homepage -->
        <a class="navbar-brand" href="index.php">
            <img src="logo.png" width="180" height="80" class="d-inline-block align-top" alt="MH-Care Logo"> <!-- Logo image -->
        </a>

        <!-- Button for toggling the navbar on smaller screens -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span> <!-- Icon for the toggler button -->
        </button>

        <!-- Collapsible navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <!-- Mental Health dropdown menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="mentalHealthDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mental Health
                    </a>
                    <div class="dropdown-menu" aria-labelledby="mentalHealthDropdown">
                        <a class="dropdown-item" href="#">Finding Help</a>
                        <a class="dropdown-item" href="#">Brochures</a> 
                        <a class="dropdown-item" href="#">Your Mental Health Questionnaire</a> 
                    </div>
                </li>

                <!-- Services dropdown menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Services
                    </a>
                    <div class="dropdown-menu" aria-labelledby="servicesDropdown">
                        <a class="dropdown-item dropdown-toggle" href="#" id="psychiatryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Psychiatry
                        </a>
                        <div class="dropdown-menu" aria-labelledby="psychiatryDropdown">
                            <a class="dropdown-item" href="appointments.html">Book Appointments</a> <!-- Link to the appointments page -->
                        </div>
                    </div>
                </li>

                <!-- News dropdown menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="newsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        News
                    </a>
                    <div class="dropdown-menu" aria-labelledby="newsDropdown">
                        <a class="dropdown-item" href="#">Press Releases</a> 
                        <a class="dropdown-item" href="#">FAQ</a> 
                    </div>
                </li>

                <!-- About dropdown menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        About
                    </a>
                    <div class="dropdown-menu" aria-labelledby="aboutDropdown">
                        <a class="dropdown-item" href="#">About Us</a> 
                        <a class="dropdown-item" href="#">Our Team</a> 
                        <a class="dropdown-item" href="#">Contact Us</a> 
                    </div>
                </li>
            </ul>
            
            <!-- Logout button aligned to the right -->
            <ul class="navbar-nav ml-auto">
                <?php if(isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <span class="navbar-text">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger ml-2" href="logout.php" role="button">Logout</a> <!-- Logout button -->
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="login.php" role="button">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Language selector for English and French -->
    <div class="language-selector">
        <a href="#">English</a> | <a href="#">French</a>
    </div>

    <!-- Main heading -->
    <h1>Welcome to MH-Care</h1>

    <!-- Button Section for Patient Management (visible only if logged in) -->
    <?php if(isset($_SESSION['username'])): ?>
        <div class="container mt-4 text-center">
            <a href="add_patient.php" class="btn btn-success m-2">Add a Patient</a>
            <a href="patient_list.php" class="btn btn-info m-2">View Patients List</a>
        </div>
    <?php endif; ?>

    <!-- Image Section -->
    <div class="container mt-4">
        <img src="https://ysm-res.cloudinary.com/image/upload/ar_16:9,c_fill,dpr_3.0,f_auto,g_faces:auto,q_auto:eco,w_500/v1/yms/prod/c3cb8ba8-c6f4-422f-b18c-a29dd21d3447" alt="Mental Health Care" class="img-fluid"> <!-- Responsive image -->
    </div>

    <!-- Footer Section -->
    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="text-center p-3">
            <p>Contact us: <a href="mailto:contact@sjhc.london.on.ca">contact@sjhc.london.on.ca</a></p> <!-- Contact email -->
            <p>&copy; 2024 MH-Care. All rights reserved.</p> <!-- Copyright information -->
        </div>
    </footer>
</body>

<!-- JavaScript for Bootstrap functionality -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> <!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script> <!-- Popper.js for positioning tooltips/popovers -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <!-- Bootstrap JavaScript library -->
</html>