<?php

if (isset($_POST["ResetPassword"])) {

    $selector = bin2hex(random_bytes(8));
    $token  =   random_bytes(32);

    $url = "www.helpingheroes.co.uk/createNewPassword.php?selector=" . $selector . "&validator=" . bin2hex($token);
    //setes the token to expire in 10 mins 
    $expires = date("U") + 600;

    include("connection.php");

    $userEmail = $_POST["email"];
//delets all data in the table 
    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
       echo "There was an error, please try again.11";
       Exit();

    } else{
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }
//interts the password reset data into the table 
    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
       echo "There was an error, please tey again.12";
       Exit();

    } else{
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);




    //email to the user 

    $to = $userEmail;

    $subject = 'Reset your Helping Heroes Password';

    $message = '<p>We received a request to reset your HelpingHeroes.com account password.  If you didn’t make the request, you can ignore this email. Otherwise, click the link below to change your password.</p>';
    $message .= '<p> Here is your password Reset Link: </br>';
    $message .='<a href="' . $url . '">' . $url . '</a></p>';

    $headers = "From: Adam <noreply@helpingheroes.co.uk>\r\n";
    $headers .="Reply-To: Adam Help@helpingheroes.co.uk\r\n";
    $headers .="content-type: text/html\r\r";

    mail($to, $subject, $message, $headers,"-f noreply@helpingheroes.co.uk");

    header("Location: PasswordReset.php?Reset=EmailSuccess");
} else {
    header("Location: PasswordReset.php");
}