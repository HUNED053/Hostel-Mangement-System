<?php
include 'db_connect.php'; // Ensure this points to your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from POST
    $enrollment_number = $_POST['enrollment_number'];
    $password = $_POST['password'];
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $marks = $_POST['marks'];
    $course = $_POST['course'];
    $hobbies = $_POST['hobbies'];
    $parent_name = $_POST['parent_name'];
    $parent_mobile = $_POST['parent_mobile'];
    $emergency_contact = $_POST['emergency_contact'];

    // Insert data into the database
    $sql = "INSERT INTO student_registration (enrollment_number, password, full_name, dob, age, gender, mobile_number, email, address, marks, course, hobbies, parent_name, parent_mobile, emergency_contact) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiisssssssss", $enrollment_number, $password, $full_name, $dob, $age, $gender, $mobile_number, $email, $address, $marks, $course, $hobbies, $parent_name, $parent_mobile, $emergency_contact);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            padding: 20px;
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
            margin-top: 100px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 400px; 
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }
        textarea {
            height: 80px; 
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
    <div class="date-time"></div>
    <a href="index.php">Home</a> <!-- Home Button Added -->
    <a href="about.html">About Us</a>
    <a href="services.html">Services</a>
    <a href="contact.html">Contact</a>
</nav>


    <div class="form-container">
        <h2>Student Registration</h2>
        <form action="" method="POST">
            <input type="text" name="enrollment_number" placeholder="Enrollment Number" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="date" name="dob" placeholder="Date of Birth" required>
            <input type="number" name="age" placeholder="Age" required min="1" max="100">
            <input type="text" name="gender" placeholder="Gender" required>
            <input type="text" name="mobile_number" placeholder="Mobile Number (+91)" pattern="^(\+91)?[0-9]{10}$" required>
            <input type="email" name="email" placeholder="Email" required>
            <textarea name="address" placeholder="Address" required></textarea>
            <input type="number" name="marks" placeholder="Marks" required>
            <select name="course" required>
                <option value="">Select Course</option>
                <option value="computer_science">Computer Science</option>
                <option value="electrical_engineering">Electrical Engineering</option>
                <option value="mechanical_engineering">Mechanical Engineering</option>
                <option value="civil_engineering">Civil Engineering</option>
                <option value="business_administration">Business Administration</option>
            </select>
            <input type="text" name="hobbies" placeholder="Hobbies (comma separated)" required>
            <input type="text" name="parent_name" placeholder="Parent/Guardian Name" required>
            <input type="text" name="parent_mobile" placeholder="Parent Mobile Number (+91)" pattern="^(\+91)?[0-9]{10}$" required>
            <textarea name="emergency_contact" placeholder="Emergency Contact Details" required></textarea>
            
            <button type="submit">Register</button>
            <div class="link">Already have an account? <a href="student_login.php" style="color: #fff;">Login here</a></div>
        </form>
    </div>
   

</body>
</html>
