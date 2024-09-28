<?php
// Define variables and set to empty values
$nameErr = $emailErr = $subjectErr = $messageErr = "";
$name = $email = $subject = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Validate subject
    if (empty($_POST["subject"])) {
        $subjectErr = "Subject is required";
    } else {
        $subject = test_input($_POST["subject"]);
    }

    // Validate message
    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
    } else {
        $message = test_input($_POST["message"]);
    }

    // If no errors, send email
    if (empty($nameErr) && empty($emailErr) && empty($subjectErr) && empty($messageErr)) {
        $to = "your@email.com"; // Replace with your email address
        $headers = "From: $email";
        $email_subject = "New Contact Form Message: $subject";
        $email_body = "You have received a new message from your website's contact form.\n\n"
            . "Name: $name\n"
            . "Email: $email\n"
            . "Subject: $subject\n"
            . "Message:\n$message";

        if (mail($to, $email_subject, $email_body, $headers)) {
            echo "Thank you for contacting us. We will get back to you soon.";
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
