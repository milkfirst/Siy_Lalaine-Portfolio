<?php

require_once('connect.php');

$fname = $_POST['first_name'];
$lname = $_POST['last_name'];
$email = $_POST['email'];
$msg = $_POST['comments'];

$errors = [];

$fname = trim($fname);
$lname = trim($lname);
$email = trim($email);
$msg = trim($msg);

if (empty($lname)) {
    $errors['last_name'] = 'Last Name cant be empty';
}

if (empty($fname)) {
    $errors['first_name'] = 'First Name cant be empty';
}

if (empty($msg)) {
    $errors['comments'] = 'Comment field cant be empty';
}

if (empty($email)) {
    $errors['email'] = 'You must provide an email';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['legit_email'] = 'You must provide a REAL email';
}

if (empty($errors)) {

    $query = "INSERT INTO contacts (last_name, first_name, email, comments) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($connect, $query);

    mysqli_stmt_bind_param($stmt, "ssss", $lname, $fname, $email, $msg);
    mysqli_stmt_execute($stmt);

    if ($stmt) {

        $to = 'lalaine.ellie@gmail.com';
        $subject = 'Message from your Portfolio site!';

        $headers = "From: webmaster@example.com\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/plain; charset=utf-8\r\n";

        $message = "You have received a new contact form submission:\n\n";
        $message .= "Name: " . $fname . " " . $lname . "\n";
        $message .= "Email: " . $email . "\n";
        $message .= "Message: " . $msg . "\n";

        // send
        mail($to, $subject, $message, $headers);

        // exit
        header('Location: thank_you.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>
