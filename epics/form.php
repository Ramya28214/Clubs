<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "epics";

// Admin email
$admin_email = "clubs5316@gmail.com"; // Change this to your admin email address

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\sendemail\phpmailer\src\Exception.php';
require 'C:\xampp\htdocs\sendemail\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\sendemail\phpmailer\src\SMTP.php';
        

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $Name = $_POST['name'];
    $Email = $_POST['email'];
    $Phone = $_POST['phone'];
    $RollNo = $_POST['roll'];
    $Branch = $_POST['branch'];
    $Clubs = implode(', ', $_POST['clubs']);
    $Feedback = $_POST['feedback'];

    // SQL query to insert form data into database
    $sql = "INSERT INTO formdata (Name, Email, Phone, RollNo, Branch, Clubs, Feedback) VALUES ('$Name', '$Email', '$Phone', '$RollNo', '$Branch', '$Clubs', '$Feedback')";

    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully
        echo "New record created successfully";


    // Compose email message to user
    $to_user = $Email;
    $subject_user = "Club Registration Form Submission";
    $message_user = "Thank you for registering with us!<br><br>";
    $message_user .= "Name: $Name<br>";
    $message_user .= "Email: $Email<br>";
    $message_user .= "Phone: $Phone<br>";
    $message_user .= "Roll No: $RollNo<br>";
    $message_user .= "Branch: $Branch<br>";
    $message_user .= "Clubs: $Clubs<br>";
    $message_user .= "Feedback: $Feedback<br><br>";
    $message_user .= "We will get back to you shortly.";
    
    
    // Send email to user
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'clubs5316@gmail.com';
        $mail->Password = 'kegn qdiw rpms zgia';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        //Recipients
        $mail->setFrom('clubs5316@gmail.com', 'ClubAdmin');
        $mail->addAddress($to_user);     // Add a recipient

        //Content
        $mail->isHTML(true);                                 
        $mail->Subject = $subject_user;
        $mail->Body = $message_user;

        $mail->send();
        echo "Email sent successfully to user!";
        
    } catch (Exception $e) {
        echo "Error sending email: {$mail->ErrorInfo}";
    }

    // Close the mail object
    unset($mail);
    header('Location: tnq.html');
        exit; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}




// Close connection
$conn->close();
?>
