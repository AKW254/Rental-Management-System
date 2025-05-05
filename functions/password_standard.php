<?php
//Create a function to verify the password standard
function password_standard($password) {
    // Check if the password meets the criteria
    if (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
        return $error;
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $error = "Password must contain at least one uppercase letter.";
        return $error;
    }
    if (!preg_match('/[a-z]/', $password)) {
        $error = "Password must contain at least one lowercase letter.";
        return $error;
    }
    if (!preg_match('/[0-9]/', $password)) {
        $error = "Password must contain at least one number.";
        return $error;
    }
    if (!preg_match('/[\W_]/', $password)) {
        $error = "Password must contain at least one special character.";
        return $error;
    }

    
    return true; // Password meets all criteria
}