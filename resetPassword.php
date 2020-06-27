<?php

if (isset($_POST["ResetPasswordSubmit"])) {

    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwdRepeat"];


   if (empty($password) || empty($passwordRepeat)) {
    header("Location: CreateAccount.php?password-empty");
    exit();
    } else if($password != $passwordRepeat) {
        header("Location: CreateAccount.php?password-reset-failed");  
    exit();
    }

    $currentDate = date("U");
    
    include("connection.php");

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
         
          $tokenBin = hex2bin($validator);  
        $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

        if ($tokenCheck === False) {
                echo "There was an error, please try again.3";
            Exit();
            } elseif ($tokenCheck === true) {
                
                $tokenEmail = $row['pwdResetEmail'];

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

                        $sql = "UPDATE user SET password=? WHERE email=?;";
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "There was an error, please try again.6";
                            Exit();
                        }   else {
                            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                            mysqli_stmt_execute($stmt);

                            $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
                                $stmt = mysqli_stmt_init($link);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo "There was an error, please tey again.7";
                                Exit();

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
