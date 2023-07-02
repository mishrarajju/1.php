<?php
// Database configuration
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user details from form submission
$name = $_POST['name'];
$email = $_POST['email'];
$file = $_FILES['pdf_file'];

// Upload the PDF file to a directory on the server
$targetDir = "uploads/";
$fileName = basename($file['name']);
$targetFilePath = $targetDir . $fileName;

if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
    // File uploaded successfully, insert user details into the database
    $sql = "INSERT INTO users (name, email, pdf_file) VALUES ('$name', '$email', '$targetFilePath')";

    if ($conn->query($sql) === TRUE) {
        echo "User details and PDF file inserted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error uploading the PDF file.";
}

// Close the database connection
$conn->close();
?>