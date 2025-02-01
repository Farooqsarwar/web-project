<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$host = 'localhost';
$username = 'root'; // Default username for XAMPP
$password = ''; // Default password for XAMPP
$database = 'webproject';

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

// Create the table if it doesn't exist
$table_creation_query = "
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    booking_date DATE NOT NULL,
    booking_time TIME NOT NULL,
    people INT NOT NULL,
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($table_creation_query)) {
  die("Error creating table: " . $conn->error);
}

// Check if the script is accessed via a web server and is a POST request
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitize and validate inputs
  $name = isset($_POST['name']) ? $conn->real_escape_string(trim($_POST['name'])) : '';
  $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : '';
  $phone = isset($_POST['phone']) ? $conn->real_escape_string(trim($_POST['phone'])) : '';
  $date = isset($_POST['date']) ? $conn->real_escape_string(trim($_POST['date'])) : '';
  $time = isset($_POST['time']) ? $conn->real_escape_string(trim($_POST['time'])) : '';
  $people = isset($_POST['people']) ? (int)$_POST['people'] : 0;
  $message = isset($_POST['message']) ? $conn->real_escape_string(trim($_POST['message'])) : '';

  // Validate required fields
  if (!empty($name) && !empty($email) && !empty($phone) && !empty($date) && !empty($time) && $people > 0) {
    // Insert the booking into the database
    $insert_query = "
        INSERT INTO bookings (name, email, phone, booking_date, booking_time, people, message)
        VALUES ('$name', '$email', '$phone', '$date', '$time', $people, '$message')
        ";

    if ($conn->query($insert_query)) {
      echo "Booking successfully recorded!";
    } else {
      echo "Error: " . $conn->error;
    }
  } else {
    echo "Please fill all the required fields correctly.";
  }
} else {
  echo "This script must be accessed via a web server using a POST request.";
}

// Close the database connection
$conn->close();
?>
