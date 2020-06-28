<?php

if (isset($_POST["ResetPasswordSubmit"])) {

    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwdRepeat"];

// doesnt allow empty fields  and makes sure both fields match 
   if (empty($password) || empty($passwordRepeat)) {
    header("Location: CreateAccount.php?password-empty");
    exit();
    } else if($password != $passwordRepeat) {
        header("Location: CreateAccount.php?password-reset-failed");  
    exit();
    }
//setting the current date to compare the reset expires date, this only lasts 10 mins 
    $currentDate = date("U");
    
    include("connection.php");
//checking the selector is the same in the url compared to the one in the db and checks the date whenb the request was sent to the current date 
    $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >= ? ";
    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
       echo "There was an error, please try again.1";
       Exit();

    } else{
        mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if (!$row = mysqli_fetch_assoc($result)) {
            echo "There was an error, please try again.2";
       Exit();
        } else {
         //changed the hex code back to binary and sets $row as the reset token 
          $tokenBin = hex2bin($validator);  
        $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

        if ($tokenCheck === False) {
                echo "There was an error, please try again.3";
            Exit();
            } elseif ($tokenCheck === true) {
                // checks the token email and the password email are the same, making sre another user cant resdet someone elses password 
                $tokenEmail = $row['pwdResetEmail'];
                //checks the db for the email linked with the password email reset 
                $sql = "SELECT * FROM user WHERE email=?;";
                $stmt = mysqli_stmt_init($link);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "There was an error, please try again.4";
                    Exit();
                }   else {
                    
                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if (!$row = mysqli_fetch_assoc($result)) {
                        echo "There was an error, please try again.5";
                   Exit();
                    } else {
//updates the password for the user 
                        $sql = "UPDATE user SET password=? WHERE email=?;";
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "There was an error, please try again.6";
                            Exit();
                        }   else {
                            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                            mysqli_stmt_execute($stmt);
//delets datya drom the  db relating to thew password reset, so it cant be used again. 
                            $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                                $stmt = mysqli_stmt_init($link);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo "There was an error, please tey again.7";
                                Exit();
//when sucsessfull takes the user top the index page and indicated the password reset was sucsessfull
                                } else{
                                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                    mysqli_stmt_execute($stmt);
                                    header("Location: index.php?passwordUpdated");
                                }                        
                        }
                }
        }
    }
    }
}


} else {
    header("Location: index.php");
}
