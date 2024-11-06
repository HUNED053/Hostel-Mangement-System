<?php
include('db_connect.php'); // Ensure db_connect.php is correctly set up
session_start();

// Check if the student is logged in
if (isset($_POST['enrollment_number']) && isset($_POST['password'])) {
    $enrollment_number = $_POST['enrollment_number'];
    $password = $_POST['password'];

    // Prepared statement to avoid SQL injection
    $sql = "SELECT * FROM student_registration WHERE enrollment_number = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $enrollment_number, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Store enrollment number in session and redirect to dashboard
        $_SESSION['enrollment_number'] = $enrollment_number;
    } else {
        $error = "Invalid Enrollment Number or Password";
    }
} 

if (!isset($_SESSION['enrollment_number'])) {
    // If not logged in, display login form
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Login</title>
        
        <style>
           body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        nav {
            width: 100%;
            padding: 15px;
            background: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
        nav .date-time {
            font-size: 1em;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            font-size: 1.2em;
            padding: 10px 15px;
            border-radius: 5px;
            background: #007BFF;
            transition: background 0.3s;
        }
        nav a:hover {
            background: #0056b3;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 300px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .link {
            margin-top: 20px;
            color: #fff;
        }
        </style>
    </head>
    <body>
    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About Us</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
    </nav>
    <div class="form-container">
        <h2>Student Login</h2>
        <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
        <form action="student_dashboard.php" method="POST">
            <input type="text" name="enrollment_number" placeholder="Enrollment Number" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <div class="link">Don't have an account? <a href="student_registration.php" style="color: #fff;">Register</a></div>
        </form>
    </div>
    </body>
    </html>

    <?php
    exit();
}

// Fetch student details
$enrollment_number = $_SESSION['enrollment_number'];
$sql = "SELECT * FROM student_registration WHERE enrollment_number='$enrollment_number'";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

// Handle complaint submission
if (isset($_POST['complaint'])) {
    $complaint_text = $_POST['complaint'];
    $stmt = $conn->prepare("INSERT INTO complaints (enrollment_number, complaint_content, status) VALUES (?, ?, 'Pending')");
    $stmt->bind_param("ss", $enrollment_number, $complaint_text);
    $stmt->execute();
    $success_message = "Complaint submitted successfully!";
}

// Fetch messages and complaints
$sql_messages = "SELECT * FROM messages WHERE enrollment_number='$enrollment_number'";
$messages_result = $conn->query($sql_messages);
$sql_complaints = "SELECT * FROM complaints WHERE enrollment_number='$enrollment_number'";
$complaints_result = $conn->query($sql_complaints);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    
        /* Navbar styling */
        <style>
       body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }
        nav {
            width: 100%;
            padding: 15px;
            background: rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: space-around;
            align-items: center;
            z-index: 1;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            font-size: 1.2em;
            padding: 10px 15px;
            border-radius: 5px;
            background: #007BFF;
            transition: background 0.3s;
        }
        nav a:hover {
            background: #0056b3;
        }

        Sidebar styling 
        .sidebar {
            width: 200px;
            background-color: linear-gradient(135deg, #ff7e5f, #feb47b); /* Match theme color */
            margin-top: 180px;
            margin-left: -1300px;
            padding: 15px;
            float: left;
            height: 100vh;
            position: fixed;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        }
        .sidebar button {
            background-color: #ffffff;
            color: #FF8C00;
            border: none;FF8C00
            padding: 10px;
            width: 100%;
            height:50px;
            text-align: center;
            margin: 5px 0;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar button:hover {
            background-color: #ffe0b2;
        }

        /* Main content styling */
        .main-content {
            margin-left: 220px;
            padding: 20px;
            padding-top: 60px; /* To avoid overlap with nav */
        }

        #profile-section, #complaint-section, #messages-section {
            border: 1px solid #ddd;
            padding: 20px;
            margin-top: 20px ;
            border-radius: 5px;
            background-color:  linear-gradient(135deg, #ff7e5f, #feb47b);;
            width: 700px;
            height:600px;
        }
        .comp{
            width: 500px;
            height: 100px;
        }
    </style>
</head>
<body>
<nav>
    <a href="index.php">logout</a>
    <a href="about.html">About Us</a>
    <a href="services.html">Services</a>
    <a href="contact.html">Contact</a>
</nav>

<div class="sidebar">
    <button onclick="showSection('profile')">Profile</button>
    <button onclick="showSection('complaint')">Complaint</button>
    <button onclick="showSection('messages')">Messages</button>
</div>

<div class="main-content">
    <?php if (isset($success_message)) { echo "<p style='color: green;'>$success_message</p>"; } ?>

    <div id="profile-section" style="display: block;">
        <h2>Profile</h2>
        <p><strong>Enrollment Number:</strong> <?php echo $student['enrollment_number']; ?></p>
        <p><strong>Full Name:</strong> <?php echo $student['full_name']; ?></p>
        <p><strong>Date of Birth:</strong> <?php echo $student['dob']; ?></p>
        <p><strong>Age:</strong> <?php echo $student['age']; ?></p>
        <p><strong>Gender:</strong> <?php echo $student['gender']; ?></p>
        <p><strong>Mobile Number:</strong> <?php echo $student['mobile_number']; ?></p>
        <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
        <p><strong>Address:</strong> <?php echo $student['address']; ?></p>
    </div>

    <div id="complaint-section" style="display: none;">
        <h2>Complaint Section</h2>
        <form action="student_dashboard.php" method="POST">
            <textarea class="comp" name="complaint" placeholder="Enter your complaint here..." required></textarea>
            <button type="submit">Submit Complaint</button>
        </form>
    </div>

    <div id="messages-section" style="display: none;">
    <h2>Messages</h2>
    <?php if ($messages_result && $messages_result->num_rows > 0) { ?>
        <?php while ($message = $messages_result->fetch_assoc()) { ?>
            <p><strong><?php echo $message['message_content']; ?></strong></p>
            <hr>
        <?php } ?>
    <?php } else { ?>
        <p>No messages available.</p>
    <?php } ?>
</div>
</div>

<script>
function showSection(section) {
    document.getElementById("profile-section").style.display = "none";
    document.getElementById("complaint-section").style.display = "none";
    document.getElementById("messages-section").style.display = "none";
    document.getElementById(section + "-section").style.display = "block";
}
</script>


</body>
</html>
