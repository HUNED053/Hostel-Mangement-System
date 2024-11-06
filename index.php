<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Management System</title>
    
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
        h1 {
            font-size: 3em;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }
        .button {
            display: inline-block;
            padding: 15px 30px;
            margin: 10px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-size: 1.2em;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            cursor: pointer;
        }
        .button:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }
        .button:active {
            transform: scale(0.95);
        }
        .container {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>

    <nav>
        <div class="date-time"></div>
        <a href="about.html">About Us</a>
        <a href="services.html">Services</a>
        <a href="contact.html">Contact</a>
    </nav>

    <div class="container">
        <h1 id="welcomeMessage">Welcome to the Hostel Management System</h1>
        <div>
            <a href="admin_dashboard.php" class="button">Admin Login</a>
            <a href="student_dashboard.php" class="button">Student Login</a>
            <a href="student_registration.php" class="button">Student Registration</a>
        </div>
    </div>

    <script>
        function updateDateTime() {
            const dateTimeElement = document.querySelector('.date-time');
            const now = new Date();
            const dateString = now.toLocaleDateString();
            const timeString = now.toLocaleTimeString();
            dateTimeElement.textContent = `${dateString} | ${timeString}`;
        }
        setInterval(updateDateTime, 1000);
        setTimeout(() => {
            document.getElementById('welcomeMessage').textContent = 'Manage your Hostel with Ease';
        }, 3000);
    </script>
    <footer style="background-color: linear-gradient(135deg, #ff7e5f, #feb47b);; color: #fff; text-align: center; margin-top:200px; padding: 20px,0; position: relative; bottom: 0; width: 100%;">
        <div style="margin-bottom: 10px;">
            
            <h3 style="margin: 0;">Created by [KHAMBHATI HUNED ]</h3>
            <p style="margin: 5px 0;">HOSTEL Management System</p>
        </div>
        <div>
            <p style="margin: 5px 0;">&copy; 2024 All Rights Reserved</p>
            <p style="margin: 5px 0;">Contact: [khambhatijuzer11@gmailcom] </p>
            <p style="margin: 5px 0;">Address: [Anand, khambhat]</p>
        </div>
    </footer>


</body>
</html>
