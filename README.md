Hostel Management System

This project is a web-based Hostel Management System, designed to streamline hostel operations for students and administrators. 
Students can register, log in, view their profile, submit complaints, and receive notifications from the administration.
The admin dashboard provides features for managing student complaints and messages. 
This project is built with PHP, MySQL, HTML, and CSS.

Table of Contents

-Overview

-Features

-Technology Stack

-Project Structure

-Setup and Installation

-Database Setup

-Usage Instructions

-------------------Overview

The Hostel Management System project enables seamless management of hostel operations. It allows:



--Students: Register, log in, view their profile, lodge complaints, and check messages.

--Admin: Manage student complaints, respond to issues, and send notifications.

-------------------Features

---Student Registration and Login: Secure user authentication.

----Student Dashboard:

---View personal profile details.

---Submit complaints directly to the administration.

---Check messages and notifications from the admin.

----Admin Dashboard:

---Access and manage student complaints.

--Send important notifications to individual students or groups.

--Responsive UI: Optimized for different screen sizes.

------------------Technology Stack

--Frontend: HTML, CSS, JavaScript

--Backend: PHP

--Database: MySQL

------------------Project Structure



hostel-management-system/

├── index.php                 # Main landing page with login

├── student_dashboard.php      # Student dashboard with profile, complaints, and messages

├── admin_dashboard.php        # Admin panel for complaint and message management

├── student_registration.php   # Registration form for students


├── db_connect.php             # Database connection setup

├── about.php                  # Information page about the hostel

├── contact.php                # Contact information page

├── services.php               # Services offered by the hostel

├── footer.php                 # Footer to include on each page

└── style.css                  # Main stylesheet

------------------Setup and Installation

--Prerequisites

---Ensure you have the following installed:



--PHP: Version 8.3 or above


--MySQL: Any recent version

--Web Server: XAMPP, WAMP, or similar (to host PHP and MySQL locally)

-Steps

Clone the Repository:

git clone https://github.com/yourusername/hostel-management-system.git

cd hostel-management-system



Configure Database Connection:



Open db_connect.php and enter your database credentials:

<?php

$host = 'localhost';

$user = 'your_db_user';

$password = 'your_db_password';

$dbname = 'your_database_name';

?>

Run the Application:



Start your web server.

Open a browser and navigate to http://localhost/hostel-management-system/index.php.

Database Setup

Create the Database:


Open a MySQL client (e.g., phpMyAdmin).

Create a new database named hostel_management.

Import Database Tables:



In your MySQL client, go to the Import section.

Import the provided database.sql file (if available). This will set up the necessary tables and their structures.

Database Structure:



Ensure the following tables and columns are created:
----Table: student_registration

Column	Type	Description

*id	-INT (PK)	Auto Increment

*enrollment_number-	VARCHAR(20)	Unique student ID

*password	-VARCHAR(255)	Password

*full_name	-VARCHAR(50)	Full name


*dob-	DATE	Date of birth

*age-	INT	Age

*gender-	VARCHAR(10)	Gender

*mobile_number-	VARCHAR(15)	Contact number

*email	-VARCHAR(50)	Email address

*address-	TEXT	Address

*marks-	DECIMAL(5,2)	Marks

*course-	VARCHAR(30)	Course name

*hobbies-	TEXT	Hobbies

*parent_name-	VARCHAR(50)	Parent/guardian name

*parent_mobile-	VARCHAR(15)	Parent contact number

*emergency_contact-	VARCHAR(15)	Emergency contact number

----Table: complaints

Column	Type	Description

*id	-INT (PK)	Auto Increment

*enrollment_number-	VARCHAR(20)	Student ID

*complaint_text	-TEXT	Complaint details

*status	-VARCHAR(10)	Status of complaint

------able: messages

Column	Type	Description

*id-	INT (PK)	Auto Increment

*enrollment_number-	VARCHAR(20)	Student ID

*message_text	-TEXT	Message content

*sender-	VARCHAR(50)	Admin or system

----------------Usage Instructions

--Student Registration:



New students can register by filling out the form at student_registration.php. Ensure all fields match the database structure.

--Student Login and Dashboard:



Login through index.php with enrollment number and password.

Access profile, submit complaints, and check for messages.

--Admin Dashboard:



Admin can access admin_dashboard.php to view and respond to student complaints and send messages.







