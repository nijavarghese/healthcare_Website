<?php
session_start();
include 'config.php'; // Include database configuration

$error = ""; // Variable to store error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = trim($_POST['username']);
    $password = trim(md5($_POST['password']));
    
    // Check if username and password are not empty
    if (!empty($username) && !empty($password)) {

        // Prepare and execute the SQL statement to fetch the user
        $sql = "SELECT loginid, username FROM login WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if a matching record is found
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['loginid'] = $user['loginid']; // Store login ID in session
            $_SESSION['username'] = $user['username']; // Store username in session
            
            // Redirect to the page
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }

        $stmt->close();
    } else {
        $error = "Please enter both username and password.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Breadcrumb navigation for better UX -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li> <!-- Link to the homepage -->
            <li class="breadcrumb-item active" aria-current="page">Login Page</li> <!-- Current page indicator -->
        </ol>
    </nav>
    <div class="container mt-5">
        <h2>Login</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <!--login form-->
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
