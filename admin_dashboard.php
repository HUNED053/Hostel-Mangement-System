<?php
session_start();
include 'db_connect.php';

// Handle admin login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['admin_logged_in'])) {
    $admin_id = $_POST['admin_id'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin_login WHERE admin_id = '$admin_id' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error_message = "Invalid Admin ID or Password";
    }
}

// Redirect to login if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    
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
            margin: 0;
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
        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }
        button {
            background-color: #007BFF;
            color: white;
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
    <div class="date-time"></div>
    <a href="index.php">Home</a> <!-- Home Button Added -->
    <a href="about.html">About Us</a>
    <a href="services.html">Services</a>
    <a href="contact.html">Contact</a>
</nav>
    <div class="form-container">
        <h2>Admin Login</h2>
        <form method="POST">
            <input type="text" name="admin_id" placeholder="Admin ID" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>
    </div>
</body>
</html>
<?php
    exit();
}
?>

<!-- Admin Dashboard -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
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
            justify-content: flex-start;
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

        .sidebar {
            width: 200px;
            background-color: linear-gradient(135deg, #ff7e5f, #feb47b); /* Match theme color */
            margin-top:70px;
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
            border: none;
            padding: 10px;
            width: 100%;
            height: 50px;
            text-align: center;
            margin: 5px 0;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar button:hover {
            background-color: #ffe0b2;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
            padding-top: 60px;   /* To avoid overlap with nav */
        }

        .section {
            border: 1px solid #ddd;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            width: 700px;
            
        }
        .section.active {
            display: block; /* Show active section */
        }
        .heading{
            margin-top: 100px;
            text-align: center;
        }
        .hidden{
            display: none;
        }
    </style>
    <script>
        // Function to handle section switching
        function showSection(sectionId) {
    // Hide all sections
    console.log("yes")
    document.querySelectorAll('.section').forEach((section) => {
        section.classList.add('hidden');
    });

    // Show the specific section if it exists
    const targetSection = document.getElementById(sectionId);
    
    if (targetSection) { 
        // Element exists; proceed to show it
        targetSection.classList.remove('hidden');
    } else {
        // Log an error if the element is not found
        console.error(`Element with ID '${sectionId}' not found.`);
    }
}

    </script>
</head>
<body>

<!-- Header with Logout -->
<header>
    <h1 class="heading">&nbsp;Admin Dashboard</h1>
    <nav>
        <a href="index.php">Logout</a>
        <a href="about.html">About Us</a>
        <a href="services.html">Services</a>
        <a href="contact.html">Contact</a>
    </nav>
</header>

<!-- Sidebar with navigation -->
<div class="sidebar">
    <button onclick="showSection('students')">Students List</button>
    <button onclick="showSection('complaints')">Complaints</button>
    <button onclick="showSection('rooms')">Room Management</button>
    <button onclick="showSection('messages')">Send Message</button>
</div>

<!-- Content Area -->
<div class="content">

    <!-- Welcome Message -->
    <div id="welcome-message" class="section active">
        <h2>Welcome Admin</h2>
    </div>

  <!-- Students List Section -->
<div id="students" class="section hidden">
    <h2>Students List</h2>
    <?php
    $sql = "SELECT enrollment_number, full_name FROM student_registration";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($student = $result->fetch_assoc()) {
            $enrollment_no = htmlspecialchars($student['enrollment_number']);
            $full_name = htmlspecialchars($student['full_name']);
            echo "<div>";
            echo "<p style='cursor:pointer;' onclick=\"fetchtudentDetails('$enrollment_no')\">$full_name ($enrollment_no)</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No students found.</p>";
    }
    ?>
    <div id="student-details" style="display:none;"></div>
    <!-- Initially hidden -->
</div>

<script>
function fetchStudentDetails(enrollment_no) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `admin_dashboard.php?action=fetch_student_details&enrollment_no=${enrollment_no}`, true);
    
    xhr.onload = function () {
    console.log('Response Status:', xhr.status); // Logs the response status
    console.log('Response Text:', xhr.responseText); // Logs the entire response text
    if (xhr.status === 200) {
        document.getElementById('student-details').innerHTML = xhr.responseText;
        document.getElementById('student-details').style.display = 'block'; // Show the details section
    } else {
        console.error('Error fetching student details');
    }
};

    
    
    xhr.onerror = function() {
        console.error('Request failed');
    };

    xhr.send();
};

</script>

    <!-- Complaints Section -->
    <div id="complaints" class="section hidden">
        <h2>Complaints</h2>
        <?php
        $sql = "SELECT * FROM complaints";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($complaint = $result->fetch_assoc()) {
                $complaint_id = $complaint['id'];
                $complaint_text = $complaint['complaint_content'];
                $student_id = $complaint['enrollment_number'];

                echo "<div>";
                echo "<p><strong>Complaint from $student_id:</strong> $complaint_text</p>";
                echo "<button onclick=\"solveComplaint($complaint_id, '$student_id')\">Solve</button>";
                echo "</div>";
            }
        } else {
            echo "<p>No complaints found.</p>";
        }
        ?>
        <script>
            function solveComplaint(complaint_id, student_id) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `admin_dashboard.php?action=solve_complaint&complaint_id=${complaint_id}&student_id=${student_id}`, true);
                xhr.onload = function () {
                    if (this.status == 200) {
                        alert('Complaint resolved and message sent to student.');
                        location.reload(); // Reload the page to see updated complaints
                    }
                };
                xhr.send();
            }
        </script>
    </div>

    <!-- Room Management Section -->
    <div id="rooms" class="section hidden">
        <h2>Room Management</h2>
        <?php
        $sql = "SELECT * FROM room";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($room = $result->fetch_assoc()) {
                $room_no = $room['room_no'];
                $status = $room['status'] ? "Allotted" : "Not Allotted";
                echo "<div>";
                echo "<p>Room No: $room_no - Status: $status</p>";
                if (!$room['status']) {
                    echo "<button onclick=\"allotRoom('$room_no')\">Allot</button>";
                } else {
                    echo "<button onclick=\"revokeRoom('$room_no')\">Revoke</button>";
                }
                echo "</div>";
            }
        } else {
            echo "<p>No rooms found.</p>";
        }
        ?>
        <script>
            function allotRoom(room_no) {
                const enrollment_no = prompt("Enter enrollment number to allot the room:");
                if (enrollment_no) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', `admin_dashboard.php?action=allot_room&room_no=${room_no}&enrollment_no=${enrollment_no}`, true);
                    xhr.onload = function () {
                        if (this.status == 200) {
                            alert('Room allotted successfully.');
                            location.reload();
                        }
                    };
                    xhr.send();
                }
            }

            function revokeRoom(room_no) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `admin_dashboard.php?action=revoke_room&room_no=${room_no}`, true);
                xhr.onload = function () {
                    if (this.status == 200) {
                        alert('Room revoked successfully.');
                        location.reload();
                    }
                };
                xhr.send();
            }
        </script>
    </div>

    <!-- Send Message Section -->
    <div id="messages" class="section hidden">
        <h2>Send Message to Students</h2>
        <form method="POST" action="admin_dashboard.php?action=send_message">
            <textarea name="message" rows="5" cols="50" placeholder="Type your message here..." required></textarea>
            <input type="text" name="enrollment_no" placeholder="Enrollment Number (Leave empty to send to all)">
            <button type="submit">Send Message</button>
        </form>
    </div>
</div>

<?php
// Continue with action handling
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    // Your code that handles the action goes here
} 
else {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'fetch_student_details':
                if (isset($_GET['enrollment_no'])) {
                    $enrollment_no = $conn->real_escape_string($_GET['enrollment_no']);
                    $sql = "SELECT * FROM student_registration WHERE enrollment_number = '$enrollment_no'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $student = $result->fetch_assoc();
                        echo "<p><strong>Name:</strong> " . htmlspecialchars($student['full_name']) . "</p>";
                        echo "<p><strong>Email:</strong> " . htmlspecialchars($student['email']) . "</p>";
                        echo "<p><strong>Course:</strong> " . htmlspecialchars($student['course']) . "</p>";
                        // Add additional details as needed
                    } else {
                        echo "<p>No student found with this enrollment number.</p>";
                    }
                }
                break;

            case 'solve_complaint':
                if (isset($_GET['complaint_id'], $_GET['student_id'])) {
                    $complaint_id = (int)$_GET['complaint_id'];
                    $student_id = $conn->real_escape_string($_GET['student_id']);
                    $conn->query("DELETE FROM complaints WHERE id = $complaint_id");
                    $conn->query("INSERT INTO messages (student_id, message_text) VALUES ('$student_id', 'Your complaint has been resolved.')");
                    echo "Complaint resolved and message sent.";
                }
                break;

            case 'allot_room':
                if (isset($_GET['room_no'], $_GET['enrollment_no'])) {
                    $room_no = $conn->real_escape_string($_GET['room_no']);
                    $enrollment_no = $conn->real_escape_string($_GET['enrollment_no']);
                    $conn->query("UPDATE room SET status = 1, whom_alloted = '$enrollment_no' WHERE room_no = '$room_no'");
                    echo "Room successfully allotted.";
                }
                break;

            case 'revoke_room':
                if (isset($_GET['room_no'])) {
                    $room_no = $conn->real_escape_string($_GET['room_no']);
                    $conn->query("UPDATE room SET status = 0, whom_alloted = NULL WHERE room_no = '$room_no'");
                    echo "Room successfully revoked.";
                }
                break;

            case 'send_message':
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
                    $message = $conn->real_escape_string($_POST['message']);
                    $enrollment_no = isset($_POST['enrollment_no']) ? $conn->real_escape_string($_POST['enrollment_no']) : null;
                    if ($enrollment_no) {
                        $conn->query("INSERT INTO messages (enrollment_number, message_content) VALUES ('$enrollment_no', '$message')");
                    } else {
                        $result = $conn->query("SELECT enrollment_number FROM student_registration");
                        while ($student = $result->fetch_assoc()) {
                            $enroll_no = $student['enrollment_number'];
                            $conn->query("INSERT INTO messages (enrollment_number, message_content) VALUES ('$enroll_no', '$message')");
                        }
                    }
                    echo "Message sent successfully.";
                }
                break;

            default:
                echo "Invalid action.";
                break;
        }
    } else {
        echo "";
    }
    exit();
}
?>

</body>
</html>
